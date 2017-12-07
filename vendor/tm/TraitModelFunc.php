<?php

namespace tm;

trait TraitModelFunc
{
    /**
     * function set - set private object property
     * @$prop_name string - property name
     * @$prop_value - property value
     * @author terentyev.m
     */


    public function set($prop_name, $prop_value) {
        if (property_exists($this, $prop_name)) {
			$this->$prop_name = $prop_value;
		}
    }

    /**
     * function set - set private object property
     * @$prop_name - property name
     * return peroperty value, if property doesn't extists then return null
     * @author terentyev.m
     */
    public function get($prop_name) {
        if (property_exists($this, $prop_name)) {
			return $this->$prop_name;
        }
        
        return null;
    }

    public function getMapping() {
        
        if (isset($this->mapping)){
            return $mapping;
        }
        
        return [];
    }

    
}