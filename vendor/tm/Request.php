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
    
    public function __construct($headers = [], $get = [], $post = [], $files = [])
    {
        $this->setHeaders($headers);
        $this->set_get_params($get);
        $this->set_post_params($post);
        $this->set_files_params($files);
    }

    public function get()
    {
        return $this->get;
    }

    public function post()
    {
        return $this->post;
    }

    public function files()
    {
        return $this->files;
    }

    public function set_get_params(array $params = [])
    {
        if (empty($params)) {
            $this->get = $_GET;
        } else {
            $this->get = $params;
        }
    }

    public function set_post_params(array $params = [])
    {
        $input_stream = file_get_contents('php://input');
        if (empty($params)) {
            if (isset($_POST) && !empty($_POST)) {
                $this->post = $_POST;
            } elseif (!empty($input_stream)) {
                $this->setPostFromInputSteam($input_stream);
            }
        } else {
            $this->post = $params;
        }
    }
    
    
    private function setPostFromInputSteam(string $input_stream)
    {
        $params = json_decode($input_stream, true);
        
        if (is_array($params) && !empty($params)) {
            $this->post = $params;
        }
    }
    
    public function set_files_params(array $files = [])
    {
        if (empty($files)) {
            $this->files = $_FILES;
        } else {
            $this->files = $files;
        }
    }
    
    public function getHeaders($param_name = '')
    {
        return $this->headers;
    }
    
    public function getHeader($header_key)
    {
        if (array_key_exists($header_key, $this->headers)) {
            return $this->headers[$header_key];
        }
        return '';
    }

    public function setHeaders(array $headers = [])
    {
        if (empty($headers)) {
            $this->headers = $_SERVER;
        } else {
            $this->headers = $headers;
        }
    }

    public function getResponseType()
    {
        $content_type = $this->getHeader('HTTP_ACCEPT');

        if (\preg_match('/html|HTML/', $content_type)) {
            return 'html';
        } elseif (\preg_match('/json|JSON/', $content_type)) {
            return 'json';
        }

        return 'html';
    }

    public function isAjax()
    {
        return isset($this->headers['HTTP_X_REQUESTED_WITH']) && $this->headers['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function getRequestMethod()
    {
        return $this->headers['REQUEST_METHOD'];
    }

    public function isCORSRequest()
    {
        $isCORS = $this->getHeader('HTTP_ACCESS_CONTROL_REQUEST_METHOD') !== '' ? true : false;
        return $isCORS;
    }
}
