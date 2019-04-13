<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

use tm\Mapper;
use tm\Model;
use app\Models\RegMoneyTransactions;

class RegMoneyTransactionsMapper extends Mapper
{
    public static $db_columns = [
        'date',
        'dateint',
        'wallet_id',
        'sum',
        'expend_id',
        'income_id',
        'transfer_id',
        'cb_id',
        'lend_id',
        'user_id'
    ];
    
    public static function setTable()
    {
        return 'reg_money_trans';
    }

    protected function getPrimaryKey()
    {
        return 'id';
    }

    public function mapModelToDb(Model $obj)
    {
    }

    public function save(Model $obj)
    {
        $rows = $obj->getRows();
        
        if (empty($rows)) {
            return false;
        }
        
        if ($this->create_stmt === null) {
            $sql = $this->qb->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }


        $deleted = $this->deleteReg($obj);

        if ($deleted === false) {
            return false;
        }

        foreach ($rows as $record) {

            $success = $this->db->runStatement($this->create_stmt, $record);

            if ($success === false) {
                return false;
            }
        }
        
        return true;
    }
    
    public function deleteReg(Model $obj)
    {
        $model_id = $obj->getModelId();
        $col_name = $obj->getCondCol();
        $sql = 'DELETE FROM ' . $this->setTable() . ' WHERE ' . $col_name . ' = :model_id';

        $deleted = $this->db->run($sql, ["model_id" => $model_id]);

        return $deleted;
    }
}
