<?php

namespace tm;

use tm\Base;
/**
 * This class provide access to POST, GET, FILES superglobals
 */
class Request extends Base
{
    private $post = [];
    private $get = [];
    private $files = [];
    private $headers = [];
    
    public function __construct($headers = [], $get = [], $post = [], $files = []) {
        $this->setHeaders($headers);
        $this->set_get_params($get);
        $this->set_post_params($post);
        $this->set_files_params($files);
    }

    public function get() {
        return $this->get;
    }

    public function post() {
        return $this->post;
    }

    public function files() {
        return $this->files;
    }

    public function set_get_params(array $params = []) {
        if (empty($params)) {
            $this->get = $_GET;   
        }
        else {
            $this->get = $params;   
        }
           
    }

    public function set_post_params(array $params = []) {
        if (empty($params)) {
            $this->post = $_POST;   
        }
        else {
            $this->post = $params;   
        }  
    }

    public function set_files_params(array $files = []) {
        if (empty($files)) {
            $this->files = $_FILES;   
        }
        else {
            $this->files = $files;   
        }
    }
    
    public function getHeaders($param_name = '') {
        if ($param_name == '') {
            return $this->headers;
        }
        else {
            if (array_key_exists($param_name, $this->headers)) {
                return $this->headers[$param_name];
            }
        }
        
        return null; //if given wrong header name
    }
    
    public function setHeaders(array $headers = []) {
        if(empty($headers)) {
            $this->headers = $_SERVER;    
        }
        else {
            $this->headers = $headers; 
        }
        
    }


    public function isAjax() {
        return isset($this->headers['HTTP_X_REQUESTED_WITH']) && $this->headers['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}