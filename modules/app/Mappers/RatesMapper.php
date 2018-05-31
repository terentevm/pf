<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class RatesMapper extends Mapper
{
    public static $db_columnes = ['id', 'user_id','date','dateInt', 'currency_id' , 'mult', 'rate'];

    public static function setTable()
    {
        return 'rates';
    }
    
    protected function getPrimaryKey()
    {
        return 'id';
    }

    public function create(Model $obj)
    {
        if ($this->create_stmt === null) {
            $sql = $this->qb->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }

        $dataset = $obj->getDataset();

        if (is_null($dataset)) {
            return false;
        }

        foreach ($dataset->strings() as $record) {
            
            $params = $this->mapModelToDb($record);
            $success = $this->create_stmt->execute($params);
            if ($success !== true) {
                return false;
            }
        }
        
        return true;
    }
    
    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => null,
            'user_id' => $obj->getUserId(),
            'date' => $obj->getDate(),
            'dateInt' => $obj->getDateInt(),
            'currency_id' => $obj->getCurrencyId(),
            'mult' => $obj->getMult(),
            'rate' => $obj->getRate()
        ];
        
        return $db_arr;
    }
}
