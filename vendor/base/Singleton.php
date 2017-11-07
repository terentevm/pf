<?php
namespace Base;

abstract class Singleton{
    // в $_aInstances будут хранится все
    // экзмепляры всех классов наследующих класс Singleton
    private static $_aInstances = array();
    public static function getInstance() {
     $sClassName = get_called_class(); // название класса экземпляр которого мы запросили
     if( class_exists($sClassName) ){
      if( !isset( self::$_aInstances[ $sClassName ] ) )
       // если экземпляр класса еще не был создан, создаем его
       self::$_aInstances[ $sClassName ] = new $sClassName();
      // возвращаем один экземпляр
      return self::$_aInstances[ $sClassName ];
     }
     return 0;
    }
    // более удобный вызов метода getInstance
    public static function gI() {
     return self::getInstance();
    }
    // так как нам нужен лишь один экземпляр любого класса,
    // то копировать объекты нам не потребуется
    final private function __clone(){}
    private function __construct(){}
   }