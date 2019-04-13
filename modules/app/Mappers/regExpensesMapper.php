<?php

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class RegExpensesMapper extends Mapper
{
    public static $db_columns = [
        "id",
        "date",
        "month",
        "expend_id",
        "dateint",
        "wallet_id",
        "currency_id",
        "item_id",
        "user_id",
        "sum"
    ];
    
    public static function setTable()
    {
        return 'reg_expenses';
    }

    protected function getPrimaryKey()
    {
        return 'id';
    }

    public function mapModelToDb(Model $obj)
    {
    }

    public function save(Model $obj)
    {
        $expendId = $obj->getId();

        $success = $this->db_connection->callFunction("add_to_reg_expenses(:expendId)",
            ["expendId" => $expendId]);


        return $success;

    }
}