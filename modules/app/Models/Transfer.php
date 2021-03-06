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

class Transfer extends Model implements \JsonSerializable
{
    private $id = null;
    private $user_id = null;
    private $date = '';
    private $wallet_id_from = null;
    private $wallet_id_to = null;
    private $sumFrom = 0;
    private $sumTo = 0;
    private $comment = '';
    
    private $walletFrom = null;
    private $walletTo = null;
    
    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getWallet_id_from()
    {
        return $this->wallet_id_from;
    }

    public function getWallet_id_to()
    {
        return $this->wallet_id_to;
    }

    public function getSumFrom()
    {
        return $this->sumFrom;
    }

    public function getSumTo()
    {
        return $this->sumTo;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getWalletFrom()
    {
        return $this->walletFrom;
    }

    public function getWalletTo()
    {
        return $this->walletTo;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setWallet_id_from($wallet_id_from)
    {
        $this->wallet_id_from = $wallet_id_from;
    }

    public function setWallet_id_to($wallet_id_to)
    {
        $this->wallet_id_to = $wallet_id_to;
    }

    public function setSumFrom($sumFrom)
    {
        $this->sumFrom = $sumFrom;
    }

    public function setSumTo($sumTo)
    {
        $this->sumTo = $sumTo;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setWalletFrom($walletFrom)
    {
        $this->walletFrom = $walletFrom;
    }

    public function setWalletTo($walletTo)
    {
        $this->walletTo = $walletTo;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    public function validate()
    {
        $validator = v::attribute('wallet_id_from', v::notEmpty()->stringType()->length(36, 36))
                    ->attribute('wallet_id_to', v::notEmpty()->stringType()->length(36, 36))
                    ->attribute('sumFrom', v::notEmpty()->floatVal())
                    ->attribute('sumTo', v::notEmpty()->floatVal())
                    ->attribute('date', v::date('Y-m-d'));
        
        try {
            $validator->assert($this);
            return true;
        } catch (NestedValidationException $e) {
            $errors = $e->getMessages();
            return false;
        }
    }
}
