<?php

namespace tm\di;

use tm\di\ContainerInterface;
use ReflectionClass;
use tm\di\Instance;

/**
 * Description of Container
 *
 * @author terentyev.m
 */
class Container implements ContainerInterface
{
    /**
     * @var array cached ReflectionClass object indexed by their name
     */
    private $_reflections = [];
    
    /**
     * @var array contains class names that must be as singletons
     */
    private $singletons = [];
    
    /**
    * @var array cached objects - singletons indexed by class name;
    */
    private $object_store = [];
    
    /**
     * @var array cached dependencies indexed by class names.
     */
    private $_dependencies = [];
    
    public function get($class, $params = [])
    {
        if (is_string($class)) {
            $class_name = $class;
        } elseif ($class instanceof Instance) {
            $class_name = $class->id === null ? '' : $class->id;
        }
       
        
        $class_is_singleton = $this->isSingleton($class_name);
        
        if ($class_is_singleton) {
            if (array_key_exists($class_name, $this->object_store)) {
                return $this->object_store[$class_name];
            }
        }
        
        $object = $this->build($class, $params);
        
        if ($class_is_singleton) {
            if (is_string($class)) {
                $this->object_store[$class] = $object;
            } elseif ($class instanceof Instance) {
                $this->object_store[$class->id] = $object;
            }
        }
        
        return $object;
    }

    /**
     * Creates an instance of the specified class.
     * This method will resolve dependencies of the specified class, instantiate them, and inject
     * them into the new instance of the specified class.
     * @param string $class the class name
     * @param array $params constructor parameters
     * @param array $config configurations to be applied to the new instance
     * @return object the newly created instance of the specified class
     * @throws Exeption If resolved to an abstract class or an interface (since 2.0.9)
     */
    protected function build($class, $params)
    {
        list($reflection, $dependencies) = $this->getDependencies($class);
        
        foreach ($params as $index => $param) {
            $dependencies[$index] = $param;
        }

        $dependencies = $this->resolveDependencies($dependencies, $reflection);
        if (!$reflection->isInstantiable()) {
            throw new \Exception($reflection->name);
        }
        if (empty($config)) {
            return $reflection->newInstanceArgs($dependencies);
        }

        if (!empty($dependencies) && $reflection->implementsInterface('yii\base\Configurable')) {
            // set $config as the last parameter (existing one will be overwritten)
            $dependencies[count($dependencies) - 1] = $config;
            return $reflection->newInstanceArgs($dependencies);
        }

        $object = $reflection->newInstanceArgs($dependencies);
        foreach ($config as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }

    protected function getDependencies($class)
    {
        if (is_string($class)) {
            $class_str = $class;
        } elseif ($class instanceof Instance) {
            $class_str = $class->id;
        }
        
        if (isset($this->_reflections[$class_str])) {
            return [$this->_reflections[$class_str], $this->_dependencies[$class_str]];
        }

        $dependencies = [];
        
      
        $reflection = new ReflectionClass($class_str);
      

        $constructor = $reflection->getConstructor();

        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $param) {
                if (version_compare(PHP_VERSION, '5.6.0', '>=') && $param->isVariadic()) {
                    break;
                } elseif ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                } else {
                    $c = $param->getClass();
                    $dependencies[] = Instance::of($c === null ? null : $c->getName());
                }
            }
        }
        
      
        $this->_reflections[$class_str] = $reflection;
        $this->_dependencies[$class_str] = $dependencies;
       
        

        return [$reflection, $dependencies];
    }

    /**
     * Resolves dependencies by replacing them with the actual object instances.
     * @param array $dependencies the dependencies
     * @param ReflectionClass $reflection the class reflection associated with the dependencies
     * @return array the resolved dependencies
     * @throws Exeption if a dependency cannot be resolved or if a dependency cannot be fulfilled.
     */
    protected function resolveDependencies($dependencies, $reflection = null)
    {
        foreach ($dependencies as $index => $dependency) {
            if ($dependency instanceof Instance) {
                if ($dependency->id !== null) {
                    $dependencies[$index] = $this->get($dependency);
                } elseif ($reflection !== null) {
                    $name = $reflection->getConstructor()->getParameters()[$index]->getName();
                    $class = $reflection->getName();
                    throw new \Exception("Missing required parameter \"$name\" when instantiating \"$class\".");
                }
            }
        }

        return $dependencies;
    }
    
    /**

     * function ckecks is class singleton or not
     * @param string classname
     * @return bool
     */
    private function isSingleton($classname)
    {
        return in_array($classname, $this->singletons);
    }
    
    public function registerSingletons()
    {
        $this->singletons = [
            'tm\Application',
            'tm\Router',
            'tm\Request',
            'tm\auth\StandartAuth',
            'tm\Configuration'
        ];
    }
}
