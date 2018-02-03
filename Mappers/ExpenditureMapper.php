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

    protected function update(Model $obj) {
        
    }

    protected function create(Model $obj) {
         
        if ($this->create_stmt === null) {
            $sql = $this->db->getQueryBuilder()->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }
        
        $param = $this->mapModelToDb($obj);
        
        $this->db->beginTransaction();
        
                        
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
        
        
        $this->db->commitTransaction();
        
        return $success;
    }

}