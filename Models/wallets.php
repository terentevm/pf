<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;
use Base\Model;

/**
 * Description of wallets
 *
 * @author terentyev.m
 */
class Wallets extends Model {
    
    private $id = null;
    private $name = '';
    private $user_id = '';
    private $is_creditcard = 0; 
    private $currency_id = '';
    private $grace_period = 0;
    private $credit_limit = 0;
    
    public $attributes = [
        'id' => '',
        'name' => '',
        'user_id' => '',
        'is_creditcard' => 0,
        'currency_id' => '',
        'grace_period' => 0,
        'credit_limit' => 0
    ];
    
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
    public static function setTableName(){
        return 'wallets';
    }
    
    public function getDbColumnes(){
        
        return ['id', 'name', 'user_id', 'is_creditcard', 'currency_id', 'grace_period', 'credit_limit'];
        
    }
    
    public static function getForeignKeys() {
        return [
            'currency_id' => [
                'key' => 'id',
                'table' => 'dic_currency'
            ],
            'user_id' => [
                'key' => 'id',
                'table' => 'users'
            ],
        ];
    }
    public static function getPrimaryKeys(){
        return ['id'];
    }
}
