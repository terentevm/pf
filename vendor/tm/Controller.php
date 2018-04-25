<?php

namespace tm;

use tm\Base;
use tm\Registry as Reg;
use tm\Request;

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
    
    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];
        $this->user_id = Reg::$app->user_id;
        
    }

    public function createResponse($data = null, int $httpcode = 200, $msg = '')
    {
        $reqType = Reg::$app->request->getResponseType();
        
        if (is_string($data)) {
            $body = $data;   
        }
        else {
            $body = View::getRenderer($reqType, $this->route, $this->layout, $this->view)->render($data);   
        }
        
        $response = new Response($httpcode, $body);
        $response->setContentType($response->createContentType($reqType));
        
        return $response;
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
}
