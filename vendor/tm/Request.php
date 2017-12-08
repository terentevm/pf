<?php

namespace tm;

/**
 * This class provide access to POST, GET, FILES superglobals
 */
class Request
{
    private $post = [];
    public $get = [];
    public $files = [];

    public function __construct() {

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

    public function set_get_params(array $params) {
        $this->get = $params;   
    }

    public function set_post_params(array $params) {
        $this->post = $params;   
    }

    public function set_files_params(array $files) {
        $this->files = $files;
    }

    public function isAjax() {
        return 
    }
}