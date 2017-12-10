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
    private $response = '';
    
    public function __construct($response = '',int $http_code = 200) {
        $this->http_code = $http_code;
        $this->response = $response;
    }
    
    public function sendResponse() {
        header(http_response_code($this->http_code)); 
        
        echo $this->response;
    }
}
