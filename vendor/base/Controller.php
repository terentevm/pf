<?php

namespace Base;

Class Controller{

    public $route = [];
    public $layout;
    public $view;
    public $vars = [];
    
    public $attributes = [];
    public $errors = [];
    public $rules = [];
    
    public function __Construct($route){
        $this->route = $route;
        $this->view = $route['action'];
    }

    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
    
    public function GetView(){
        $View_Obj = new View($this->route, $this->layout, $this->view);
        $View_Obj->Render($this->vars);
    }

    public function Set($vars){
        $this->vars = $vars;
    }

    public function debug($arr){
        echo '<pre>' .print_r($arr,true).'</pre>';
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