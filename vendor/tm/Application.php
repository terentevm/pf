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


    public static $request;

    public function __construct($config){
       
        session_start();
        
        $this->config = $config;
    }
    
    public function run(){

        if (!isset(self::$request)) {
            self::$request = Registry::CreateObject(Request::className());  
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