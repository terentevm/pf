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
 * Description of ProgramSettings
 *
 * @author terentyev.m
 */
class ProgramSettings extends Model {
    
    private $user_id;
    private $main_currency_id;
    private $main_currency_name;
    private $sys_currency_id;
    private $sys_currency_name;
    private $central_bank;

    use TraitModelFunc;

    public static function setTableName() {
        return 'ProgramSettings';
    }

    public static function getPrimaryKeys(){
        return ['user_id'];
    }

    public static function getForeignKeys() {
        return [
		'user_id' => [
			'key' => 'id',
			'table' => 'users'
            ],
        'main_currency_id' => [
            'key' => 'id',
            'table' => 'dic_currency'
            ],
        'sys_currency_id' => [
            'key' => 'id',
            'table' => 'dic_currency'
            ]
                ];
    }
}
