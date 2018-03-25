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
    
    public function beginTransaction();
    
    public function commitTransaction();
    
    public function rollBackTransaction();
}
