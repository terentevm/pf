<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Base;

use Base\Model;
/**
 * Description of QueryBuilder
 *
 * @author terentyev.m
 */
class QueryBuilder {
    
    private $sql;
    private $called_class;
    
    private $prefix = '';
    private $from = '';
    private $join = '';
    private $where = [];
    private $control = [];
    private $param = [];
    
    private $db_connect = null;
    
    public function __construct($called_class = '') {
        $this->called_class = $called_class;
        $this->db_connect = DB::getInstance();
    }
    
    public function select($fields = []) {
        
    }
    
    public function insert() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
    
    public function buildFieldsPart($fields) {
        
    }
    
}
