<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\database;

/**
 *
 * @author terentyev.m
 */
interface IConnection
{
    public static function init($config);
    
    public function getPDO();
    
    public function log(string $message);

    /**
     * Calls stored function at database server
     * 
     * @param string $funcName example funcName(param1, param2,...)
     * @param array $funcParams
     */
    public function callFunction(string $funcName , array $funcParams = []);

    public function beginTransaction();
    
    public function commitTransaction();
    
    public function rollBackTransaction();
}
