<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class RatesMapper extends Mapper
{
    public static $db_columnes = ['id', 'user_id','date','dateInt', 'currency_id' , 'mult', 'rate'];

    public static function setTable() { 
        return 'rates';
    }
    
    protected function getPrimaryKey() {
        return 'id';
    }

    public function create(Model $obj)
    {
        if ($this->create_stmt === null) {
            $sql = $this->qb->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }

        $dataset = $obj->getDataset();

        foreach ($dataset as $record) {
            $record['id'] = null; 
            $record['dateInt'] = strtotime($record['date']); 
            $success = $this->create_stmt->execute($record);
        
            if ($success !== true) {
                return false;
            } 
        }
        
        return true;
    }

    public function delete(\tm\Model $obj) {
        if ($this->delete_stmt === null) {
            $this->where = ['id = :id'];

            $sql = $this->qb->buildDelete($this);
            $this->delete_stmt = $this->db->prepare($sql);
        }
        
        $param = $this->mapModelToDb($obj);
        $success = $this->create_stmt->execute($param);

        return $success; 
    }

    

    
    public function mapModelToDb(Model $obj) {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_Id(),
            'code' => $obj->getCode(),
            'short_name' => $obj->getShort_name(),
            'name' => $obj->getName()
        ];
        
        if (!isset($db_arr['id'])){
            $db_arr['id'] = $this->getGuide();
        }
        
        return $db_arr;
    }
}