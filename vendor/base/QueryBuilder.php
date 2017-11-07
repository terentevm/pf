<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Base;

use Base\Model;
/**
 * Description of QueryBuilder
 *
 * @author terentyev.m
 */
class QueryBuilder {
    
    public static $sql = '';
    public static $prefix = '';
    public static $from = '';
    public static $join = '';
    public static $instance = NULL;
    public static $where = [];
    public static $control = [];
    public static $param = [];
    
    public static function select($table, $table_prefix ='', $fields =''){
        
        self::$instance = new QueryBuilder();
        
        $prefix_part = (table_prefix == '') ? '' : 'AS ' . $table_prefix;
        if ($fields) {
            $fields_str = (table_prefix == '') ? $fields : self::addPrefixToColumnNames($table_prefix, $fields);
            
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
        
        $part = "LEFT JOIN " . $table . " AS " . $table_prefix . ' ON ';
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
        self::$instance = new QueryBuilder();
        $fields_str = implode(',', $fields);
        
        self::$prefix = 'INSERT INTO ' . $table . ' (' .$fields_str . ') VALUES (' . self::ArrayToParametres($fields) . ')' ;
        
        return self::$instance;
    }
    
    public static function orUpdate($fields =[]){
        
        $temp_prefix = self::$prefix;
        
        $sql_OnUpdate = ' ON DUPLICATE KEY UPDATE ' . self::CreatePart_On_Duplicate($fields);
        
        self::$prefix = $temp_prefix . $sql_OnUpdate;
        
        return self::$instance;
    }
    
    public static function Update($table, $fields =[]){
        self::$instance = new QueryBuilder();
        
        self::$prefix = ' UPDATE ' . $table . ' SET ' . self::CreatePart_On_Duplicate($fields);
        
        return self::$instance;    
    }
    
    public static function Where($condition = []){
        
        self::$where[0] = ' WHERE ' . $condition[0] . $condition[1] . ':' . $condition[0] ;
        self::$param[] = [$condition[0] =>  $condition[2]];
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
    
    public static function limit($limit){
        self::$control[0] = 'LIMIT ' . $limit;
        return self::$instance;
    }
   
    public static function offset($offset){
        self::$control[1] = 'OFFSET ' . $offset;
        return self::$instance;
    }
    
    public static function getSql(){
        self::$sql = self::$prefix
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
