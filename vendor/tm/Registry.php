<?php
namespace tm;

use tm\di\Container;

class Registry
{
    private static $instance;

    /**
     * @var Container instance of container class.
     */
    private static $container = null;
    
    public $app;

    private function __construct() {
        if (self::$container === null) {
            self::$container = new Container();
        }
    }

    final private function __clone(){}
    final private function __wakeup(){}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();

            return self::$instance;
        }
    }

    public function getApp($param) {

    }

    /**
     * Creates a new object using the given using giving classname and parametres
     * @var type string  class name 
     * @var params array params for create new instance
     */
    public static function CreateObject($type, array $params = []) {
        $obj = self::$container->get($type, $params);
    }
}