<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace mappers;
use tm\Mapper;
use tm\Model;

class ExpenditureMapper extends Mapper
{
    public static $db_columnes = ['id', 'user_id', 'date', 'comment', 'wallet_id'];

    public static function setTable() { 
        return 'doc_expend';
    }
    
    public static function getWallet() {
        return [
                'f_key' => 'wallet_id',
                'table_col' => 'id'
            ];
    }

    public function delete(Model $obj) {
        
    }

    protected function getPrimaryKey() {
        return 'id';
    }

    public function mapModelToDb(Model $obj) {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_id(),
            'date' => $obj->getDate(),
            'comment' =>$obj->getComment(),
            'wallet_id' => $obj->getWallet_id()
        ];
        
        if (!isset($db_arr['id'])){
            $db_arr['id'] = $this->getGuide();
        }
        
        return $db_arr;
    }


    protected function create(Model $obj) {
         
        if ($this->create_stmt === null) {
            $sql = $this->db->getQueryBuilder()->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }
        
        $param = $this->mapModelToDb($obj);
        
      //  $this->db->beginTransaction();
        
                        
        $success = $this->create_stmt->execute($param);
        
        if ($success !== true) {
            return false;
        }
        
        
        foreach ($obj->rows->strings() as $row) {
            $row->setDocId($param['id']);
            $row_mapper = $this->getMapper("Models\ExpenditureRow");
            $saved = $row_mapper->save($row);
            
            if ($saved === false){
                $this->db->rollBackTransaction();
                return false;
            }
        }
        
        
       // $this->db->commitTransaction();
        
        return $success;
    }
    
    protected function afterSave($obj) {
        $sql = "insert into regMoneyTrans (date, expend_id, wallet_id, currensy_id, sum)
        SELECT * FROM (
    SELECT 
	doc.date as date,
    sub1.doc_id as expend_id,
    doc.wallet_id as wallet_id,
    wal.currency_id as currensy_id,
    sum(sub1.sum) as sum
FROM (SELECT
    doc_id as doc_id,
    item_id as item_id,
    SUM(sum * -1 ) as sum
FROM
	doc_expend_rows
where doc_id = :doc_id
group by
	doc_id, item_id) as sub1
    
left join doc_expend as doc ON sub1.doc_id = doc.id
left join wallets as wal ON doc.wallet_id = wal.id

group by
	doc.date,
    sub1.doc_id,
    doc.wallet_id,
    wal.currency_id
    ) as temp";
        
        $stmt = $this->db->prepare($sql);
        $param = [
            'doc_id' => $obj->getId()
        ];
        
        $success = $stmt->execute($param);
        
        return $success;
    }
}
