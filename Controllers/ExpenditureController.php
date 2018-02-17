<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;

use tm\RestController;

use tm\helpers\DateHelper;
/**
 * Description of ExpenditureController
 *
 * @author terentyev.m
 */
class ExpenditureController extends RestController
{
    public static $classModel = '\models\Expenditure';

    public function actionIdex() {
        $get = Reg::$app->request->get();
        
        $limit = $get['limit'] ?? 50;
        $offset = $get['offset'] ?? 0;

        $arrPeriod = DateHelper::getPeriodFromRequest(Reg::$app->request);
        $finder = self::$classModel::find();
        $finder->with('Wallet');

        $finder->where(['user_id = :user_id'])->setParams(['user_id' => $this->user_id]);

        if (!is_null($arrPeriod['dateFrom']) && !is_null($arrPeriod['dateTo'])) {
            $finder->andWhere(['date BETWEEN :dateFrom AND :dateTo'])->setParams($arrPeriod);
        }
        elseif (!is_null($arrPeriod['dateFrom'])) {
            $finder->andWhere(['date >= :dateFrom'])->setParams(['dateFrom' => $arrPeriod['dateFrom']]);
        }
        elseif (!is_null($arrPeriod['dateTo'])) {
            $finder->andWhere(['date <= :dateTo'])->setParams(['dateTo' => $arrPeriod['dateTo']]);
        }

        if (isset($get['wallet_id'])) {
            $finder->andWhere(['wallet_id = :wallet_id'])->setParams(['wallet_id' => $get['wallet_id']]);   
        }
        $finder->orderBy('date', 'ASC');
        $finder->limit($limit);
        
        if ($offset !== 0) {
            $finder->offset();
        }
        
        $result = $finder->all();

        return $this->createResponse($result, 200);
    }

    public function actionShow() {
        $get = Reg::$app->request->get();  
        
        if (!isset($get['id'])) {
            return $this->createResponse('Not found', 404); 
        }

        $modelObj = static::$classModel::findById($get['id']);
        $modelObj->getRows();

        return $this->createResponse($modelObj, 200); 
    }

}
