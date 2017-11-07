<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;
use Base\Model;
/**
 * Description of Currency
 *
 * @author terentyev.m
 */
class Currency extends Model {
  
    private $id;
    private $code = '';
    private $name = '';
    private $short_name = '';
    private $user_id;
    
    public function load($attributes = []){
        
        foreach ($attributes as $property => $value){
            
            $this->set($property, $value);   
     
        }
        
    }
    
    public function set($property, $value){
 
        if (property_exists($this, $property)){
            $this->$property = $value;   
        }
        
    }
    
    public function get($property){
 
        if (property_exists($this, $property)){
            return $this->$property;   
        } else{
            return null;
        }
        
    }
    
    public function getProperties(){
        
        return get_object_vars($this);
        
    }
    public function getDbColumnes(){
        
        return ['id', 'code', 'name', 'short_name', 'user_id'];
        
    }
    public static function setTableName(){
        return 'dic_currency';
    }
    
    public static function getForeignKeys() {
        return [
		'user_id' => [
			'key' => 'id',
			'table' => 'users'
                    ]
                ];
    }
    
    public static function getPrimaryKeys(){
        return ['id'];
    }
    
}
