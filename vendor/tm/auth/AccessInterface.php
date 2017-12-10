<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm\auth;

/**
 *
 * @author terentyev.m
 */
interface AccessInterface {
    
    /**

     * checks access to requested url
     * @return bool
     */
    public function checkAccess();
}
