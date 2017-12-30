<?php

namespace tm;
use tm\Base;
use tm\Controller;
use Controllers\SiteController;
use tm\Db;
use tm\Request;
use tm\Router;
use tm\auth\AccessManager;
use tm\Response;

class Application extends Base{
    
    private static $instance; 

    public $config;


    public $request;

    public function __construct($config){
       
        session_start();
        
        $this->config = $config;

        define('LANGUAGE', $this->config['lang']);
    }
    
    public function run(){

        if (!isset(self::$request)) {
            $this->request = Registry::CreateObject(Request::className());  
        }
        
        if (isset($this->config['use_csrf_token']) && $this->config['use_csrf_token']) {
            $_SESSION['csrf_token'] = md5($this->getGuide());
        }

        $router = Registry::CreateObject(Router::className(), [1 => $this->config]);
        
        $route = $router->getRoute(); 
        
        $access_manager = AccessManager::getAccessManager($route);
        
        $access_is_allowed = $access_manager->checkAccess($route);
        
        if (!$access_is_allowed) {
            if ($this->request->isAjax()) {
                (new Response(401,'' ,'Authorisation error'))->send();
                die();
            }
            else {
                $router->redirect('/user/login');
                die();  
            }
            
        }
        $response = $router->route();
        $response->send();
    }

    public function startSession($param) {
        $_SESSION['success'] = true;
        $_SESSION['user_id'] = $param['user_id'];
    }

    public function endSession() {
        $_SESSION['success'] = false;
        unset($_SESSION['user_id']);
        session_destroy();
    }
}