<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;
use tm\Model;
use tm\TraitModelFunc;
/**
 * Description of Currency
 *
 * @author terentyev.m
 */
class Currency extends Model {
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

    function setShort_name($short_name) {
        $this->short_name = $short_name;
    }

    function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

        private $id;
    private $code = '';
    private $name = '';
    private $short_name = '';
    private $user_id;
    
    use TraitModelFunc;
    

    public static function setTableName(){
        return 'dic_currency';
    }
    
    public static function getForeignKeys() {
        return [
		'user_id' => [
			'key' => 'id',
			'table' => 'users'
                    ]
                ];
    }
    
    public static function getPrimaryKeys(){
        return ['id'];
    }
    
    
}
