<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class LendMapper extends Mapper
{
    public static $db_columns = ['id', 'user_id', 'date', 'dateint', 'wallet_id', 'contact', 'sum'];
    
    public static function setTable()
    {
        return 'lend';
    }

    protected function getPrimaryKey()
    {
        return 'id';
    }

    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_id(),
            'date' => $obj->getDate(),
            'dateint' => strtotime($obj->getDate()),
            'contact' =>$obj->getContact(),
            'wallet_id' => $obj->getWallet_id(),
            'sum' => $obj->getSum()
        ];
        
        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
            $obj->setId($db_arr['id'] );
        }
        
        return $db_arr;
    }
    
    protected function afterSave($obj)
    {
        $regMoney = new \app\Models\RegMoneyTransactions();
        $regMoney->loadModel($obj);
        $success = $regMoney->save(false);

        unset($regMoney);

        return $success;
    }
}
