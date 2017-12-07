<?php

namespace tm\di;

use tm\di\ContainerInterface;
/**
 * Description of Container
 *
 * @author terentyev.m
 */
class Container implements ContainerInterface
{
    
    private $services;
    private $parameters;
    private $serviceStore;
    
    public function __construct(array $services = [], array $parameters = []) {
        $this->services     = $services;
        $this->parameters   = $parameters;
        $this->serviceStore = [];
    }
    
    public function get($name) {
        if(!isset($this->has($name))) {
            throw new \Exception('Service not found: '.$name);
        }
        
        if (!isset($this->serviceStore[$name])) {
            $this->serviceStore[$name] = $this->createService($name);
        }

        return $this->serviceStore[$name];
    }
    
    public function has($name) {
        return isset($this->services[$name]);    
    }
}
