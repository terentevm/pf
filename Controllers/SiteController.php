<?php

namespace Controllers;

use tm\Controller;
use Models\Index;
use Models\User;
use Models\Wallets;
use Models\Currency;
use tm\Registry;
use tm\QueryBuilder;

class SiteController extends Controller{

    public $layout = 'material';

    public function actionIndex(){
        
        $this->GetView();
     
    }
    
    public function actionSettings(){
        
        $this->GetView();
     
    }
    public function actionTester(){
        
        $obj = User::find()->one();
        
        $this->debug($obj);

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
