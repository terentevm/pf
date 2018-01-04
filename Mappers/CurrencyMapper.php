<?php

namespace mappers;

use tm\Mapper;
/**
 * Description of CurrencyMapper
 *
 * @author terentyev.m
 */
class CurrencyMapper extends Mapper
{

    public static $db_columnes = ['id','code', 'short_name' , 'name'];

    public static function setTable() { 
        return 'dic_currency';
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

    protected function getPrimaryKey() {
        return 'id';
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

    protected function mapModelToDb(Model $obj) {
        $db_arr = [
            'id' => $obj->getUserId(),
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
