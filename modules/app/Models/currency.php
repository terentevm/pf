<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\Models;
use tm\Model;
use tm\Registry as Reg;
/**
 * Description of Currency
 *
 * @author terentyev.m
 */
class Currency extends Model {
   
    private $id = null;
    private $code = '';
    private $name = '';
    private $short_name = '';
    private $user_id;
    
    public function __construct($id = null, $code = '', $name = '', $short_name = '', $user_id = '') {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->short_name = $short_name;
        $this->user_id = $user_id;
    }

    function getId() {
        return $this->id;
    }

    function getCode() {
        return $this->code;
    }

    function getName() {
        return $this->name;
    }

    function getShort_name() {
        return $this->short_name;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setShort_Name($short_name) {
        $this->short_name = $short_name;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }
    
    public static function getClassificator() 
    {
        $file_path = Reg::$app->config->getRateClassificatorFilePath();
        
        if ($file_path === '' || !is_file($file_path)) {
            return null;
        }
        
        $classificator_arr = require $file_path;
        
        return $classificator_arr ;
    }

    public static function SystemCurrensy()
    {
        $sysCurrency_arr = Reg::$app->config->getSystemCurrency();
       
        $sysCurrency = static::find()->where("short_name = :short_name")->setParam('short_name', sysCurrency_arr['short_name'])->limit(1)->one();
        
        return $sysCurrency;
    }

    public static function saveSystemCurrensy($user_id) {
        
        $sysCurrency = self::SystemCurrensy();

        if (is_null($sysCurrency)) {
            
            $sysCurrency_arr = Reg::$app->config->getSystemCurrency();
            
            $currensy = new self();
            
            $currensy->setUser_id($user_id);
            $currensy->setName($sysCurrency_arr['name']);
            $currensy->setShort_Name($sysCurrency_arr['short_name']) ;
            $currensy->setCode($sysCurrency_arr['code']);

            $success = $currensy->save();

            return $success;

        }
        else {
            return true;
        }

    }
}
