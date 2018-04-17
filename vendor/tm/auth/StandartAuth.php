<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\auth;

use tm\auth\AccessInterface;
use tm\Request;

/**
 * Description of StandartAuth
 *
 * @author terentyev.m
 */
class StandartAuth implements AccessInterface
{
    private $access_open = [];
    private $route = null;


    public function __construct(array $route)
    {
        $this->access_open = require APP . '/config/config_access.php';
        $this->route = $route;
    }


    public function checkAccess()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        
        if (empty($this->access_open)) {
            return false;
        } 
        if (in_array($this->route['module'], $this->access_open)) {
             $mudule_rules = $this->access_open[$this->route['module']]; //check module

             if (in_array('*', $mudule_rules)) { //all controllers are allowed
                 return true;
             }
             else {
                if (in_array($this->route['controller'], $mudule_rules)) { //check controller
                    return true;
                }  
             } 
         }

         return false;
    }
}
