<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm;

/**
 * Description of Response
 *
 * @author terentyev.m
 */
class Response {
    
    private $http_code = 200;
    private $msg ='';
    private $body ='';
    
    public function __construct(int $http_code = 200, $body = '', $msg ='') {
        $this->http_code = $http_code;
        $this->body = $body;
        $this->msg = $msg;
    }
    
    public function send() {
        header(http_response_code($this->http_code)); 
        
        echo $this->body;
    
    }
}
