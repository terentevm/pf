<?php

namespace mappers;

use tm\Mapper;
/**
 * Description of WalletMapper
 *
 * @author terentyev.m
 */
class WalletsMapper extends Mapper
{
    public static $db_columnes = ['id', 'name', 'currency_id', 'is_creditcard', 'grace_period'];
    
    public static function setTable() {
        return "wallets";
    }
    
    protected function getPrimaryKey() {
        return 'id';
    }

    public static function getCurrency() {
        return [
                'f_key' => 'currency_id',
                'table_col' => 'id'
            ];
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

}
