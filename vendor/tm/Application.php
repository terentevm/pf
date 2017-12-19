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
            if (self::$request->isAjax()) {
                (new Response('Authorisation error', 401))->sendResponse();
                die();
            }
            else {
                $router->redirect('/user/login');
                die();  
            }
            
        }
        $router->route();
    }
}