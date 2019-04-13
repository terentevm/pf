<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;

use tm\Model;
use app\Mappers\ExpenditureMapper;
use app\Mappers\ExpenditureRowMapper;
use app\Mappers\RegExpensesMapper;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Description of Expenditure
 *
 * @author terentyev.m
 */
class Expenditure extends Model implements \JsonSerializable
{

    use TRegFunctions;

    private $id = null;
    private $user_id = null;
    private $date = null;
    private $wallet_id = null;
    private $rows = null;
    private $comment = '';
    private $sum = 0;
    private $Wallet = null;

    public function getId()
    {
        return $this->id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getWallet_id()
    {
        return $this->wallet_id;
    }
    
    public function getSum()
    {
        return $this->sum;
    }
    
    public function getRows()
    {
        if ($this->rows === null) {
            $param = [
                'doc_id' => $this->id
            ];
            
            $rows = ExpenditureRow::find()->with('ItemExpenditure')->where(['doc_id = :doc_id'])->setParams($param)->All();

            $this->setRows($rows);
        }
        
        return $this->rows;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
    
    public function setSum($sum)
    {
        $this->sum = $sum;
    }
    
    public function setWallet_id($wallet_id)
    {
        $this->wallet_id = $wallet_id;
    }

    public function setRows(array $rows)
    {
        $this->rows = new DocumentCollection($this);
        $this->sum = 0;
        foreach ($rows as $row) {
            
            //$row_obj = new ExpenditureRow($this->id, $row['item_id'], $row['sum'], $row['comment']);
            $row_obj = new ExpenditureRow();
            $row_obj->load($row);
            $this->rows->add($row_obj);
            $this->sum += $row['sum'];
        }
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setWallet($Wallet)
    {
        $this->Wallet = $Wallet;
    }

    public function getWallet()
    {
        return $this->Wallet;
    }
    
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    public function validate()
    {
        $ok = true;

        foreach ($this->rows as $row) {
            $ok = $row->validate();
        }

        if ($ok === false) {
            return false;
        }

        $validator = v::attribute('wallet_id', v::notEmpty()->stringType()->length(36, 36))
                    ->attribute('date', v::date('Y-m-d'));
        
        try {
            $validator->assert($this);
            return true;
        } catch (NestedValidationException $e) {
            $errors = $e->getMessages();
            return false;
        }
    }

    public function save($upload_mode = false)
    {
        $mapper = new ExpenditureMapper(self::className());
        $dbCommand = $mapper->getDb();

        $dbCommand->beginTransaction();

        $success = $mapper->save($this);

        if ($success === false) {
            $dbCommand->rollBackTransaction();
            return false;
        }

        $success = $this->storeRows();

        if ($success === false) {
            $dbCommand->rollBackTransaction();
            return false;
        }

        $success = $this->storeToRegisters();

        if ($success === false) {
            $dbCommand->rollBackTransaction();
            return false;
        }

        $dbCommand->commitTransaction();

        return true;

    }

    public function update()
    {
        if ($this->id === null) {
            return false;
        }

        $mapper = Mapper::getMapper(self::className());

        $dbCommand = $mapper->getDb();

        $dbCommand->beginTransaction();

        $colsForUpdate = $mapper->mapModelToDb($this);

        $success = $mapper->where(['id = :id'])
            ->setParams(['id' => $this->id])
            ->update($this, $colsForUpdate);

        if ($success === false) {
            $dbCommand->rollBackTransaction();
            return false;
        }

        $deleted = $mapper->deleteRows($this->id);

        if ($deleted === false) {
            $dbCommand->rollBackTransaction();
            return false;
        }

        $success = $this->storeRows();

        if ($success === false) {
            $dbCommand->rollBackTransaction();
            return false;
        }

        $success = $this->storeToRegisters();

        if ($success === false) {
            $dbCommand->rollBackTransaction();
            return false;
        }

        $dbCommand->commitTransaction();

        return true;
    }


    private function storeRows()
    {
        $rowMapper = new ExpenditureRowMapper("app\Models\ExpenditureRow");

        foreach ($this->rows->strings() as $row) {
            $row->setDocId($this->id);

            $success = $rowMapper->save($row);

            if ($success === false) {
                return false;
            }
        }

        return true;
    }

    private function storeToRegisters()
    {

        $success = $this->storeToRegMoneyTransactions();

        if ($success === false) {
            return false;
        }

        $regExpenses = new RegExpensesMapper("RegExpenses");

        $success = $regExpenses->save($this);

        return $success;
    }

}
