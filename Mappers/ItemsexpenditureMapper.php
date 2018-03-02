<?php

namespace mappers;

use tm\Mapper;
use tm\Model;

class ItemsExpenditureMapper extends Mapper
{
    public static $db_columnes = ['id', 'user_id','name', 'not_active', 'parent_id', 'comment'];
    
    public static function setTable() {
        return "ref_items_expenditure";
    }
    
    protected function create(Model $obj) {
       
        $sql = "CALL InsertItemExpenditure(?,?,?,?,?,?)";

        $stmt = $this->db->prepare($sql);
        $param = $this->mapModelToDb($obj);
        $stmt->bindParam(1, $param['id']);
        $stmt->bindParam(2, $param['user_id']);
        $stmt->bindParam(3, $param['name']);
        $stmt->bindParam(4, $param['comment']);
        $stmt->bindParam(5, $param['not_active']);
        $stmt->bindParam(6, $param['parent_id']);
    
        $success = $stmt->execute();
        
        return $success;

    }

   public function delete(Model $obj) {
        if ($this->delete_stmt === null) {
            $this->where = ['id = :id'];

            $sql = $this->db->getQueryBuilder()->buildDelete($this);
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
