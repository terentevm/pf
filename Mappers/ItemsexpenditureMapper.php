<?php

namespace mappers;

use tm\Mapper;

class ItemsexpenditureMapper extends Mapper
{
    protected function getPrimaryKey() {
        return 'id';   
    }
    
    public static function setTable() {
        return "dic_items_expenditure";
    }
    
    public function delete(\tm\Model $obj) {
        
        if ($this->delete_stmt === null) {
            $this->where = ['id = :id'];

            $sql = $this->db->getQueryBuilder()->buildDelete($this);
            $this->delete_stmt = $this->db->prepare($sql);
        }
        
        $param = $this->mapModelToDb($obj);
        
        $success = $this->create_stmt->execute($param);

        return $success;   
    }

    

    protected function update(\tm\Model $obj) {
        if ($this->update_stmt === null) {
            $this->where = ['id = :id'];

            $sql = $this->db->getQueryBuilder()->buildUpdate($this);
            $this->update_stmt = $this->db->prepare($sql);
        }
        
        $param = $this->mapModelToDb($obj);
        $success = $this->create_stmt->execute($param);

        return $success;    
    }

}
