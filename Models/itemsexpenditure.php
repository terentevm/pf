<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;
use tm\Model;

/**
 * Description of itemsexpenditure
 *
 * @author terentyev.m
 */
class Itemsexpenditure extends Model
{
    private $id = null;
    private $parent = null;
    private $name = '';
    private $comment = '';
    private $isNotActive = true;
    
    public function __construct($id = null, $name = '', $parent = null, $comment = '', $isNotActive = false) {
        $this->id = $id;
        $this->parent = $parent;
        $this->name = $name;
        $this->comment = $comment;
        $this->isNotActive = $isNotActive;
    }
    
    function getId() {
        return $this->id;
    }

    function getParent() {
        return $this->parent;
    }

    function getName() {
        return $this->name;
    }

    function getComment() {
        return $this->comment;
    }

    function getIsNotActive() {
        return $this->isNotActive;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setParent(Itemsexpenditure $parent) {
        $this->parent = $parent;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setComment($comment) {
        $this->comment = $comment;
    }

    function setIsNotActive($isNotActive) {
        $this->isNotActive = $isNotActive;
    }

    public static function findByParentId($parent_id, $user_id, $limit = 50, $offset = 0 ,$asArray = true) {
        $result = Mapper::getMapper(get_called_class())
            ->where(['user_id = :user_id', 'parent_id = :parent_id'])
            ->limit($limit)
            ->offset($offset)
            ->setParams(['user_id' => $user_id, 'parent_id' => $parent_id]);
            
            if ($asArray === true) {
                $result = $result->asArray();     
            }

        return $result->all();  
    }
}
