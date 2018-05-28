<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;

use tm\Model;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Exceptions\NestedValidationException;

class IncomeRow extends Model implements \JsonSerializable
{
    private $id = null;
    private $docId = null;
    private $item_id = null;
    private $wallet_id = null;
    private $sum = 0;
    private $comment = '';
    
    private $ItemIncome = null;
    private $Wallet = null;

    public function __construct($docId = null, $item_id = null, $wallet_id = null, $sum = 0, $comment = "") {
        $this->docId = $docId;
        $this->item_id = $item_id;
        $this->wallet_id = $wallet_id;
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

    public function getWallet_id() {
        return $this->wallet_id;
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

    public function setWallet_id($wallet_id) {
        $this->wallet_id = $wallet_id;
    }

    public function setSum($sum) {
        $this->sum = $sum;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setItemIncome($ItemIncome) {
        $this->ItemIncome= $ItemIncome;
    }
    
    public function setWallet($Wallet) {
        $this->Wallet = $Wallet;
    }


    public function getItemIncome() {
        return $this->ItemIncome;
    }
    
    public function getWallet() {
        return $this->Wallet;
    }
    
    public function jsonSerialize() {
        $vars = get_object_vars($this);

	    return $vars;   
    }
    public function validate() {
        $validator = v::attribute('wallet_id', v::notEmpty()->stringType()->length(36, 36))
                    ->attribute('item_id', v::notEmpty()->stringType()->length(36, 36))
                    ->attribute('sum', v::notEmpty()->floatVal());
        
        try {
            $validator->assert($this);
            return true;
        } catch (NestedValidationException $e) {
            //$errors = $e->getMessages();
            return false;
        }
    }
}
