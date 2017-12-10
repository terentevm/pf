<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\auth;

use tm\Registry;
/**
 * Description of AccessManager
 *
 * @author terentyev.m
 */
class AccessManager {

    public static function getAccessManager($route) {
        return Registry::CreateObject('tm\auth\StandartAuth', [$route]);    
    }
}
