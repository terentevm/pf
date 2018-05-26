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
    
    public static $db_columnes = ['id', 'user_id' ,'date', 'dateInt', 'wallet_id', 'sumExpend', 'sumIncome', 'newBalance'];
    
    public static function setTable() { 
        return 'doc_change_balance';
    }
 

    protected function getPrimaryKey() {
        return 'id';
    }

    public function mapModelToDb(Model $obj) {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_id(),
            'date' => $obj->getDate(),
            'dateInt' => strtotime($obj->getDate()),
            'wallet_id' => $obj->getWallet_id(),
            'sumExpend' => $obj->getSumExpend(),
            'sumIncome' => $obj->getSumIncome(),
            'newBalance' => $obj->getNewBalance()
            
        ];
        
        if (!isset($db_arr['id'])){
            $db_arr['id'] = $this->getGuide();
        }
        
        return $db_arr;
    }
    
       
    
    protected function afterSave($obj) {
        $regMoney = new \app\Models\RegMoneyTransactions();
        $regMoney->loadModel($obj);
        $success = $regMoney->save(false);

        unset($regMoney);

        return $success;
    }
    
    protected function afterUpdate($obj) {
        $regMoney = new \app\Models\RegMoneyTransactions();
        $regMoney->loadModel($obj);
        $success = $regMoney->save(false);

        unset($regMoney);

        return $success;
    }
}
