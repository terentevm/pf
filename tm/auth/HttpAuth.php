<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\auth;

use tm\IInvokable;

use tm\auth\JwtExtractorFromHeader;
use tm\Request;
use tm\Registry;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;
use Slim\Exception\NotFoundException;

class HttpAuth implements IInvokable
{
    private $access_open = [];
    private $route = null;
    private $jwt_key = null;
    
    private $container;

    private $extractor;

    public function __construct($container, $config)
    {
        $this->access_open = require APP . '/config/config_access.php';
        $this->jwt_key = $config->getJwtKey();
        $this->container = $container;

        $this->extractor = new JwtExtractorFromHeader(); //TODO To make extractor fabric
    }
    
    public function __invoke($request, $response, $next)
    {
        $this->route = $request->getAttribute('route');

        if (is_null($this->route)){
            throw new NotFoundException($request, $response);
        }
        
        $response = $this->checkAccess($request, $response, $next);

        return $response;
    }

    public function checkAccess($request, $response, $next)
    {
        if (empty($this->access_open)) {
            return false;
        }
       
        $parsedBody = $request->getQueryParams();
        $get = $request->get();

        $route = $this->route->getArguments();

        $module = $route['module'];
        $controller = $route['controller'];
        $action = $route['action'];

        $openedRoute = false;

        if (is_null($module ) || is_null($controller )) {
            $this->container["userId"] = null;
            $response = $next($request, $response);
            return $response;
        }

        if (array_key_exists($module, $this->access_open)) {
            $mudule_rules = $this->access_open[$module]; //check module
            
            if (in_array('*', $mudule_rules)) { //all controllers are allowed
                $openedRoute = true;
            } else {
                if (array_key_exists($controller, $mudule_rules)) { //check controller
                    $actions = $mudule_rules[$controller];

                    if (in_array('*', $actions ) || in_array($action, $actions ) )  {
                        $openedRoute = true;
                    }

                }
            }
        }
        
        if ($openedRoute) {
            $this->container["userId"] = null;
            $response = $next($request, $response);
            return $response;
        }

        //extract JWT
        $jwt = $this->extractor->extractJWT($request);

        if (is_null($jwt)) {
            
            $newResponse = $response->withJson("Authentication error",401);

            return $newResponse;
        }
        
        try {
            
            $decoded_data = JWT::decode($jwt, $this->jwt_key, array('HS256'));
            $this->container["userId"] = $decoded_data->user_id;
            $response = $next($request, $response);
            return $response;

        } catch (SignatureInvalidException $ex) {
            
            $newResponse = $response->withJson("Authentication error",401);
            return $newResponse;

        } catch (ExpiredException $ex) {
            
            $newResponse = $response->withJson("Authentication error",401);
            return $newResponse;

        }
    
    }
    
    private function setUserId($data)
    {
        Registry::$app->user_id = $data->user_id ?? null;
    }
    
    public function generateNewToken(array $params) : string
    {
        return  JWT::encode($params, $this->jwt_key);
    }
}
