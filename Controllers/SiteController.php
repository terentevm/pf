<?php

namespace Controllers;

use tm\Controller;
use Models\Index;
use Models\User;
use Models\Wallets;
use Models\Currency;
use tm\Registry;
use tm\QueryBuilder;
use tm\IncomeCollection;
use Models\Income;

class SiteController extends Controller{

    public $layout = 'material';

    public function actionIndex(){
        
        $this->GetView();
     
    }
    
    public function actionSettings(){
        
        $this->GetView();
     
    }
    public function actionTester(){
        

       // $user1

        $user = User::find()->where(['login = :login'])->setParams(['login' => 'mick911@mail.ru'])->limit(1)->one();
        
        //$user = User::find()->where(['login = :login'])->setParams(['login' => 'mick9131@mail.ru'])->limit(1)->one();
        
        //$obj = Wallets::find()->with(['Currency'])->where(['user_id = :user_id'])->setParams(['user_id' => $user['id']])->all();
        
        $row1 = [
            'id' => 1,
            'item' =>  'Salary Mick',
            'sum' => 78000
        ];

        $row2 = [
            'id' => 2,
            'item' =>  'Salary Nadya',
            'sum' => 70000
        ];

        $row3 = [
            'id' => 3,
            'item' =>  'Another income',
            'sum' => 5000
        ];

        $income = new Income();
        $items = $income->getItems();
        
        $items->add($row1);
        $items->add($row2);
        $items->add($row3);

        $items->delete(1);
        
        $this->debug($user);

        die();
     
    }
    
    
    public function actionApi() {
        $arr = [
            'FirstName' => 'Mikhail',
            'SecondName' => 'Terentev',
            'Age' => 30
        ];
        
        $app = Registry::$app;
        $req = $app::$request;
        $content_type = $req->getHeaders('CONTENT_TYPE');
        
        header(http_response_code(404));
        echo 'Вы запросили ',$content_type;
        //echo json_encode($arr);
    }
}
