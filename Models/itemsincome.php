<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;

use tm\Model;

/**
 * Description of itemsincome
 *
 * @author terentyev.m
 */
class Itemsincome extends Model
{
 
    private $id = null;
    private $name = '';
    private $notActive = 0;
    private $comment = '';
    private $user = null;
    private $parent = null;
}
