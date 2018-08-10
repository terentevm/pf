<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;

use tm\Model;
use tm\Mapper;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Exceptions\NestedValidationException;

class Wallet extends Model
{
    private $id = null;
    private $name = '';
    private $currency = null;
    private $currency_id = null;
    private $is_creditcard = 0;
    
    private $grace_period = 0;
    private $credit_limit = 0;
    private $user_id = '';
    
    public function __construct($user_id = "", $name ="", $currency_id = "", $id = null, Model $currency = null, $is_creditcard = 0, $grace_period = 0, $credit_limit = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->currency = $currency;
        $this->is_creditcard = $is_creditcard;
        $this->grace_period = $grace_period;
        $this->credit_limit = $credit_limit;
        $this->user_id = $user_id;
        $this->currency_id = $currency_id;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getCurrency_id()
    {
        return $this->currency_id;
    }

    public function getIs_creditcard()
    {
        return $this->is_creditcard;
    }

    public function getGrace_period()
    {
        return $this->grace_period;
    }

    public function getCredit_limit()
    {
        return $this->credit_limit;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function setCurrency_id($currency_id)
    {
        $this->currency_id = $currency_id;
    }

    public function setIs_creditcard($is_creditcard)
    {
        $this->is_creditcard = $is_creditcard;
    }

    public function setGrace_period($grace_period)
    {
        $this->grace_period = $grace_period;
    }

    public function setCredit_limit($credit_limit)
    {
        $this->credit_limit = $credit_limit;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }
    
    public function validate()
    {
        $validator = v::attribute('name', v::notEmpty()->stringType())
                    ->attribute('currency_id', v::notEmpty()->stringType()->length(36, 36));
        
        try {
            $validator->assert($this);
            return true;
        } catch (NestedValidationException $e) {
            //$errors = $e->getMessages();
            return false;
        }
    }
    
    public static function walletBalance(string $walletId)
    {
        $result = Mapper::getMapper(get_called_class())->getWalletBalance($walletId);
        return $result;
    }
    
    public static function balanceAllWallets(string $userId, int $dateInt)
    {
        if (empty($userId)) {
            return [];
        }
        
        $result = Mapper::getMapper(get_called_class())->getBalanceAllWallets($userId, $dateInt);
        return $result;
    }
}
