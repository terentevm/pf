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
use Firebase\JWT\ExpiredException;

class HttpAuth implements AccessInterface
{
    private $access_open = [];
    private $route = null;
    private $jwt_key = null;
    
    public function __construct($route)
    {
        $this->access_open = require APP . '/config/config_access.php';
        $this->route = $route;
        $this->jwt_key = Registry::$app->config->getJwtKey();
    }
    
    public function checkAccess()
    {
        if (empty($this->access_open)) {
            return false;
        } 
        
        $module = $this->route['module'];
        
        if (array_key_exists($module, $this->access_open)) {
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
        
        $request = Registry::$app->request;
        $header = $request->getHeader('HTTP_AUTHORIZATION');
        if ($header == "") {
            return false;
        }
        list($type, $jwt) = explode(" ", $header);
        
        if ((strcasecmp($type, "Bearer") == 0)) {
            try {
                $decoded_data = JWT::decode($jwt, $this->jwt_key, array('HS256'));
                $this->setUserId($decoded_data);
                return true;
            } catch (SignatureInvalidException $ex) {
                return false;
            } catch (ExpiredException $ex) {
                return false;
            }
        }
        return false;
    }
    
    private function setUserId($data)
    {
        Registry::$app->user_id = $data->user_id ?? null;
    }
    
    public function generateNewToken($user_id) : string
    {
        $token = [
            'user_id' => $user_id,
        ];

        $client_ip = Registry::$app->request->server('REMOTE_ADDR');

        if(!is_null($client_ip )) {
            $token['ip'] = $client_ip;   
        }
        return  JWT::encode($token, $this->jwt_key);
    }
}
