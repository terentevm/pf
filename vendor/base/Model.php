<?php

namespace Base;

use Base\Db;
use Base\QueryBuilder;

class Model{
    
    protected $pdo;
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
        $this->pdo = Db::Instance();
    }
    
    public function load($data){
        
        $ClassName = get_called_class();
        
        $ClassAttributes = get_class_vars($ClassName);
        
        foreach($ClassAttributes  as $attribute){
            if(isset($data[$attribute]) && !empty($data[$attribute])){
                $this->attributes[$attribute] = $data[$attribute];
            }
        }
        if(isset($this->attributes['user_id'])){
            $this->attributes['user_id'] = $_SESSION['user_id'];   
        }
    }
    


    public static function getGuide(){
        if (function_exists('com_create_guid') === true){
            return trim(com_create_guid(), '{}');
        }
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));    
    }
    
    public function find($column_names =''){
        $ClassName = get_called_class(); 
        $table = $ClassName::setTableName();
        self::$instance = new $ClassName();
        self::select($table, '', $column_names);
        return self::$instance ;
    }
    
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
        $properties = $this->getProperties();
        $is_new = false;
		
        foreach ($pk as $key){
            if(!isset($properties[$key])){
                 $is_new = true;
				$this->set($key, $this->getGuide());    
            }
        }
        
        if (property_exists($this, 'user_id') && !isset($this->user_id)){
            $this->set('user_id', $_SESSION['user_id']);   
        }
        
        $DbColumnes= $this->getDbColumnes();
        self::$instance = $this;
        
		if ($is_new) {
			self::$sql = self::insert(static::setTableName(), $DbColumnes);	
		}
		else {
			self::$sql = self::update(static::setTableName(), $DbColumnes);	
		}
       
        if ($this->stmt === null){
        
            $this->stmt = $this->pdo->prepare(self::$sql);
                
        }
        self::$param = [];
        foreach ($DbColumnes as $column){

            self::$param[$column] = $this->get($column);
 
        }
        
        $success = $this->stmt->execute(self::$param);
        
        return $success;
       
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
        
        self::$prefix = self::$prefix . ',' . self::addPrefixToColumnNames($table_prefix, $fields);
        
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
    
	public static function Update($table, $fields =[]){
       
        self::$prefix = 'UPDATE ' . $table . ' SET ' . self::CreatePart_On_Duplicate($fields);
        
        return self::$instance;    
    }
	
    public static function orUpdate($fields =[]){
        
        $temp_prefix = self::$prefix;
        
        $sql_OnUpdate = ' ON DUPLICATE KEY UPDATE ' . self::CreatePart_On_Duplicate($fields);
        
        self::$prefix = $temp_prefix . $sql_OnUpdate;
        
        return self::$instance;
    }
    

    
    public static function Where($condition = []){
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
    public static function addPrefixToColumnNames($prefix, $column_names) {

        $fields_arr = explode(',', $column_names);

        foreach ($fields_arr as &$col) {
            $col = $prefix . '.' . trim($col);
        }

        $column_names_pref = implode(',', $fields_arr);

        return $column_names_pref;
    }
    
    
}