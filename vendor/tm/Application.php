<?php

namespace tm;
use tm\Controller;
use Controllers\SiteController;
use tm\Db;

class Application extends Singleton{
    public $config;

    public function __construct($config){
       
        session_start();
       // session_regenerate_id(1);
     
        $this->config = $config;
    }
    
    public function Run(){
        $Controller_params = [];

        $_SESSION['isAjax'] = $this->isAjax();
        define("LANGUAGE", $this->config['lang']);

        if(!isset($_REQUEST['route'])){
            $Controller = 'Controllers\SiteController';
            $action = 'actionIndex';

            $Controller_params = [
                'controller' => 'site',
                'action' => 'index'
            ];
        }
        else{
            $reqest = Router::gi()->parse($_REQUEST['route'],$this->config);
            $Controller = "Controllers". "\\" . ucfirst($reqest["controller"]) . "Controller";
            $action = 'action' . $reqest['action'];

            $Controller_params = [
                'controller' => $reqest['controller'],
                'action' => $reqest['action']
            ];
        }
        if(!$this->check_token($_POST)){
            die('token error');
        }
        if (class_exists($Controller)){
            $Controller = New $Controller($Controller_params);
        }
        else{
            die ('404 Not Found');
        }

         // if action doesn't exists - 404
         if (is_callable(array($Controller, $action)) == false) {
            die ('404 Not Found');
        }
           
        //authorisation check
          
        if (($Controller_params['controller'] == 'user' && $Controller_params['action'] == 'logout') || ($Controller_params['controller'] == 'user' && $Controller_params['action'] == 'login') || ($Controller_params['controller'] == 'user' && $Controller_params['action'] == 'signup')){
            $Controller->$action();
            exit();
        }
        
        if((!isset($_SESSION['success'])) || (!isset($_SESSION['user_id'])) || (isset($_SESSION['success']) && $_SESSION['success'] == FALSE)){
            
            if($this->CheckSession()){
                $_SESSION['success'] = TRUE;
                $Controller->$action();
            }
            else{
                header('Location: /user/login');
                exit();
            }
                
        }
        else {
            $Controller->$action();
        }

    }
    
    public function CheckSession(){
        
        if(!isset($_SESSION['user_id'])){
            return FALSE;  
        }
        
        return TRUE;
    }
    
    public function check_token($post) {
        if(!isset($_SESSION['csrf_token'])){
            $_SESSION['csrf_token'] = md5(random_bytes(10));
            return true;
        }
        
        if($this->isAjax()){
            
        }
        else{
            if(isset($_POST) && !empty($_POST)){
                if(!isset($_POST['csrf_token'])){
                    return false;
                }
                else{
                    if($_POST['csrf_token'] <> $_SESSION['csrf_token']){
                        return false;
                    }
                }
            }
        }
        
        return true;
    }
  
    public function isAjax(){
       return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}