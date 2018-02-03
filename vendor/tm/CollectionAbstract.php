<?php

namespace tm;

use tm\Model;
use tm\Base;
use tm\CollectionsInterface;

abstract class CollectionAbstract implements CollectionsInterface
{
    /**
     * @var array storage will store collection rows
     */
    protected $storage = null;

    protected $owner = null; //model instance
    

    public function add($row) {
        
        $this->storage[] = $row;
    }

    public function &get(int $index) {
        if (array_key_exists($index, $this->storage)) {
            return $this->storage[$index];
   
        }

        return null;
    }

    public function delete(int $index) {
        if (array_key_exists($index, $this->storage)) {
            unset($this->storage[$index]);
            return true;
        }
        return false;
    }

    public function strings() {
        foreach ($this->storage as &$str) {
            yield $str;
        }
    }
}