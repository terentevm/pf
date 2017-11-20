<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;
use Base\Model;
use Base\TraitModelFunc;
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
    
    use TraitModelFunc;
    
    public static function setTableName(){
        return 'wallets';
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
