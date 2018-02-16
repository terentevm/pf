<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use tm\Model;
use Models\DocumentCollection;
use Models\ExpenditureRow;

/**
 * Description of Expenditure
 *
 * @author terentyev.m
 */
class Expenditure extends Model
{
    private $id = null;
    private $user_id = null;
    private $date = null;
    private $wallet_id = null;
    private $rows = null;
    private $comment = '';
    
    private $Wallet = null;

    public function getId() {
        return $this->id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getDate() {
        return $this->date;
    }

    public function getWallet_id() {
        return $this->wallet_id;
    }

    public function getRows() {
        
        if ($this->rows === null) {
            
            $param = [
                'doc_id' => $this->id
            ];
            
            $rows = ExpenditureRow::find()->with('ItemExpenditure')->where(['doc_id = :doc_id'])->setParams($param)->All();

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

    public function setWallet_id($wallet_id) {
        $this->wallet_id = $wallet_id;
    }

    public function setRows(array $rows) {
        $this->rows = new DocumentCollection($this);
        
        foreach ($rows as $row) {
            
            $row = new ExpenditureRow($this->id, $row['item_id'], $row['sum'], $row['comment']);
            
            $this->rows->add($row);
        }
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setWallet($Wallet) {
        $this->Wallet = $Wallet;
    }

    public function getWallet() {
        return $this->Wallet;
    }

}
