<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

use tm\Mapper;
use tm\Model;

class IncomeMapper extends Mapper
{

    public static $db_columnes = ['id', 'user_id', 'date', 'dateInt', 'sum', 'comment'];

    public static function setTable() {
        return 'doc_income';
    }

    public function delete(Model $obj) {
        
    }

    protected function getPrimaryKey() {
        return 'id';
    }

    public function mapModelToDb(Model $obj) {
        $db_arr = [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_id(),
            'date' => $obj->getDate(),
            'dateInt' => strtotime($obj->getDate()),
            'comment' => $obj->getComment(),
            'sum' => $obj->getSum()
        ];

        if (!isset($db_arr['id'])) {
            $db_arr['id'] = $this->getGuide();
        }

        return $db_arr;
    }

    protected function create(Model $obj) {

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

    protected function afterSave($obj) {
        $regMoney = new \app\Models\RegMoneyTransactions();
        $regMoney->loadModel($obj);
        $success = $regMoney->save(false);

        unset($regMoney);

        return $success;
    }

}
