<?php

namespace tm;

use Slim\Http\Request as SlimRequest;

use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;
use Slim\Interfaces\Http\HeadersInterface;
/**
 * This class is decorator for Slim\Http\Request for compatability with my old code
 */
class Request extends SlimRequest
{
    private $post_arr = [];
    private $get_arr  = [];


    public function __construct(
        $method,
        UriInterface $uri,
        HeadersInterface $headers,
        array $cookies,
        array $serverParams,
        StreamInterface $body,
        array $uploadedFiles = []
    ) {
        
        $this->set_get_params();
        $this->set_post_params();
        $this->set_files_params();
        parent::__construct(
            $method,
            $uri,
            $headers,
            $cookies,
            $serverParams,
            $body,
            $uploadedFiles = []
        );

    }

    public function get(string $key='')
    {
        if ($key !=='') {
            return $this->getQueryParam($key, null);
        }
        
        return $this->getQueryParams();
    }

    public function post(string $key='')
    {
        if ($key !=='') {
            $value = $this->post_arr[$key] ?? null;
            return $value;
        }

        return $this->getParsedBody();
    }

    public function set_get_params(array $params = [])
    {
        if (empty($params)) {
            $this->get_arr = $_GET;
        } else {
            $this->get_arr = $params;
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
        $params = \json_decode($input_stream, true);
        
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
    

    public function getResponseType()
    {
        $header = $this->getHeader('HTTP_ACCEPT');
        $content_type =  $header[0];
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
