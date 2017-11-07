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
    
    public function validate($data, $rules){
        
        foreach($rules as $rule => $fields){
            if($rule == 'required'){
                $this->ValidateRequired($data,$fields);    
            }
            if($rule == 'email'){
               $this->ValidateEmail($data,$fields);  
            }
        }
        
        if(empty($this->errors)){
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function ValidateRequired($data,$fields){
        foreach($fields as $field){
            if(isset($data[$field]) && empty($data[$field])){
                $this->errors[] = 'Field ' . $field . ' is empty!' ;  
            }
        }   
    }
    
    public function ValidateEmail($data,$fields){
       foreach($fields as $field){
            if(isset($data[$field])){
                $email_validate = filter_var($data[$field], FILTER_VALIDATE_EMAIL);
                
                if(!$email_validate){
                   $this->errors[] = 'In field ' . $field . ' email is incorrect!' ; 
                }
            }
        }  
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