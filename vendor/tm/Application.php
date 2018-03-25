<?php

namespace tm;

use tm\Base;

use tm\Request;
use tm\Router;
use tm\auth\AccessManager;
use tm\Response;

class Application extends Base
{
    private static $instance;

    public $config;
    
    public $user_id = null;
    public $access_manager = null;
    public $request;

    public function __construct($config)
    {
        session_start();
        
        $this->config = $config;

        define('LANGUAGE', $this->config['lang']);
    }
    
    public function run()
    {
        if (!isset(self::$request)) {
            $this->request = Registry::CreateObject(Request::className());
        }
        
        if ($this->request->isCORSRequest()) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Accept, X-PINGOTHER, Content-Type");
            (new Response(200))->send();
        }
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization, Origin, X-Requested-With, Accept, X-PINGOTHER, Content-Type");
        if (isset($this->config['use_csrf_token']) && $this->config['use_csrf_token']) {
            $_SESSION['csrf_token'] = md5($this->getGuide());
        }

        $router = Registry::CreateObject(Router::className(), [1 => $this->config]);
        
        $route = $router->getRoute();
        
        $this->access_manager = AccessManager::getAccessManager($route, $this->config);
        
        $access_is_allowed = $this->access_manager->checkAccess($route);
        
        if (!$access_is_allowed) {
            (new Response(401))->send();
        }
       
        
        $response = $router->route();
        $response->send();
    }

    public function startSession($param)
    {
        $_SESSION['success'] = true;
        $_SESSION['user_id'] = $param['user_id'];
    }

    public function endSession()
    {
        $_SESSION['success'] = false;
        unset($_SESSION['user_id']);
        session_destroy();
    }
}
