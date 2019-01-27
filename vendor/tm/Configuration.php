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

        $module_settings = &$this->config['modules_settings'];

        if (isset($module_settings[$module])) {
            return $module_settings[$module]['default_controller'];
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
    
    public function getRateClassificatorFilePath() : string
    {
        $val = (isset($this->config['currensy_classificator_file'])) ? $this->config['currensy_classificator_file'] : "";
        return $val;
    }

    public function getSystemCurrency()
    {
        return (isset($this->config['systemCurrency'])) ? $this->config['systemCurrency'] : [
            "name"=> "Czech koruna",
            "short_name"=> "CZK",
            "code"=> "203",
            "mult"=> "1"
            ];
    }

}
