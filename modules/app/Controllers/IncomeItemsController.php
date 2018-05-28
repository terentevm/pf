<?php

namespace app\Controllers;

use tm\RestController;
use tm\Registry as Reg;

class IncomeItemsController extends RestController
{
    public static $classModel = '\app\models\ItemsIncome';
    
    public function actionIndex() {
        $get = Reg::$app->request->get();
        
        $limit = $get['limit'] ?? 50;
        $offset = $get['offset'] ?? 0;
        $asList = $get['list'] ?? false;
        
        $finder = self::$classModel::find();

        $finder->where(['user_id = :user_id']);
        $finder->setParams(['user_id' => $this->user_id]);
        $finder->limit($limit);
        $finder->offset($offset);
        
        if (isset($get['active'])) {
            $finder->andWhere(['not_active = :not_active']);
            $finder->setParams(['not_active' => 0]);
        }
        
        if ($asList == true) {
            $finder->orderBy('name');       
        }
        
        $expand = $get['expand'] ?? true;
        $parent_id = $get['parent_id'] ?? null;
        
        if ($asList == true) {
            $result = $finder->all();      
        }
        else
        {
            $result = $finder->hierarchically($expand, $parent_id);    
        }
        
        return $this->createResponse($this->createResponseData(true, $result, "OK"), 200);
        
    }
}
