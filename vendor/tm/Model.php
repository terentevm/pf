<?php

namespace tm;

use tm\database\AbstractDb;
use tm\Mapper;

class Model{
    
    protected $stmt;
    protected $table;
    protected static $sql = '';
    public static $mainTablePrefix = '';
    public static $prefix = '';
    public static $from = '';
    public static $join = '';
    public static $instance = NULL;
    public static $where = [];
    public static $control = [];
    public static $param = [];
    public $attributes = [];

    public function __Construct()
    {
       
        self::$sql = '';
        self::$mainTablePrefix = '';
        self::$prefix = '';
        self::$from = '';
        self::$join = '';
        self::$instance = NULL;
        self::$where = [];
        self::$control = [];
        self::$param = [];
    }
    
    public static function find() {
        return Mapper::getMapper(get_called_class());
    }

    protected function getDb() {
        return AbstractDb::init();
    }

    public function load($attributes = []) {
        foreach ($attributes as $property => $value){
            
            $this->set($property, $value);   
     
        }
    }

   
    
    public function getObjectVars($use_mapping = false) {

        $reflect = new \ReflectionObject($this);

        $props = $reflect->getProperties(\ReflectionProperty::IS_PRIVATE);

        $obj_val = [];

        if ($use_mapping) {
            $mapping = $this->getMapping();
        }

        foreach ($props as $prop) {

            $prop_value = $this->get($prop->name);

            if ($use_mapping && is_array($mapping) && !empty($mapping)) {

                if (array_key_exists($prop->name, $mapping)) {
                    $prop_name = $mapping[$prop->name];
                } else {
                    continue;
                }
            } else {
                $prop_name = $prop->name;
            }
            $obj_val[$prop_name] = $prop_value;
        }

        return $obj_val;
    }

    /*public function find($column_names =''){
        $ClassName = get_called_class(); 
        $table = $ClassName::setTableName();
        self::$instance = new $ClassName();
        self::select($table, '', $column_names);
        return self::$instance ;
    }*/
    /*
    */
    public static function findView($column_names, $f_fields = []) {
        $ClassName = get_called_class();
        
        $table = $ClassName::setTableName();
        self::$instance = new $ClassName();
        self::select($table, 't1', $column_names);
        
        self::$mainTablePrefix = 't1';
       
        $tables_LJ = [];


        if (!empty($f_fields)) {

            $fk = get_called_class()::getForeignKeys();

            if (is_array($fk) && !empty($fk)) {
                $t_ind = 2;
                foreach ($f_fields as $key => $fields) {
                    $t_pref = 't' . $t_ind;

                    if (array_key_exists($key, $fk)) {

                        $tables_LJ[] = [
                            'table' => $fk[$key]['table'],
                            'prefix' => $t_pref,
                            'fields' =>$fields,
                            'conditions' => Array([
                                    'col1' => $key,
                                    'type_cmp' => '=',
                                    'col2' => $fk[$key]['key']
                                ])
                        ];
                    }

                    $t_ind = $t_ind + 1;
                }
            }
        }

        foreach ($tables_LJ as $element) {
            self::leftJoin($element['table'],$element['fields'], $element['conditions'], self::$mainTablePrefix, $element['prefix']);
  
        }

        return self::$instance ;
    }



    public function query($sql)
    {
        return $this->pdo->execute($sql);
    }

    public function selectAll()
    {
        self::$sql = self::getSql();
        return $this->pdo->Query(self::$sql,self::$param);
    }
    
    public function Save(){
        
        $pk = $this->getPrimaryKeys();

        $is_new = false;
		
        foreach ($pk as $key){
            if(empty($this->get($key))){
                $is_new = true;
		$this->set($key, $this->getGuide());    
            }
        }
        
        if (property_exists($this, 'user_id') && !isset($this->user_id)){
            $this->set('user_id', $_SESSION['user_id']);   
        }
        
        $obj_as_array = $this->getObjectVars(true);

        $DbColumnes = $this->getDbColumnes($obj_as_array);

        self::$instance = $this;
        
		if ($is_new) {
			self::$sql = self::insert(static::setTableName(), $DbColumnes)->getSql();	
		}
		else {
                  
            self::$sql = self::update(static::setTableName(), $DbColumnes)->where(['id', '=', $this->get('id')])->getSql();	
		}
       
        if ($this->stmt === null){
        
            $this->stmt = $this->pdo->prepare(self::$sql);
                
        }
        
        $success = $this->stmt->execute($obj_as_array);
        
        return $success;
       
    }
    
    public function getDbColumnes($obj_vars) {
        $keys = array_keys($obj_vars);

        return $keys;
        
    }
    
    public function CreateCoulmns(){
        $columns = [];
        
        foreach ($this->attributes as $key=>$value){
            $columns[] = $key;    
        }
        
        return $columns;
    }
    
