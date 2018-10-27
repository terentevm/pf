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
    public static $db_columnes = ['id', 'userId', 'budgetId', 'itemId', 'sum'];

    public static function setTable()
    {
        return 'budgetIncomes';
    }

    protected function getPrimaryKey()
    {
        return "id";
    }

    public static function getItemIncome()
    {
        return [
            'model' => 'ItemsIncome',
            'f_key' => 'itemId',
            'table_col' => 'id'
        ];
    }

    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => $obj->getId(),
            'userId' => $obj->getUserId(),
            'budgetId' => $obj->getBudgetId(),
            'itemId' => $obj->getItemId(),
            'sum' => $obj->getSum()
        ];

        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
        }

        return $db_arr;
    }

}