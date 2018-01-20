<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\auth;

use tm\auth\AccessInterface;
use tm\Request;
use tm\Registry;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;

class HttpAuth implements AccessInterface 
{
    private $access_open = [];
    private $route = null;
    
    public function __construct($route) {
        $this->access_open = require APP . '/config/config_access.php';
        $this->route = $route;
    }
    
    public function checkAccess() {
        if (!empty($this->access_open) && in_array($this->route['controller'], $this->access_open)) {
            return true;
        }
        $request = Registry::$app->request;
        $header = $request->getHeader('HTTP_AUTHORIZATION');
        list($type, $data) = explode(" ",$header);
        
        if ((strcasecmp($type, "Bearer") == 0)) {
            try {
                return true;
            } catch (SignatureInvalidException $ex) {
                return false;
            }
        }
        return false;
    }
}