    public static function select($table, $table_prefix ='', $fields =''){
        
        
        
        $prefix_part = ($table_prefix == '') ? '' : ' AS ' . $table_prefix;
        if ($fields) {
            $fields_str = ($table_prefix == '') ? $fields : self::addPrefixToColumnNames($table_prefix, $fields);
            
            self::$prefix = 'SELECT ' . $fields_str ;
            self::$from = ' FROM ' . $table . $prefix_part;
        } 
        else {

            self::$prefix = 'SELECT * ';
            self::$from = 'FROM ' . $table . $prefix_part;
        }
        return self::$instance;
    }
    
    public static function leftJoin($table, $fields, $conditions, $main_table_prefix, $table_prefix) {
        
        self::$prefix = self::$prefix . ',' . self::addPrefixToColumnNames($table_prefix, $fields, $table);
        
        $part = " LEFT JOIN " . $table . " AS " . $table_prefix . ' ON ';
        $partON = '';

        $isFirst = true;
        foreach ($conditions as $condition) {
            if ($isFirst) {
                $partON = $partON . $main_table_prefix . '.' . trim($condition['col1']) . $condition['type_cmp'] . $table_prefix . '.' . trim($condition['col2']);
            } else {
                $partON = $partON . " AND " . $main_table_prefix . '.' . trim($condition['col1']) . $condition['type_cmp'] . $table_prefix . '.' . trim($condition['col2']);
            }
        }

        self::$join = self::$join . $part . $partON . ' ';
        return self::$instance;
    }
    
    public static function insert($table, $fields =[]){
       
        $fields_str = implode(',', $fields);
        
        self::$prefix = 'INSERT INTO ' . $table . ' (' .$fields_str . ') VALUES (' . self::ArrayToParametres($fields) . ')' ;
        
        return self::$instance;
    }
    
	public static function update($table, $fields =[]){
       
        self::$prefix = 'UPDATE ' . $table . ' SET ' . self::CreatePart_On_Duplicate($fields);
        
        return self::$instance;    
    }
	
    public static function orUpdate($fields =[]){
        
        $temp_prefix = self::$prefix;
        
        $sql_OnUpdate = ' ON DUPLICATE KEY UPDATE ' . self::CreatePart_On_Duplicate($fields);
        
        self::$prefix = $temp_prefix . $sql_OnUpdate;
        
        return self::$instance;
    }
    

    
    public static function where($condition = []){
        $pref = (self::$mainTablePrefix == '') ? '' : self::$mainTablePrefix . '.';
        self::$where[0] = ' WHERE ' . $pref . $condition[0] . $condition[1] . ':' . $condition[0] ;
        self::$param[$condition[0]] = $condition[2];
        return self::$instance;
    }
    
    
    public static function _and($condition = NULL){
        self::$where[] = trim('AND ' . $condition);
        return self::$instance;
    }
    
    public static function _or($a = NULL){
        self::$where[] = trim('OR ' . $a);
        return self::$instance;
    }
    
    public static function limit($limit, $offset = 0){
        if ($offset > 0){
            self::$control[0] = 'LIMIT ' . $offset . ',' . $limit;   
        }
        else{
            self::$control[0] = 'LIMIT ' . $limit;
        }
        
        return self::$instance;
    }
   
    public static function offset($offset){
        self::$control[1] = 'OFFSET ' . $offset;
        return self::$instance;
    }
    
    public static function getSql(){
        self::$sql = self::$prefix . self::$from . self::$join
        . implode(' ', self::$where)
        . ' '
        . self::$control[0]
        . ' '
        . self::$control[1];
        preg_replace('/ /', ' ', self::$sql);
        return trim(self::$sql);
    }
    
    public static function arrayToParametres($values = []){
        
        $str_params = '';
        $is_first = TRUE;
        foreach ($values as $value){
            if($is_first == TRUE){
                
                $str_params .= ':' . $value;
                $is_first = FALSE;
            }
            else {
                $str_params = $str_params . ', :' .  $value;
            }
        }
        
        return $str_params;
    }
    
    public static function createPart_On_Duplicate($values = []){
        $str_params = '';
        $is_first = TRUE;
        foreach ($values as $value){
            if($is_first == TRUE){
                
                $str_params .=  $value . ' = :' . $value;
                $is_first = FALSE;
            }
            else {
                $str_params = $str_params . ',' . $value . ' = :' .  $value;
            }
        }
        
        return $str_params;
    }
    
    /**
    *	Return string with columnes names with table prefix
    *	t1.column1, t1.column ....
    *	@param string table prefix
    *	@param string column names ('col1, col2, col3')
    */
    public static function addPrefixToColumnNames($prefix, $column_names, $table_name ='') {

        $fields_arr = explode(',', $column_names);

        foreach ($fields_arr as &$col) {
            if(!$table_name == ''){
                $col = trim($col) . ' AS ' . $table_name . '_' . $col;   //for example: $col = "name", $table_name = "titles", result = AS titles_name
            } 
            $col = $prefix . '.' . trim($col);
 
        }

        $column_names_pref = implode(',', $fields_arr);

        return $column_names_pref;
    }
    
    
}