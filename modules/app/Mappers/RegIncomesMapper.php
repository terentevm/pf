<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class RegIncomesMapper extends Mapper
{
    public static $db_columnes = ["id", "date", "month", "incomeId", "dateInt", "walletId", "currencyId", "itemId", "userId", "sum"];
    
    public static function setTable()
    {
        return 'regIncomes';
    }

    protected function getPrimaryKey()
    {
        return 'id';
    }

    public function mapModelToDb(Model $obj)
    {
    }

    public function save(Model $obj, $upload_mode = false, $useTransaction = false)
    {
        $incomeId = $obj->getId();

        $sql = "CALL addToRegIncomes(:incomeId)";
        $this->create_stmt = $this->db->prepare($sql);
        $success = $this->create_stmt->execute(["incomeId" => $incomeId]);

        return $success;

    }
}