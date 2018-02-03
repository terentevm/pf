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
class ItemsExpenditure extends Model
{
    private $id = null;
    private $name = '';
    private $notActive = 0;
    private $comment = '';
    private $user_id = null;
    private $parentId = null;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getNotActive() {
        return $this->notActive;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getParentId() {
        return $this->parentId;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setNotActive($notActive) {
        $this->notActive = $notActive;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function setParentId($parentId) {
        if (!empty($parentId)  && !is_null($parentId)) {
            $this->parentId = $parentId;    
        }
        
    }


    public static function findByParentId($parentId, $user_id, $limit = 50, $offset = 0 ,$asArray = true) {
        $result = Mapper::getMapper(get_called_class())
            ->where(['user_id = :user_id', 'parent_id = :parent_id'])
            ->limit($limit)
            ->offset($offset)
            ->setParams(['user_id' => $user_id, 'parent_id' => $parentId]);
            
            if ($asArray === true) {
                $result = $result->asArray();     
            }

        return $result->all();  
    }
}
