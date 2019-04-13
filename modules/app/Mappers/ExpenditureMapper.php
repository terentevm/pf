<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

use tm\Mapper;
use tm\Model;
use app\Mappers\RegExpensesMapper;

class ExpenditureMapper extends Mapper
{
    public static $db_columns = ['id', 'user_id', 'date', 'dateint', 'sum', 'comment', 'wallet_id'];

    public static function setTable()
    {
        return 'doc_expend';
    }
    
    public static function getWallet()
    {
        return [
                'model' => 'Wallet',
                'f_key' => 'wallet_id',
                'table_col' => 'id'
            ];
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
            'comment' =>$obj->getComment(),
            'wallet_id' => $obj->getWallet_id(),
            'sum' => $obj->getSum()
        ];
        
        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
            $obj->setId($db_arr['id'] );
        }
        
        return $db_arr;
    }

    public function deleteRows(string $docId)
    {
        $sql = "DELETE FROM doc_expend_rows where doc_id = :docId";

        $deleted = $this->db->run($sql, ["docId" => $docId]);

        return $deleted;


    }

}
