<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class RegExpensesMapper extends Mapper
{
    public static $db_columnes = ["id", "date", "month", "expendId", "dateInt", "walletId", "currencyId", "itemId", "userId", "sum"];
    
    public static function setTable()
    {
        return 'regExpenses';
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
        $expendId = $obj->getId();

        $sql = "CALL addToRegExpenses(:expendId)";
        $this->create_stmt = $this->db->prepare($sql);
        $success = $this->create_stmt->execute(["expendId" => $expendId]);

        return $success;

    }
}