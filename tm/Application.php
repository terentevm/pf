<?php

namespace tm;

use tm\Base;

use tm\Request;
use tm\Router;
use tm\auth\AccessManager;
use tm\Response;
use tm\Configuration;

class Application extends Base
{
    private static $instance;

    public $config;
    
    public $user_id = null;
    public $access_manager = null;
    public $request;

    public function __construct(Configuration $config)
    {
        $this->config = $config;

        define('LANGUAGE', $config->getLang());
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
        
        if ($this->config->useCsrf()) {
            $_SESSION['csrf_token'] = md5($this->getGuide());
        }

        $router = Registry::CreateObject(Router::className(), []);
        
        $route = $router->getRoute();
        
        $check_status = $router->checkRoute();
        
        if ($check_status === 404) {
            (new Response(404, "Not found"))->send();
        }
        
        $this->access_manager = AccessManager::getAccessManager($router->route, $this->config);
        
        $access_is_allowed = $this->access_manager->checkAccess($router->route);
        
        if (!$access_is_allowed) {
            (new Response(401))->send();
        }
       
        try {
            $response = $router->route();
            $response->send();
        } catch (Exception $ex) {
            (new Response(500, "Some error"))->send();
        }
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
