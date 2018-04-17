<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controllers;
use tm\Registry as Reg;
use tm\RestController;
use tm\Validator;
use app\Models\Wallet;
use app\Models\Currency;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;
/**
 * Description of WalletsController
 *
 * @author terentyev.m
 */
class WalletsController extends RestController
{
    
    public static $classModel = '\app\models\Wallet';
    
    public function actionIndex() {
        $get = Reg::$app->request->get();
        
        $limit = $get['limit'] ?? 50;
        $offset = $get['offset'] ?? 0;
     
        
        $result = Wallet::find()
                ->with('Currency')
                ->where(['user_id = :user_id'])
                ->setParams(['user_id' => $this->user_id])
                ->limit($limit)
                ->offset($offset)
                ->all();
        
        return $this->createResponse($result, 200);
    }
    
}
