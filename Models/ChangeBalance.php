<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use tm\Model;

class ChangeBalance extends Model
{
    private $id = null;
    private $user_id = null;
    private $date = null;
    private $wallet_id = null;
    private $sumExpend = 0;
    private $sumIncome = 0;
    private $newBalance = 0;
    
    private $Wallet;
    
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

    public function getSumExpend() {
        return $this->sumExpend;
    }

    public function getSumIncome() {
        return $this->sumIncome;
    }

    public function getNewBalance() {
        return $this->newBalance;
    }

    public function getWallet() {
        return $this->Wallet;
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

    public function setSumExpend($sumExpend) {
        $this->sumExpend = $sumExpend;
    }

    public function setSumIncome($sumIncome) {
        $this->sumIncome = $sumIncome;
    }

    public function setNewBalance($newBalance) {
        $this->newBalance = $newBalance;
    }

    public function setWallet($Wallet) {
        $this->Wallet = $Wallet;
    }


}
