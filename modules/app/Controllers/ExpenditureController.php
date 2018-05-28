<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Controllers;

use tm\RestController;
use tm\Registry as Reg;
use tm\helpers\DateHelper;
use app\Models\Expenditure;
use Respect\Validation\Validator as v;

class ExpenditureController extends RestController
{
    public static $classModel = '\app\models\Expenditure';
    
    public function getAllowedParams_GET()
    {
        $get = Reg::$app->request->get();
        
        $get_params = [];
        
        if (isset($get['limit']) && v::intVal()->between(1, 100)->validate($get['limit'])) {
            $get_params['limit'] = $get['limit'];
        } else {
            $get_params['limit'] = $this->limit;
        }
        
        if (isset($get['offset']) && v::intVal()->validate($get['offset'])) {
            $get_params['offset'] = $get['offset'];
        } else {
            $get_params['offset'] = $this->offset;
        }
        
        if (isset($get['dateFrom']) && v::date('Y-m-d')->validate($get['dateFrom'])) {
            $get_params['dateFrom'] = $get['dateFrom'];
        }
        
        if (isset($get['dateTo']) && v::date('Y-m-d')->validate($get['dateTo'])) {
            $get_params['dateTo'] = $get['dateTo'];
        }
        
        if (isset($get['wallet_id']) && v::stringType()->length(36, null)->validate($get['wallet_id'])) {
            $get_params['wallet_id'] = $get['wallet_id'];
        }
        
        return $get_params;
    }
    
    public function actionIndex()
    {
        $get = $this->getAllowedParams_GET();
        
        $limit = $get['limit'] ?? 20;
        $offset = $get['offset'] ?? 0;

        $arrPeriod = DateHelper::getPeriodFromRequestAsInt(Reg::$app->request);
        $finder = Expenditure::find();
        $finder->with('Wallet');

        $finder->where(['user_id = :user_id'])->setParams(['user_id' => $this->user_id]);

        if (!is_null($arrPeriod['dateFrom']) && !is_null($arrPeriod['dateTo'])) {
            $finder->andWhere(['dateInt BETWEEN :dateFrom AND :dateTo'])->setParams($arrPeriod);
        } elseif (!is_null($arrPeriod['dateFrom'])) {
            $finder->andWhere(['dateInt >= :dateFrom'])->setParams(['dateFrom' => $arrPeriod['dateFrom']]);
        } elseif (!is_null($arrPeriod['dateTo'])) {
            $finder->andWhere(['dateInt <= :dateTo'])->setParams(['dateTo' => $arrPeriod['dateTo']]);
        }

        if (isset($get['wallet_id'])) {
            $finder->andWhere(['wallet_id = :wallet_id'])->setParams(['wallet_id' => $get['wallet_id']]);
        }
        $finder->orderBy('dateInt', 'DESC');
        $finder->limit($limit);
        
        if ($offset !== 0) {
            $finder->offset($offset);
        }
        
        $result = $finder->all();

        return $this->createResponse($this->createResponseData(true, $result, "OK"), 200);
    }

    public function actionShow()
    {
        $get = Reg::$app->request->get();
        
        if (!isset($get['id'])) {
            return $this->createResponse($this->createResponseData(false, null, "Param 'id' hsn't been transfered"), 404);
        }

        $modelObj = Expenditure::findById($get['id'], false);
        
        if (!$modelObj instanceof Expenditure) {
            return $this->createResponse($this->createResponseData(false, null, "Not found by id"), 404);
        }
        $modelObj->getRows();
      
        unset($modelObj->rows->owner);
        
        return $this->createResponse($this->createResponseData(true, $modelObj, "OK"), 200);
    }
}
