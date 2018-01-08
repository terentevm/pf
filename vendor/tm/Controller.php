<?php

namespace tm;

use tm\Base;
use tm\Registry;
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
    
    public function __construct($route){
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function createResponse($data = null, int $httpcode = 200, $msg = '') {
        
        $reqType = Registry::$app->request->getResponseType();
        $body = View::getRenderer($reqType,$this->route, $this->layout, $this->view)->render($data);

        $response = new Response($httpcode, $body);
        $response->setContentType($response->createContentType($reqType));
        
        return $response;

    }

    public function set($vars) {
        $this->vars = $vars;
    }
    
    public function getErrors(){
        $errors = '<ul>';
        foreach($this->errors as $error){
            
            $errors .= "<li>$error</li>";
            
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }
}