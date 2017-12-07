<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;

use tm\Controller;
use tm\Validator;
use Models\Wallets;
use Models\Currency;
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
        $this->view = 'wallets_element';
        
        if (isset($_GET['id'])){
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        }
        elseif (isset($_POST['id'])){
         $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);   
        }
        else {
            $id = null;
        }
        $dic_element = [[]];
        if (!empty($id)){
            $dic_element = Wallets::find('id,name,is_creditcard, credit_limit,grace_period,currency_id')->where(['id', '=', $id])->limit(1)->selectAll();
            if (empty($dic_element)){
                header(http_response_code(404));
                header('Content-Type: application/text; charset=UTF-8');
                die("element not found by id");   
            }
        }
        
        $currency_list = Currency::find('id, short_name')->where(['user_id', '=', $_SESSION['user_id']])->selectAll();
       
        

	$this->vars = [
            'element' => $dic_element[0],
            'currency_list' => $currency_list
        ];
            
        $this->GetView();
        exit();
    }
    
    public function actionSaveElement() {

       $inputData = [
           'id' => filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING),
           'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
           'currency_id' => filter_input(INPUT_POST, 'currency_id', FILTER_SANITIZE_STRING),
           'credit_limit' => doubleval($_POST['credit_limit']),
           'grace_period' => intval($_POST['grace_period']),
           'is_creditcard' => intval($_POST['is_creditcard'])
       ]; 
        
        $wallet = new Wallets();
        $wallet->load($inputData);
        $success = $wallet->save();
        
        if ($success){
            header(http_response_code(200));
            
            if ($_SESSION['isAjax']){
                echo 'success';
                exit();
            }
            
            header('Location: /wallets/getlist');
            exit();
        }
    }
}
