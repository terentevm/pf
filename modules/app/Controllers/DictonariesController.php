<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controllers;
use tm\Controller;
use app\Models\Wallets;
use app\Models\Currency;
use app\Models\Itemsincome;
use app\Models\Itemsexpenditure;
use tm\Validator;
/**
 * Description of DictonariesController
 *
 * @author terentyev.m
 */
class DictonariesController extends Controller {
    
    public $layout = 'main';
    
    public function actionCurrencies(){
        $this->view = 'currency_list';
        
        
        if(isset($_POST['id'])){
            $this->errors = Validator::validate($_POST, ['id' =>['id']]);
            $dic_element = Currency::find()->where(['id', '=', $_POST['id']])->limit(1)->selectAll();
            $this->vars = $dic_element;
            $this->view = 'currency_element';
            $this->GetView();
            exit();
        }
        else {
            $dic_elements = Currency::find()->where(['user_id', '=', $_SESSION['user_id']])->selectAll();
            $this->vars = $dic_elements;
        }
        
        
        
        if($this->isAjax()){
            echo 'success';   
        }
        else{
            $this->GetView();    
        }
        
        
    }
    
    public function actionGetNewCurrencyForm(){
        $this->view = 'currency_element';
        $this->vars[] = [];
        $this->GetView();
        exit();
    }


    public function actionWallets(){
        $this->view ='wallets_list';
        $dic_elements = Wallets::find()->where(['user_id', '=', $_SESSION['user_id']])->selectAll();
       // $wallets = new Wallets();
       // $dic_elements = $wallets->GetView();
        $this->vars = $dic_elements;
        $this->GetView();    
    }
    
    public function actionIncome(){
        
    }
    
    public function actionExpenditure(){
        $this->view = 'expenditure_list';
        $Expenditure = new Itemsexpenditure();
        $dic_elements= $Expenditure->GetHierarhicalList();
        $this->vars = $dic_elements;
        $this->GetView();
    }
}
