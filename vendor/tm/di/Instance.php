<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\di;

/**
 * Description of Instance
 *
 * @author terentyev.m
 */
class Instance {
    /**
     * @var string the component ID, class name, interface name or alias name
     */
    public $id;
    
    /**
     * Constructor.
     * @param string $id the component ID
     */
    protected function __construct($id)
    {
        $this->id = $id;
    }
    
    /**
     * Creates a new Instance object.
     * @param string $id the component ID
     * @return Instance the new Instance object.
     */
    public static function of($id)
    {
        return new static($id);
    }
}
