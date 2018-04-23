<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class SettingsMapper extends Mapper
{
    public static $db_columnes = ['user_id' , 'currency_id', 'wallet_id'];
    
    public static function setTable() {
        return "settings";
    }
    
    protected function getPrimaryKey() {
        return 'user_id';
    }
    
    public function delete(\tm\Model $obj) {
        
        if ($this->delete_stmt === null) {
            $this->where = ['user_id = :user_id'];

            $sql = $this->qb->buildDelete($this);
            $this->delete_stmt = $this->db->prepare($sql);
        }
        
        $param = $this->mapModelToDb($obj);
        $success = $this->create_stmt->execute($param);

        return $success; 
    }
    
    public function mapModelToDb(Model $obj) {
        $db_arr = [     
            'user_id' => $obj->getUser_Id(),
            'currency_id' => $obj->getCurrency_id(),
            'wallet_id' => $obj->getWallet_id()
        ];    
        
        return $db_arr;
    }
}
