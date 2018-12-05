<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controllers;

use tm\RestController;
use tm\Registry as Reg;
use app\Models\ItemExpenditure;

/**
 * Description of ExpenditureItemsController
 *
 * @author terentyev.m
 */
class ExpenditureItemsController extends RestController
{
    public static $classModel = 'app\models\ItemExpenditure';
    
    public function actionIndex()
    {
        $get = $this->request->get();
        
        $limit = $get['limit'] ?? 50;
        $offset = $get['offset'] ?? 0;
        $asList = $get['list'] ?? false;
        
        $finder = ItemExpenditure::find();
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
        } else {
            $result = $finder->hierarchically($expand, $parent_id);
        }
        
        return $this->createResponse($this->createResponseData(true, $result, "OK"), 200);
    }
}
