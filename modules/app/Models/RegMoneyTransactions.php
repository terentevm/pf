<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;

use tm\Model;
use app\Models\Expenditure;
use app\Models\Income;
use app\Models\Transfer;
use app\Models\ChangeBalance;
use app\Models\Lend;

class RegMoneyTransactions extends Model
{
    private $rows;
    private $modelId;
    private $condCol = '';

    public function getRows()
    {
        return $this->rows;
    }

    public function getModelId()
    {
        return $this->modelId;
    }

    public function getCondCol()
    {
        return $this->condCol;
    }

    /**
     *
     * @param Model $model
     */
    public function loadModel(Model $model)
    {
        $this->rows = array();

        $this->modelId = $model->getId();

        if ($model instanceof Expenditure) {
            $this->condCol = 'expend_id';
            $this->loadExpenditure($model);
        } elseif ($model instanceof Income) {
            $this->condCol = 'income_id';
            $this->loadIncome($model);
        } elseif ($model instanceof Transfer) {
            $this->condCol = 'transfer_id';
            $this->loadTransfer($model);
        } elseif ($model instanceof ChangeBalance) {
            $this->condCol = 'cb_id';
            $this->loadChangeBalance($model);
        } elseif ($model instanceof Lend) {
            $this->condCol = 'lend_id';
            $this->loadLend($model);
        } else {
            throw new \Exception('Instance of model: ' . get_class($model) . " doesn't support for saving to the moneys register!");
        }
    }

    private function loadExpenditure($model)
    {
        $doc_sum = 0;

        foreach ($model->rows->strings() as $row) {
            $doc_sum += ($row->getSum() * -1);
        }

        $this->rows[] = [
            'date' => $model->getDate(),
            'dateInt' => strtotime($model->getDate()),
            'wallet_id' => $model->getWallet_id(),
            'sum' => $doc_sum,
            'expend_id' => $model->getId(),
            'income_id' => null,
            'transfer_id' => null,
            'cb_id' => null,
            'lend_id' => null,
        ];
    }

    private function loadIncome($model)
    {
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
                'dateInt' => strtotime($model->getDate()),
                'wallet_id' => $wallet_id,
                'sum' => $sum,
                'expend_id' => null,
                'income_id' => $model->getId(),
                'transfer_id' => null,
                'cb_id' => null,
                'lend_id' => null,
            ];
        }
    }

    private function loadTransfer($model)
    {
        $this->rows[] = [
            'date' => $model->getDate(),
            'dateInt' => strtotime($model->getDate()),
            'wallet_id' => $model->getWallet_id_from(),
            'sum' => $model->getSumFrom() * -1,
            'expend_id' => null,
            'income_id' => null,
            'transfer_id' => $model->getId(),
            'cb_id' => null,
            'lend_id' => null,
        ];

        $this->rows[] = [
            'date' => $model->getDate(),
            'dateInt' => strtotime($model->getDate()),
            'wallet_id' => $model->getWallet_id_to(),
            'sum' => $model->getSumTo(),
            'expend_id' => null,
            'income_id' => null,
            'transfer_id' => $model->getId(),
            'cb_id' => null,
            'lend_id' => null,
        ];
    }

    public function loadChangeBalance($model)
    {
        $sum = ($model->getSumExpend() > 0) ? $model->getSumExpend() * -1 : $model->getSumIncome();

        $this->rows[] = [
            'date' => $model->getDate(),
            'dateInt' => strtotime($model->getDate()),
            'wallet_id' => $model->getWallet_id(),
            'sum' => $sum,
            'expend_id' => null,
            'income_id' => null,
            'transfer_id' => null,
            'cb_id' => $model->getId(),
            'lend_id' => null,
        ];
    }
    
    public function loadLend($model)
    {
        $sum = $model->getSum() * -1;

        $this->rows[] = [
            'date' => $model->getDate(),
            'dateInt' => strtotime($model->getDate()),
            'wallet_id' => $model->getWallet_id(),
            'sum' => $sum,
            'expend_id' => null,
            'income_id' => null,
            'transfer_id' => null,
            'cb_id' => null,
            'lend_id' => $model->getId(),
        ];
    }
}
