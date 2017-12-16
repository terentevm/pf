<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace mappers;

use tm\Mapper;
/**
 * Description of WalletMapper
 *
 * @author terentyev.m
 */
class WalletsMapper extends Mapper
{
    public static $db_columnes = ['id', 'name', 'currency_id', 'is_creditcard', 'grace_period'];
    
    public static function setTable() {
        return "wallets";
    }
    
    public static function getCurrency() {
        return [
                'f_key' => 'currency_id',
                'table_col' => 'id'
            ];
    }
}
