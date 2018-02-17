<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace mappers;

use tm\Mapper;
use tm\Model;

class TransferMapper extends Mapper
{

    public static $db_columnes = ['id', 'user_id' ,'date', 'wallet_id_from', 'wallet_id_to', 'sumFrom', 'sumTo' ,'comment'];
    
    public static function setTable() { 
        return 'doc_transfers';
    }
 

    protected function getPrimaryKey() {
        return 'id';
    }

    public function mapModelToDb(Model $obj) {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_id(),
            'date' => $obj->getDate(),
            'wallet_id_from' => $obj->getWallet_id_from(),
            'wallet_id_to' => $obj->getWallet_id_to(),
            'sumFrom' => $obj->getSumFrom(),
            'sumTo' => $obj->getSumTo(),
            'comment' =>$obj->getComment()
        ];
        
        if (!isset($db_arr['id'])){
            $db_arr['id'] = $this->getGuide();
        }
        
        return $db_arr;
    }
    
       
    public function delete(Model $obj) {
        
    }
}
