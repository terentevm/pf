<?php

namespace tm;

use tm\Base;
use tm\Response;

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
        
        $body = View::getRenderer($this->route, $this->layout, $this->view)->render($data);

        return new Response($httpcode, $body,  $msg);

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