<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace mappers;

use tm\Mapper;
use tm\Model;
use Models\RegMoneyTransactions;

class RegMoneyTransactionsMapper extends Mapper
{
    public static $db_columnes = ['date', 'wallet_id', 'sum', 'expend_id', 'income_id', 'transfer_id', 'cb_id'];
    
    public static function setTable() { 
        return 'regMoneyTrans';
    }

    protected function getPrimaryKey() {
        return 'id';
    }

    public function mapModelToDb(Model $obj) {
        
    }
    
    public function save(Model $obj, $upload_mode = false, $useTransaction = false) {
        
        $rows = $obj->getRows();
        
        if (empty($rows)) {
            return false;
        }
        
        if ($this->create_stmt === null) {
            $sql = $this->db->getQueryBuilder()->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }
        
        
        $this->delete($obj);
        
        foreach ($rows as $record) {
            $success = $this->create_stmt->execute($record);
            
            if ($success === false) {
           
                return false;
            }
        }
        
        return true;
    }
    
    public function delete(Model $obj) {
        $model_id = $obj->getModelId();
        $col_name = $obj->getCondCol();
        $sql = 'DELETE FROM ' . $this->setTable() . ' WHERE ' . $col_name . ' = :model_id';
        
        $this->delete_stmt = $this->db->prepare($sql);
        $success = $this->delete_stmt->execute(['model_id' => $model_id]);
        
        return $success;
    }
    
}
