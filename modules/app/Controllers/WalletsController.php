<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controllers;

use tm\Registry as Reg;
use tm\RestController;
use app\Models\Wallet;
use tm\helpers\DateHelper;
use Respect\Validation\Validator as v;
/**
 * Description of WalletsController
 *
 * @author terentyev.m
 */
class WalletsController extends RestController
{
    public static $classModel = '\app\models\Wallet';
    
    public function actionIndex()
    {
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
        
        return $this->createResponse($this->createResponseData(true, $result, "OK"), 200);
    }
    
    public function actionBalance()
    {
        $get = Reg::$app->request->get();
        
        if (!isset($get['id'])) {
            return $this->createResponse($this->createResponseData(false, ["Error. No wallet id"], ""), 500);   
        }
        
        $result = Wallet::walletBalance($get['id']);
        return $this->createResponse($this->createResponseData(true, $result, "OK"), 200);
    }
    
    public function actionBalanceAll()
    {
        $post = Reg::$app->request->post();
        if (isset($post['date']) && v::date('Y-m-d')->validate($post['date'])) {
            $date = strtotime($post['date']);
        }
        else {
            $date = time();
        }
        
        $userId = $this->user_id;
        
        $dataset = Wallet::balanceAllWallets($userId, $date );
        
        return $this->createResponse($this->createResponseData(true, $dataset, "OK"), 200);        
    }
}
