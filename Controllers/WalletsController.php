<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;

use Base\Controller;
use Models\Wallets;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;
/**
 * Description of WalletsController
 *
 * @author terentyev.m
 */
class WalletsController extends Controller
{
    private $limit = 50;
    private $offset = 0;
    
    public function actionGetList() {
        
        $this->view = 'wallets_list';
        
        if (isset($_POST['offset'])){
            $this->offset = ( int )$_POST['offset'];
        }
        
        $wallets = Wallets::findView('id,name,is_creditcard,grace_period,currency_id', ['currency_id' => 'short_name'])->where(['user_id', '=', $_SESSION['user_id']])->limit($this->limit, $this->offset)->selectAll();
        
        $this->vars = $wallets;
        
        $this->GetView();
    }

    public function actionGetElement() {
        
    }
}
