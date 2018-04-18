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
    
    public function delete(Model $obj) {
        if ($this->delete_stmt === null) {
            $this->where = ['id = :id'];

            $sql = $this->qb->buildDelete($this);
            $this->delete_stmt = $this->db->prepare($sql);
        }
        
        $param = $this->mapModelToDb($obj);
        $success = $this->create_stmt->execute($param);

        return $success;    
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
