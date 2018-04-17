<?php


namespace tm;


class Configuration
{
    
    private $config = null;
    
    public function __construct() 
    {
        $this->config = require(__DIR__ . '/config.php');
    }
    
    public function getDefaultModule() : string
    {
        if (isset($this->config['default_module'])) {
            return $this->config['default_module'];
        }
        
        return '';
    }
    
    public function getDefaultController(string $module) : string 
    {
        if (!isset($this->config['modules_settings'])) {
            return '';
        }
        
        $mudule_settings = &$this->config['modules_settings'];
        
        if (isset($mudule_settings[$module])) {
            return $mudule_settings[$module]['default_controller'];
        }
        
        return '';
    }
    
    public function useSessions() : bool 
    {
        $val = (isset($this->config['use_sessions'])) ? $this->config['use_sessions'] : false;
        return $val;
    }
    
    public function useCsrf() : bool  
    {
        $val = (isset($this->config['use_csrf_token'])) ? $this->config['use_csrf_token'] : false;
        return $val;
    }
    
    public function useHttpAuth() : bool 
    {
        $val = (isset($this->config['http_auth'])) ? $this->config['http_auth'] : false;
        return $val;
    }
    
    public function getJwtKey() : string 
    {
        $val = (isset($this->config['jwt_key'])) ? $this->config['jwt_key'] : "fsfsdgdgd-dfgfdgfdh4564465465fh-4%%#%#T#%#4gfdg#Rf4g8f4dh4fdhhfd";
        return $val;    
    }
    
    public function getLang() : string 
    {
        $val = (isset($this->config['lang'])) ? $this->config['lang'] : "en-GB";
        return $val;   
    }
        
}
