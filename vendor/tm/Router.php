<?php

namespace tm;

class Router extends Singleton{
    
    public $controller;
    public $action;
    public $id;
    private $path_elements = array('controller','action','id');
    function parse($path,$config){
        $request = $_REQUEST;
        $request['controller'] = $config['default_controller'];
        $request['action'] = $config['default_action'];
        $request['id'] = 0;
        $parts = parse_url($path);
        if (isset($parts['query']) and !empty($parts['query'])) {
          $path = str_replace('?'.$parts['query'], '', $path);
          parse_str($parts['query'], $req);
          $request = array_merge($request, $req);
        }
        foreach($config['router'] as $rule=>$keypath) {
          if (preg_match('#'.$rule.'#sui', $path, $list)) {
            for ($i=1; $i<count($list); $i=$i+1) {
              $keypath = preg_replace('#\$[a-z0-9]+#', $list[$i], $keypath, 1);
            }
            $keypath = explode('/', $keypath);
            foreach($keypath as $i=>$key) {
              $request[$this->path_elements[$i]] = $key;
            }
          }
        }
        return $request;
      }   
}