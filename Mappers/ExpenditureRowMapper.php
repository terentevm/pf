<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace mappers;

use tm\Mapper;
use tm\Model;

class ExpenditureRowMapper extends Mapper
{
    public static $db_columnes = ['id', 'doc_id', 'item_id', 'sum', 'comment'];
    
    public static function setTable() { 
        return 'doc_expend_rows';
    }
    
    public function delete(Model $obj) {
        
    }

    protected function getPrimaryKey() {
        return 'id';
    }

    public function mapModelToDb(Model $obj) {
        $db_arr = [
            'id' => $obj->getId(),
            'doc_id' => $obj->getDocId(),
            'item_id' => $obj->getItem_id(),
            'sum' => $obj->getSum(),
            'comment' => $obj->getComment()
        ];
        
        if (!isset($db_arr['id'])){
            $db_arr['id'] = $this->getGuide();
        }
        
        return $db_arr;
    }

    protected function update(Model $obj) {
        
    }

}
