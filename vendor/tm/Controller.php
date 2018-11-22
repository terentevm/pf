<?php

namespace tm;

use tm\Base;
use tm\Registry as Reg;
use tm\Request;
use tm\ResponseData;

class Controller extends Base
{
    public static $default_controller = 'Site';
    
    public $route = [];
    public $layout;
    public $view;
    public $vars = [];
    
    public $attributes = [];
    public $errors = [];
    public $rules = [];
    
    protected $user_id = null;
    
    protected $container;
    protected $request;
    protected $response;

    public function __construct($request, $response, $route, $container)
    {
        $this->route = $route;
        $this->container = $container;
        $this->request = $request;
        $this->response = $response;
        $this->view = $route['action'];
        
        $userId = $container->get("userId");

        $this->user_id = $userId;
    }

    public function actions()
    {
        return array("Index", "Show", "Create", "Update");
    }
    
    public function createResponse(ResponseData $data, int $httpcode = 200, $msg = '')
    {
        
        $reqType = $this->request->getResponseType();
        
        if (is_string($data)) {
            $body = $data;
        } else {
            //$body = View::getRenderer($reqType, $this->route, $this->layout, $this->view)->render($data);
            $body = "<h1>HTML views don't support!</h1>";
        }
        
        $newResponse = $this->response->withStatus($httpcode)->withHeader('Content-type', $reqType)->withJson($data);  
        
        return  $newResponse ;

    }

    public function set($vars)
    {
        $this->vars = $vars;
    }
    
    public function getErrors()
    {
        $errors = '<ul>';
        foreach ($this->errors as $error) {
            $errors .= "<li>$error</li>";
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }

    public function createResponseData(bool $success, $returnData = null, string $message ="") : ResponseData
    {
        return  new ResponseData($success, $returnData, $message);
    }
}
