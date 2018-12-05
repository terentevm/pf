<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;

use tm\Model;
use tm\Mapper;

/**
 * Description of ProgramSettings
 *
 * @author terentyev.m
 */
class Settings extends Model implements \JsonSerializable
{
    private $user_id = null;
    private $currency_id = null;
    private $wallet_id = null;
    private $reportCurrency = null;

    private $currency = null;
    private $wallet = null;
    private $currencyReports = null;

    private $newUser = false;
    private $hasCurrencies = true;
    
    public function __construct($user_id = null, $currency_id = null, $wallet_id = null)
    {
        $this->user_id = $user_id;
        $this->currency_id = $currency_id;
        $this->wallet_id = $wallet_id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }
    
    public function setUser_Id($user_id)
    {
        $this->user_id = $user_id;
    }
    
    public function getCurrency_id()
    {
        return $this->currency_id;
    }
    
    public function setCurrency_id($currency_id)
    {
        $this->currency_id = $currency_id;
    }
    
    public function getWallet_id()
    {
        return $this->wallet_id;
    }
 

    public function setWallet_id($wallet_id)
    {
        $this->wallet_id = $wallet_id;
    }
    
    public function setNewUser($value)
    {
        $this->newUser = $value;
    }
    
    public function setHasCurrencies($value)
    {
        $this->hasCurrencies = $value;
    }

    /**
     * @return null
     */
    public function getReportCurrency()
    {
        return $this->reportCurrency;
    }

    /**
     * @param null $reportCurrency
     */
    public function setReportCurrency($reportCurrency): void
    {
        $this->reportCurrency = $reportCurrency;
    }

    public static function getFilterRules()
    {
        return [
            'currency_id' => FILTER_SANITIZE_SPECIAL_CHARS,
            'wallet_id' => FILTER_SANITIZE_SPECIAL_CHARS,
            'reportCurrency' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];
    }

    public static function getSettings($user_id)
    {
        $oSettings = Mapper::getMapper(get_called_class())
            ->with(['Currency', 'Wallet', 'ReportCurrency'])
            ->where(['user_id = :user_id'])
            ->limit(1)
            ->setParams(['user_id' => $user_id])
            ->one();


        if (is_null($oSettings)) {
            $oSettings = new self();
            $oSettings->setNewUser(true);
            $oSettings->setHasCurrencies(false);
            return $oSettings;
        }
        
        if ($oSettings->isNewUser() === true) {
            $oSettings->setNewUser(true) ;
            $oSettings->setHasCurrencies(false);
        }
        
        return $oSettings;
    }
    
    public function isNewUser()
    {
        if (is_null($this->user_id)) {
            return true;
        }
        
        if (is_null($this->currency_id) && is_null($this->wallet_id)) {
            return true;
        }
        
        return false;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

    public function save($upload_mode = false)
    {
        $settings = Mapper::getMapper(get_called_class())
            ->where(['user_id = :user_id'])
            ->limit(1)
            ->setParams(['user_id' => $this->user_id])
            ->one();

        if (empty($settings)) {
            $success = Mapper::getMapper(self::className())->save($this, false, true);
            return $success;
        }

        $mapper = Mapper::getMapper(self::className());

        $colsForUpdate = $mapper->mapModelToDb($this);

        $success = $mapper->where(['user_id = :user_id'])
            ->setParams(['user_id' => $this->user_id])
            ->update($this, $colsForUpdate);

        return $success;
    }
}
