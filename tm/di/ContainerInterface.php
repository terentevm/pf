<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\di;

/**
 *
 * @author terentyev.m
 */
interface ContainerInterface {
    
    public function get($name);
    public function has($name);
}
