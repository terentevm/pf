<?php
namespace tm;

use tm\di\Container;

class Registry
{
    private static $instance;
 
    /**
     * @var Container instance of container class.
     */
    public static $container = null;
    
    public static $app = null;

    private static $containerDI = null;

    private function __construct()
    {
        if (self::$container === null) {
            self::$container = new Container();
        }
    }

    final private function __clone()
    {
    }
    final private function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();

            return self::$instance;
        }
    }

    public function getApp()
    {
        if (is_null(self::$app)) {
            self::$app = self::CreateObject(\tm\Application::className(), []);
            return self::$app;
        } elseif (self::$app instanceof \tm\Application) {
            return self::$app;
        }
        
        throw \Exeption('Cannot initialize application');
    }

    public static function setContainerDI($container)
    {
        return self::$containerDI = $container;
    }

    public static function getContainerDI()
    {
        return self::$containerDI;
    }

    /**
     * Creates a new object using the given using giving classname and parametres
     * @var type string  class name
     * @var params array params for create new instance
     */
    public static function CreateObject($type, array $params = [])
    {
        $obj = self::$container->get($type, $params);
        return $obj;
    }
}
