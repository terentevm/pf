<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;

use tm\Model;
use tm\Registry as Reg;
use app\mappers\CurrencyMapper;
/**
 * Description of Currency
 *
 * @author terentyev.m
 */
class Currency extends Model implements \JsonSerializable
{
    private $id = null;
    private $code = '';
    private $name = '';
    private $short_name = '';
    private $user_id;
    
    public function __construct($id = null, $code = '', $name = '', $short_name = '', $user_id = '')
    {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->short_name = $short_name;
        $this->user_id = $user_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getShort_name()
    {
        return $this->short_name;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setShort_Name($short_name)
    {
        $this->short_name = $short_name;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }
    
    public static function getClassificator()
    {
        $container = Reg::getContainerDI();
        $file_path = $container['conf']->getRateClassificatorFilePath();
        
        if ($file_path === '' || !is_file($file_path)) {
            return null;
        }
        
        $classificator_arr = require $file_path;
        
        return $classificator_arr ;
    }

    public static function systemCurrensy()
    {
        $container = Reg::getContainerDI();
        $sysCurrency_arr = $container['conf']->getSystemCurrency();
       
        $sysCurrency = static::find()
            ->where(["short_name = :short_name"])
            ->andWhere("user_id = :userId")
            ->setParam('short_name', $sysCurrency_arr['short_name'])
            ->setParam('userId', $container->get("userId"))
            ->limit(1)
            ->one();
       
        return $sysCurrency;
    }
    
    public static function isSystemCurrency($charCode)
    {
        
        $container = Reg::getContainerDI();
        $sysCurrency_arr = $container['conf']->getSystemCurrency();

        return $sysCurrency_arr['short_name'] == $charCode ? true : false;
    }

    public static function getSystemCurrency($user_id)
    {
        $settingsByUser = Settings::getSettings($user_id);

        if ($settingsByUser instanceof Settings) {
            return $settingsByUser->getCurrency();
        }

        $container = Reg::getContainerDI();
        $logger = $container['logger'];
        $logger->error("Base currency hasn't been found for user with id: " . $user_id);

        return null;

    }

    public static function saveSystemCurrensy($user_id)
    {
        $sysCurrency = self::SystemCurrensy();

        if (is_null($sysCurrency)) {
            $container = Reg::getContainerDI();
            $sysCurrency_arr = $container['conf']->getSystemCurrency();
            
            $currensy = new self();
            
            $currensy->setUser_id($user_id);
            $currensy->setName($sysCurrency_arr['name']);
            $currensy->setShort_Name($sysCurrency_arr['short_name']) ;
            $currensy->setCode($sysCurrency_arr['code']);

            $success = $currensy->save();

            return $success;
        } else {
            return true;
        }
    }
    
    public static function addRatesToResult(array $result, string $date) {
        $array_id = [];
        
        foreach ($result as $row) {
            if (is_array($row)) {
                array_push($array_id, $row['id']);   
            }
            else {
                array_push($array_id, $row->getId());    
            }     
        }
        
        $dateInt = strtotime($date);
        
        $mapper = new CurrencyMapper(get_called_class());

        $container = Reg::getContainerDI();

        $rates = $mapper->getRates($container['userId'], $array_id, $dateInt);

        foreach ($rates as $rateRow) {
            foreach ($result as &$row) { 
                if ($row['code'] == $rateRow['code']) {
                    $row['mult'] = $rateRow['mult'];
                    $row['rate'] = $rateRow['rate']; 
                }
            }   
        }
        

        return $result;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
