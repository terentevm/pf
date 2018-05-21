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
    public static $db_columnes = ['user_id' , 'currency_id', 'wallet_id'];
    
    public static function setTable() {
        return "settings";
    }
    
    protected function getPrimaryKey() {
        return 'user_id';
    }
    
    
    public function mapModelToDb(Model $obj) {
        $db_arr = [     
            'user_id' => $obj->getUser_Id(),
            'currency_id' => $obj->getCurrency_id(),
            'wallet_id' => $obj->getWallet_id()
        ];    
        
        return $db_arr;
    }

    protected function afterSave($obj)
    {
        $success = Currency::saveSystemCurrensy($obj->getUser_Id()) ;

        if ($success === false) {
            return false;
        }

        $sysCurrency = Currency::SystemCurrensy();

        $record = [
            'id' => null,
            'currency_id' =>  $sysCurrency->getId(),
            'date' => "1980-01-01",
            'dateInt' => strtotime("1980-01-01"),
            'mult' => 1,
            'rate' => 1
        ];

        $rates = new Rates();
        $rates->setDataset(array($record));
        $success = $rates->save();
        
        return $success;
    }
}
