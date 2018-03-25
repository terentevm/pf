<?php

namespace tm;

use tm\Base;
use tm\Request;

class Router extends Base
{
    private $request;
    private $config = [];
    public $route = [];
   
    public $id;
    private $path_elements = array('controller','action','id');
    
    private $router = array(
        '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)/([0-9]+)' => '$controller/$action/$id',
        '([a-z0-9+_\-]+)/([a-z0-9+_\-]+)' => '$controller/$action',
        '([a-z0-9+_\-]+)(/)?' => '$controller',
        );
    
    public function __construct(Request $request, array $config)
    {
        $this->request = $request;
        $this->config = $config;
    }
    
    public function route()
    {
        $this->getRoute();
        
        if (!isset($this->route['controller'])) {
            $this->route = [
                'controller' => $this->config['default_controller'],
                'action' => $this->config['default_action']
                ];
        }
        
        $controller_name = 'Controllers\\' . ucfirst($this->route['controller']) .'Controller';
        
        try {
            $reflection = new \ReflectionClass($controller_name);
        } catch (\ReflectionException $ex) {
            die('404 Not found');
        }
        
        if (isset($this->route['action'])) {
            $action_name = $this->route['action'];
        } else {
            $this->route['action'] = preg_replace('/action/', '', $reflection->getStaticPropertyValue('defaultAction', ''));
        }
        
        
        if ($this->route['action'] === '') {
            die('404 Not found');
        }
        
        $controller = $reflection->newInstanceArgs([$this->route]);
        
        $action_name = 'action' . ucfirst(($this->route['action']));
        
        $action = $reflection->getMethod($action_name);
        
        try {
            return $action->invoke($controller);
        } catch (ReflectionException $ex) {
            die('404 Not found');
        }
    }
    
    private function createController($controller)
    {
        $controller_name = 'Controllers\\' . ucfirst($controller) .'Controller';
        if (class_exists($controller_name)) {
            return new $controller_name($this->route);
        }
        
        return null;
    }
            
    public function getRoute()
    {
        /*$this->route = [
            'controller' => $this->config['default_controller'],
            'action' =>$this->config['default_action']
        ];*/
        
        $path = $this->request->get()['route'];
        $parts = parse_url($path);
        if (isset($parts['query']) and !empty($parts['query'])) {
            $path = str_replace('?'.$parts['query'], '', $path);
            parse_str($parts['query'], $req);
            $this->route = array_merge($request, $req);
        }
        foreach ($this->router as $rule=>$keypath) {
            if (preg_match('#'.$rule.'#sui', $path, $list)) {
                for ($i=1; $i<count($list); $i=$i+1) {
                    $keypath = preg_replace('#\$[a-z0-9]+#', $list[$i], $keypath, 1);
                }
                $keypath = explode('/', $keypath);
                foreach ($keypath as $i=>$key) {
                    $this->route[$this->path_elements[$i]] = $key;
                }
            }
        }
        
        return $this->route;
    }
    
    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}
