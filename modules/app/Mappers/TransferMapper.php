<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class TransferMapper extends Mapper
{
    public static $db_columnes = ['id', 'user_id' ,'date', 'dateInt', 'wallet_id_from', 'wallet_id_to', 'sumFrom', 'sumTo' ,'comment'];
    
    public static function setTable()
    {
        return 'doc_transfers';
    }
 

    protected function getPrimaryKey()
    {
        return 'id';
    }

    public static function getWalletFrom()
    {
        return [
                'model' => 'Wallet',
                'f_key' => 'wallet_id_from',
                'table_col' => 'id'
            ];
    }

    public static function getWalletTo()
    {
        return [
                'model' => 'Wallet',
                'f_key' => 'wallet_id_to',
                'table_col' => 'id'
            ];
    }

    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_id(),
            'date' => $obj->getDate(),
            'dateInt' => strtotime($obj->getDate()),
            'wallet_id_from' => $obj->getWallet_id_from(),
            'wallet_id_to' => $obj->getWallet_id_to(),
            'sumFrom' => $obj->getSumFrom(),
            'sumTo' => $obj->getSumTo(),
            'comment' =>$obj->getComment()
        ];
        
        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
            $obj->setId($db_arr['id'] );
        }
        
        return $db_arr;
    }

    public function update(Model $obj, array $colsForUpdate)
    {
        $sql = $this->qb->buildUpdate($this, $colsForUpdate);
        $this->update_stmt = $this->db->prepare($sql);

        $this->db->beginTransaction();

        $success = $this->update_stmt->execute($colsForUpdate);

        if ($success === false) {

            $this->db->rollBackTransaction();

            return false;

        }


        $success = $this->afterSave($obj);

        if ($this->db->transactionExists()) {
            if ($success) {
                $this->db->commitTransaction();
            } else {
                $this->db->rollBackTransaction();
            }
        }


        return $success;

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
