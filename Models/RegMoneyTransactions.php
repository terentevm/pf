<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use tm\Model;
use Models\Expenditure;
use Models\Income;
use Models\Transfer;
use Models\ChangeBalance;

use Models\DocumentCollection;

class RegMoneyTransactions extends Model
{

    
    private $rows;
    private $modelId;
    private $condCol = '';
    
    public function getRows() {
        return $this->rows;
    }

    public function getModelId() {
        return $this->modelId;
    }

    public function getCondCol() {
        return $this->condCol;
    }

        
    /**
     * 
     * @param Model $model
     */
    public function loadModel(Model $model) {
        
        $this->modelId = $model->getId();
        
        if ($model instanceof Expenditure) {
            $this->condCol = 'expend_id';
            $this->loadExpenditure($model);
        }
        elseif ($model instanceof Income) {
            $this->condCol = 'income_id';   
        }
        elseif ($model instanceof Transfer) {
            $this->condCol = 'transfer_id'; 
        }
        elseif ($model instanceof ChangeBalance) {
            $this->condCol = 'cb_id'; 
        }
    }
    
    private function loadExpenditure($model) {
        $doc_sum = 0;
        
        foreach ($model->rows->strings() as $row) {
           $doc_sum += ($row->getSum() * -1) ;   
        }  
        
        $this->rows[] = [
                'date' => $model->getDate(),
                'wallet_id' => $model->getWallet_id(),
                'sum' => $doc_sum,
                'expend_id' => $model->getId(),
                'income_id' => null,
                'transfer_id' => null,
                'cb_id' => null
            ];
    }
    
    private function loadIncome($model) {
        $arrWallets = [];
        
        foreach ($model->rows->strings() as $row) {
            $wallet_id = $row->getWallet_id();
            if (array_key_exists($wallet_id, $arrWallets)) {
                $arrWallets[$wallet_id] += $row->getSum();    
            } else {
                $arrWallets[$wallet_id] = $row->getSum();
            }  
        } 
        
        foreach ($arrWallets as $wallet_id => $sum) {
            $this->rows[] = [
                'date' => $model->getDate(),
                'wallet_id' => $wallet_id,
                'sum' => $sum,
                'expend_id' => null,
                'income_id' => $model->getId(),
                'transfer_id' => null,
                'cb_id' => null
            ];   
        }
        
    }
}
