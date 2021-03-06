<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

use tm\Mapper;
use tm\Model;

use app\Mappers\RegIncomesMapper;

class IncomeMapper extends Mapper
{
    public static $db_columns = ['id', 'user_id', 'date', 'dateint', 'sum', 'comment'];

    public static function setTable()
    {
        return 'doc_income';
    }


    protected function getPrimaryKey()
    {
        return 'id';
    }

    public function mapModelToDb(Model $obj)
    {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_id(),
            'date' => $obj->getDate(),
            'dateint' => strtotime($obj->getDate()),
            'comment' => $obj->getComment(),
            'sum' => $obj->getSum()
        ];

        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
            $obj->setId($db_arr['id'] );
        }

        return $db_arr;
    }

    protected function create(Model $obj)
    {
        if ($this->create_stmt === null) {
            $sql = $this->qb->buildInsert($this);
            $this->create_stmt = $this->db->prepare($sql);
        }

        $param = $this->mapModelToDb($obj);

        $success = $this->create_stmt->execute($param);

        if ($success !== true) {
            return false;
        }

        foreach ($obj->rows->strings() as $row) {
            $row->setDocId($param['id']);
            $row_mapper = $this->getMapper("app\Models\IncomeRow");
            $saved = $row_mapper->save($row);

            if ($saved === false) {
                return false;
            }
        }

        return $success;
    }

    public function  update(Model $obj, array $colsForUpdate)
    {

        $sql = $this->qb->buildUpdate($this, $colsForUpdate);

        $this->update_stmt = $this->db->prepare($sql);

        $this->db->beginTransaction();

        $success = $this->update_stmt->execute($colsForUpdate);

        if ($success === false) {

            $this->db->rollBackTransaction();

            return false;

        }

        //delete existed rows from doc_expend_rows

        $deleted = $this->deleteRows($obj->id);

        if ($deleted === false) {
            $this->db->rollBackTransaction();
            return false;
        }

        //save new rows

        foreach ($obj->rows->strings() as $row) {

            $row->setDocId($obj->getId());

            $row_mapper = $this->getMapper("app\Models\IncomeRow");

            $saved = $row_mapper->save($row);

            if ($saved === false) {

                $this->db->rollBackTransaction();

                return false;

            }
        }

        //rewrite data in registers

        $success = $this->afterSave($obj);


        if ($this->db->transactionExists()) {
            if ($success) {
                $this->db->commitTransaction();
            } else {
                $this->db->rollBackTransaction();
            }
        }

        return $success;

    }

    private function deleteRows(string $docId)
    {
        $sql = "DELETE FROM doc_income_rows where doc_id = :docId";

        $deleted = $this->db->run($sql, ["docId" => $docId]);

        return $deleted;


    }

    protected function afterSave($obj)
    {
        $regMoney = new \app\Models\RegMoneyTransactions();
        $regMoney->loadModel($obj);
        $success = $regMoney->save(false);

        if ($success === false) {
            return false;
        }

        $regIncomes = new RegIncomesMapper("RegIncomes");
        $success = $regIncomes->save($obj);

        unset($regMoney);

        return $success;
    }
}
