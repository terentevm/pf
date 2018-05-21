<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class ItemsIncomeMapper extends Mapper
{
    
    public static $db_columnes = ['id', 'user_id','name', 'not_active', 'parent_id', 'comment'];

    public static function setTable() { 
        return 'ref_items_income';
    }
    

    protected function getPrimaryKey() {
        return "id";
    }

    public function mapModelToDb(Model $obj) {
     
        return [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_id(),
            'name' => $obj->getName(),
            'not_active'=> intval($obj->getNotActive()),
            'parent_id' => $obj->getParentId(),
            'comment' => $obj->getComment()
        ];
    }


}
