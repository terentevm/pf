<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use tm\Model;


class ExpenditureRow extends Model
{
    private $id = null;
    private $docId = null;
    private $item_id = null;
    private $sum = 0;
    private $comment = '';
    
    private $ItemExpenditure = null;

    public function __construct($docId, $item_id, $sum, $comment) {
        $this->docId = $docId;
        $this->item_id = $item_id;
        $this->sum = $sum;
        $this->comment = $comment;
    }

    public function getId() {
        return $this->id;
    }

    public function getDocId() {
        return $this->docId;
    }

    public function getItem_id() {
        return $this->item_id;
    }

    public function getSum() {
        return $this->sum;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDocId($docId) {
        $this->docId = $docId;
    }

    public function setItem_id($item_id) {
        $this->item_id = $item_id;
    }

    public function setSum($sum) {
        $this->sum = $sum;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setItemExpenditure($item) {
        $this->ItemExpenditure = $item;
    }

    public function getItemExpenditure() {
        return $this->ItemExpenditure;
    }

    
}
