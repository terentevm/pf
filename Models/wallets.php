<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;
use tm\Model;
use tm\TraitModelFunc;
/**
 * Description of wallets
 *
 * @author terentyev.m
 */
class Wallets extends Model {
    
    private $id = null;
    private $name = '';
    private $currency = null; 
    private $is_creditcard = 0; 
    
    private $grace_period = 0;
    private $credit_limit = 0;
    private $user_id = '';
    
    public function __construct($id = '', $name = '', Model $currency, $is_creditcard = 0, $grace_period = 0,$credit_limit = 0, $user_id) {
        $this->id = $id;
        $this->name = $name;
        $this->currency = $currency;
        $this->is_creditcard = $is_creditcard;
        $this->grace_period = $grace_period;
        $this->credit_limit = $credit_limit;
        $this->user_id = $user_id;
    }
    
}
