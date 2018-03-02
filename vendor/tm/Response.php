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
    private $body ='';
    private $headers = [];
    
    public function __construct(int $http_code = 200, $body = '', $headers = []) {
        $this->http_code = $http_code;
        $this->body = $body;
        $this->headers = $headers;
    }
    
    public function setHeader(string $header, string $value) {
        $this->header[$header] =  $value;
    }

    public function setHttpCode(int $code) {
        $this->http_code = $code;    
    }

    public function setContentType($content_type) {
        $this->headers['Content-Type'] = $content_type;
    }

    /**
     * Creates correct header 'Content-Type'
     * @param string type (example: html, json)
     * @return string correct content-type (example: application/json, text/html)
     */
    public function createContentType($type) {
        switch($type) {
            case 'json': return 'application/json';
            case 'html': return 'text/html';
            default: return 'text/html';
        }
    }

    public function send() {
       
        header(http_response_code($this->http_code)); 

        foreach ($this->headers as $header => $value) {
            header($header . ": " . $value);
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: content-type,authorization");
        
        echo $this->body;
        die();
    
    }
}
