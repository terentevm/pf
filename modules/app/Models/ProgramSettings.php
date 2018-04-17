<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;

use tm\Model;

/**
 * Description of ProgramSettings
 *
 * @author terentyev.m
 */
class ProgramSettings extends Model {
    
    private $user_id;
    private $currency;
    private $wallet;

    public function __construct($user_id, $currency, $wallet) {
        $this->user_id = $user_id;
        $this->currency = $currency;
        $this->wallet = $wallet;
    }

    public function getUser() {
        return $this->user;
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function getWallet() {
        return $this->wallet;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setWallet($wallet) {
        $this->wallet = $wallet;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public static function getSettings($user_id, $asArray = true) {
        $params = ['user_id' => $user_id];
        
        if($asArray === true) {
            $settings = static::find()->with(['currency','wallet'])->where(['id = :user_id'])->asArray()->setParams($params)->one();
        }
        else {
            $settings = static::find()->with(['currency','wallet'])->where(['id = :user_id'])->setParams([$params])->one();
        }
        
        if (is_null($settings) || empty($settings)) {
            return [
                'currency' => null,
                'wallet' => null
            ];
        }

        return $settings;
    }
}
