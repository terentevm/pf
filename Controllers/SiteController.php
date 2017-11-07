<?php

namespace Controllers;

use Base\Controller;
use Models\Index;
use Models\User;
use Models\Wallets;
use Models\Currency;
class SiteController extends Controller{

public $layout = 'main';

    public function actionIndex(){
        
        $this->GetView();
     
    }
    
    public function actionSettings(){
        
        $this->GetView();
     
    }
    public function actionTester(){
        
        //$hash_pass = password_hash('123', PASSWORD_DEFAULT);
        $wallet = new Wallets();
        $currency = new Currency();
        $currencies = $currency->GetAll_Currency();
        
        foreach ($currencies  as $elem){
            set_time_limit(0);
            $attributes1 = [
            'id' => $wallet->GetGuide(),
            'name' => 'Наличка',
            'user_id' => $elem['user_id'],
            'is_creditcard' => 0,
            'currency_id' => $elem['id'],
            'grace_period' => 0,
            'credit_limit' => 0
            ];
            
             $attributes2 = [
            'id' => $wallet->GetGuide(),
            'name' => 'Банковская карта',
            'user_id' => $elem['user_id'],
            'is_creditcard' => 0,
            'currency_id' => $elem['id'],
            'grace_period' => 0,
            'credit_limit' => 0
            ];
            
            $attributes3 = [
            'id' => $wallet->GetGuide(),
            'name' => 'Кредитка',
            'user_id' => $elem['user_id'],
            'is_creditcard' => 1,
            'currency_id' => $elem['id'],
            'grace_period' => 55,
            'credit_limit' => 250000
            ]; 
        
            $wallet->Load($attributes1);
            $wallet->Save();
            
            $wallet->Load($attributes2);
            $wallet->Save();
            
        /*for ($i=5001; $i < 10000; $i++){
             set_time_limit(0);
            $data = [
                'login' => 'user' . $i . '@pf.ru',
                'name' => 'user' . $i,
                'password' => $hash_pass
            ];
            
            $user->Load($data);
            $user->CreateNewUser();*/
        }
        
        $this->GetView();
     
    }
}
