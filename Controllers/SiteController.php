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
use tm\Response;
use tm\Request;
use tm\database\Table;
use tm\auth\JWT;

class SiteController extends Controller{

    public $layout = 'material';

    public function actionIndex(){
        
        return $this->createResponse(null,200,'');
     
    }
    
    public function actionSettings(){
        
        return $this->createResponse(null,200,'');
     
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
        
        $respType = Registry::$app->request->getResponseType(); 
        

        if ($respType === 'json') {
            $response = \json_encode('Вы запросили json формат',JSON_UNESCAPED_UNICODE);
            $ct = "application/json";
        }
        else {
            $response = '<p>' . 'Вы запросили html формат' . '</p>';
            $ct = "text/html";
        }
        
        $pesponse = new Response(200, $response);
        $pesponse->setContentType($ct);

        return $pesponse;

    }

    public function actionVue() {
       
        $user = User::find()->where(['login = :login'])->setParams(['login' => 'mick911@mail.ru'])->limit(1)->one();

        $user_id = $user->id;

        $wallets = Wallets::find()->with('currency')->where(['user_id = :user_id'])->setParams(['user_id' => $user_id])->all();

        return $this->createResponse($wallets);
        
    }

    public function actionTable() {

        $table = new Table("my_table");
        $sql = $table->addColumn("id", "VARCHAR", "36", true, true)
            ->addColumn("name", "VARCHAR", "150", true)
            ->addColumn("user_id", "VARCHAR", "36", true)
            ->addColumn("age", "INT", "3")
            ->addColumn("salary", "DOUBLE", "15,2")
            ->addForeignKey('user_id', 'users', 'id')
            ->buildSQL();

            die($sql);
    }

    public function actionJwt() {
        
        $payload = [
            'user_id' => 'asdsa778d-asdsf8d-f777dsf',
            'user_name' => 'Mikhail'
        ];

        $jwt = new JWT($payload);

        //$token = $jwt->createToken();

        $tok ='eyJ0eXBlIjoiand0IiwiYWxnIjoiSFMyNTYifQ.eyJ1c2VyX2lkIjoiYXNkc2E3NzhkLWFzZHNmOGQtZjc3N2RzZiIsInVzZXJfbmFtZSI6Ik1pa2hhaWwifQ.R1Zvuy57HachvEOlyb-8gvwNk2jlVnhUD0O_g9z5fl8';

        $success = $jwt->verifyJWT($tok);

        die($success);
    }
}
