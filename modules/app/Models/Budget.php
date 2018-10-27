<?php
/**
 * Created by PhpStorm.
 * User: zaich
 * Date: 27-Oct-18
 * Time: 11:04:49
 */

namespace app\Models;


use tm\Model;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class Budget extends Model implements \JsonSerializable
{
    private $id = null;
    private $userId = null;
    private $month = '';
    private $comment = '';

    private $expenses = null;
    private $incomes = null;
    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param null $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @param string $month
     */
    public function setMonth(string $month): void
    {
        $this->month = $month;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    public function setExpenses(array $expenses)
    {
        $this->expenses = new DocumentCollection($this);

        foreach ($expenses as $row) {

            $row_obj = new BudgetExpense();
            $row_obj->load($row);
            $this->expenses>add($row_obj);

        }
    }

    public function setIncomes(array $incomes)
    {
        $this->incomes = new DocumentCollection($this);

        foreach ($incomes as $row) {

            $row_obj = new BudgetIncome();
            $row_obj->load($row);
            $this->expenses>add($row_obj);

        }
    }

    public function getExpenses()
    {
        if ($this->expenses === null) {
            $param = [
                'budgetId' => $this->id
            ];

            $rows = BudgetExpense::find()->with('ItemExpenditure')->where(['budgetId = :budgetId'])->setParams($param)->All();

            $this->setExpenses($rows);
        }

        return $this->expenses;
    }

    public function getIncomes()
    {
        if ($this->incomes === null) {
            $param = [
                'budgetId' => $this->id
            ];

            $rows = BudgetIncome::find()->with('ItemIncome')->where(['budgetId = :budgetId'])->setParams($param)->All();

            $this->setExpenses($rows);
        }

        return $this->incomes;
    }


    public function validate()
    {
        $ok = true;

        foreach ($this->expenses as $row) {
            $ok = $row->validate();
        }

        if ($ok === false) {
            return false;
        }

        foreach ($this->incomes as $row) {
            $ok = $row->validate();
        }

        if ($ok === false) {
            return false;
        }

        $validator = v::attribute('month', v::date('Y-m-d'));

        if (!is_null($this.id)) {
            $validator->attribute('id', v::notEmpty()->stringType()->length(36, 36));
        }

        if (!is_null($this.userId)) {
            $validator->attribute('userId', v::notEmpty()->stringType()->length(36, 36));
        }

        try {
            $validator->assert($this);
            return true;
        } catch (NestedValidationException $e) {
            $errors = $e->getMessages();
            return false;
        }
    }

}