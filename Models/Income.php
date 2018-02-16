<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use tm\Model;
use Models\DocumentCollection;
use Models\IncomeRow;

class Income extends Model
{
    private $id = null;
    private $user_id = null;
    private $date = null;
    private $rows = null;
    private $comment = '';
    
    public function getId() {
        return $this->id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getRows() {
        if ($this->rows === null) {
            
            $param = [
                'doc_id' => $this->id
            ];
            
            $rows = IncomeRow::find()->with(['ItemsIncome', 'Wallet'])->where(['doc_id = :doc_id'])->setParams($param)->All();

            $this->setRows($rows);

        }
        
        return $this->rows;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setRows($rows) {
        
        $this->rows = new DocumentCollection($this);
        
        foreach ($rows as $row) {
            
            $row = new IncomeRow($this->id, $row['item_id'], $row['wallet_id'], $row['sum'], $row['comment']);
            
            $this->rows->add($row);
        }
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }


}