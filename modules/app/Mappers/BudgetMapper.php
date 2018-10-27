<?php
/**
 * Created by PhpStorm.
 * User: zaich
 * Date: 27-Oct-18
 * Time: 11:41:30
 */

namespace app\mappers;


use tm\Mapper;
use tm\Model;

class BudgetMapper extends Mapper
{

    public static $db_columnes = ['id', 'userId', 'month', 'comment'];

    public static function setTable()
    {
        return 'docBudget';
    }

    protected function getPrimaryKey()
    {
        return "id";
    }

    public function mapModelToDb(Model $budget)
    {
        $db_arr = [
            'id' => $budget->getId(),
            'userId' => $budget->getUserId(),
            'date' => $budget->getMonth(),
            'comment' => $budget->getComment()
        ];

        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
            $budget->setId($db_arr['id'] );
        }

        return $db_arr;
    }

    protected function create(Model $budget)
    {
        if ($this->create_stmt === null) {
            $sql = $this->qb->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }

        $param = $this->mapModelToDb($budget);

        $success = $this->create_stmt->execute($param);

        if ($success !== true) {
            return false;
        }

        foreach ($budget->getExpenses()->strings() as $row) {
            $row->getBudgetId($param['id']);
            $row_mapper = $this->getMapper("app\Models\BudgetExpense");
            $saved = $row_mapper->save($row);

            if ($saved === false) {
                $this->db->rollBackTransaction();
                return false;
            }
        }

        foreach ($budget->getExpenses()->strings() as $row) {
            $row->getBudgetId($param['id']);
            $row_mapper = $this->getMapper("app\Models\BudgetIncome");
            $saved = $row_mapper->save($row);

            if ($saved === false) {
                $this->db->rollBackTransaction();
                return false;
            }
        }

        return $success;
    }
}