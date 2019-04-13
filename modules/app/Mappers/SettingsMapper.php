<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

use tm\Mapper;
use tm\Model;
use app\Models\Currency;
use app\Models\Rates;

class SettingsMapper extends Mapper
{
    public static $db_columns = ['user_id', 'currency_id', 'wallet_id', 'report_currency'];
    
    public static function setTable()
    {
        return "settings";
    }
    
    protected function getPrimaryKey()
    {
        return 'user_id';
    }

    public static function getCurrency()
    {
        return [
            'model' => 'Currency',
            'f_key' => 'currency_id',
            'table_col' => 'id'
        ];
    }

    public static function getReportCurrency()
    {
        return [
            'model' => 'Currency',
            'f_key' => 'reportCurrency',
            'table_col' => 'id'
        ];
    }

    public static function getWallet()
    {
        return [
            'model' => 'Wallet',
            'f_key' => 'wallet_id',
            'table_col' => 'id'
        ];
    }

    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'user_id' => $obj->getUser_Id(),
            'currency_id' => $obj->getCurrency_id(),
            'wallet_id' => $obj->getWallet_id(),
            'report_currency' => $obj->getReportCurrency()
        ];
        
        return $db_arr;
    }
}