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
    
    use Base\TraitModelFunc;
    

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
