<?php

namespace tm;

use tm\Base;
use tm\MapperTrait;
use tm\Registry;
use tm\database\AbstractDb;

class Mapper extends Base
{
    use MapperTrait;

    public static function getMapper($type) {

        $type = preg_replace( '|^.*\\\|', "", $type );
        $mapper = "\\mappers\\{$type}Mapper";
        if ( class_exists( $mapper ) ) {
            return new $mapper();
        }
        throw new \Exception( "Unknown: $mapper" );
    }

    public function all() {

        $db = AbstractDb::init();
        list($sql, $params) = $db->getQueryBuilder()->build($this);

        $rows = $db->query($sql, $params);
        
       $result_data = $this->processRelations($rows);
        
        return $result_data ;
    }

    public function one() {
        $db = AbstractDb::init();
        
        list($sql, $params) = $db->getQueryBuilder()->build($this);

        $query_result = $db->queryOne($sql, $params);

        return $query_result;
    }

    public function processRelations(&$data) {
        if (empty($this->with)) {
            return $data;
        }
        
        foreach ($this->with as $table) {
            $this->processRelation($data,$table) ; 
        }
        
        return $data;
    }
    
    public function processRelation(&$data, $tableName) {
        $relation = $this->getRelation($tableName);
        
        $keys_arr = $this->getKeysArray($data, $relation['f_key']);
            
        if (is_null($keys_arr)) {
            throw new \Exception("Primary model doesn't contain foreign key {$relation['f_key']}") ;
        }
            
        $this->addDataFromForeignTable($data, $keys_arr, $tableName, $relation);
        
        return $data;
    }
    
    protected function addDataFromForeignTable(&$data, $keys_arr, $tableName, $relation) {
        
        $condition = QueryBuilder::createTextConditionFromArray($relation['table_col'], $keys_arr);
        
        $class_name = '\\models\\' . $tableName;
        
        $rows = $class_name::find()->where([$condition])->all();
        
        $result = $this->addRelationsToResult($data, $rows, $relation['f_key'], $relation['table_col'], $tableName);
        
        return $result;
    }

    public function getRelation($tableName) {
        
        $method_name = 'get' . ucfirst($tableName);
        
        if (method_exists($this, $method_name)) {
            $relations = $this->$method_name();
            
            if (!is_array($relations)) {
               throw new \Exception("Method {$method_name} isn't returned array"); 
            }
        }
        else {
            $class_name = get_class($this);
            throw new \Exception("Mapper class {$class_name} doesn't contain getter-method {$method_name} ");
        }
        
        return $relations;
    }
    
    public function getKeysArray(&$data, $column_key) {
        //if (array_key_exists($column_key, $data)) {
            return array_column($data, $column_key);
      //  }
        
      //  return null; //wrong key name
    }
    
    protected function addRelationsToResult(&$primary_arr,$relations_arr, $f_key, $table_column,$relation_name) {
        
        $search_arr = array_combine(array_column($relations_arr,$table_column), $relations_arr);
        
        foreach ($primary_arr as &$item) {
            $str_rel = $search_arr[$item[$f_key]];
            $item[$relation_name] = $str_rel;
        } 
        
        return $primary_arr;
    }
}