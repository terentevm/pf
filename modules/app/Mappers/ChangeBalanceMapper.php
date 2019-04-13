<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class ChangeBalanceMapper extends Mapper
{
    public static $db_columns = [
        'id',
        'user_id',
        'date',
        'dateint',
        'wallet_id',
        'sum_expend',
        'sum_income',
        'new_balance'
    ];
    
    public static function setTable()
    {
        return 'doc_change_balance';
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
            'wallet_id' => $obj->getWallet_id(),
            'sum_expend' => $obj->getSumExpend(),
            'sum_income' => $obj->getSumIncome(),
            'new_balance' => $obj->getNewBalance()
            
        ];
        
        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
            $obj->setId($db_arr['id']);
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
    
    protected function afterUpdate($obj)
    {
        $regMoney = new \app\Models\RegMoneyTransactions();
        $regMoney->loadModel($obj);
        $success = $regMoney->save(false);

        unset($regMoney);

        return $success;
    }
}
