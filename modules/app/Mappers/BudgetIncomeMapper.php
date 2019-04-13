<?php
/**
 * Created by PhpStorm.
 * User: zaich
 * Date: 27-Oct-18
 * Time: 11:42:54
 */

namespace app\mappers;


use tm\Mapper;
use tm\Model;

class BudgetIncomeMapper extends Mapper
{
    public static $db_columns = ['id', 'user_id', 'budget_id', 'item_id', 'sum'];

    public static function setTable()
    {
        return 'budget_incomes';
    }

    protected function getPrimaryKey()
    {
        return "id";
    }

    public static function getItemIncome()
    {
        return [
            'model' => 'ItemsIncome',
            'f_key' => 'item_id',
            'table_col' => 'id'
        ];
    }

    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUserId(),
            'budget_id' => $obj->getBudgetId(),
            'item_id' => $obj->getItemId(),
            'sum' => $obj->getSum()
        ];

        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
        }

        return $db_arr;
    }

}