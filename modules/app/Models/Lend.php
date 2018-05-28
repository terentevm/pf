<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;

use tm\Model;

class Lend extends Model implements \JsonSerializable
{
    private $id = null;
    private $user_id = null;
    private $date = null;
    private $wallet_id = null;
    private $contact = '';
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

    public function getContact()
    {
        return $this->contact;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getWallet()
    {
        return $this->Wallet;
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

    public function setWallet_id($wallet_id)
    {
        $this->wallet_id = $wallet_id;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    public function setWallet($Wallet)
    {
        $this->Wallet = $Wallet;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
