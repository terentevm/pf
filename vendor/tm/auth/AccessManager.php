<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\auth;

use tm\Registry;
use tm\Configuration;

/**
 * Description of AccessManager
 *
 * @author terentyev.m
 */
class AccessManager
{
    public static function getAccessManager($route, Configuration $config)
    {
        if ($config->useHttpAuth()) {
            return Registry::CreateObject('tm\auth\HttpAuth', [$route]);
        }
        
        return Registry::CreateObject('tm\auth\StandartAuth', [$route]);
    }
}
