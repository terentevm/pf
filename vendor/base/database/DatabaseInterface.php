<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace base\database;

/**
 *
 * @author terentyev.m
 */
interface DatabaseInterface {
    
    public function prepare(string $sql) :bool;
    
    public function execute(array $param) :bool;
    
    public function setFetchMode_Default() :bool;
    
    public function setFetchMode_Class(string $className) :bool;
    
    public function setFetchMode_Column(int $col) :bool;
    
    public function setFetchMode_Into($obj) :bool;
    
    public function fetchAll();
    
    public function fetchOne();
    
    public function beginTransaction() :bool;
    
    public function commitTransaction() :bool;
    
    public function rollBackTransaction() :bool;
}
