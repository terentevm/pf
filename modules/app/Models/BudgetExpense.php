<?php
/**
 * Created by PhpStorm.
 * User: zaich
 * Date: 27-Oct-18
 * Time: 11:11:30
 */

namespace app\Models;


use tm\Model;

class BudgetExpense extends  Model implements \JsonSerializable
{
    private $id;
    private $budgetId;
    private $itemId = null;
    private $sum = 0;
    private $userId = null;

    /**
     * BudgetExpense constructor.
     * @param $id
     * @param $budgetId
     * @param null $itemId
     * @param int $sum
     * @param null $userId
     */
    public function __construct($id, $budgetId, $itemId, int $sum, $userId)
    {
        $this->id = $id;
        $this->budgetId = $budgetId;
        $this->itemId = $itemId;
        $this->sum = $sum;
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBudgetId()
    {
        return $this->budgetId;
    }

    /**
     * @param mixed $budgetId
     */
    public function setBudgetId($budgetId): void
    {
        $this->budgetId = $budgetId;
    }

    /**
     * @return null
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param null $itemId
     */
    public function setItemId($itemId): void
    {
        $this->itemId = $itemId;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @param int $sum
     */
    public function setSum(int $sum): void
    {
        $this->sum = $sum;
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
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }



    public function validate()
    {
        $validator = v::attribute('itemId', v::notEmpty()->stringType()->length(36, 36))
            ->attribute('sum', v::notEmpty()->floatVal())
            ->attribute('budgetId', v::notEmpty()->stringType()->length(36, 36));

        try {
            $validator->assert($this);
            return true;
        } catch (NestedValidationException $e) {
            //$errors = $e->getMessages();
            return false;
        }
    }


}