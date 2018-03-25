<?php

namespace tm;

use tm\database\AbstractDb;
use tm\Mapper;
use tm\Base;

abstract class Model extends Base
{
    public static function find()
    {
        return Mapper::getMapper(get_called_class());
    }

    public static function findByUser($user_id, $limit = 50, $offset = 0, $asArray = true)
    {
        $result = Mapper::getMapper(get_called_class())
            ->where(['user_id = :user_id'])
            ->limit($limit)
            ->offset($offset)
            ->setParams(['user_id' => $user_id]);
            
        if ($asArray === true) {
            $result = $result->asArray();
        }

        return $result->all();
    }

    public static function findById($id, $asArray = true)
    {
        $result = Mapper::getMapper(get_called_class())
            ->where(['id = :id'])
            ->setParams(['id' => $id]);
        if ($asArray === true) {
            $result = $result->asArray();
        }
        
        $result = $result->one();
            
        return $result;
    }
    
    public function save($upload_mode = false)
    {
        $success = Mapper::getMapper(get_called_class())->save($this, $upload_mode, true);
        return  $success ;
    }

    public function update()
    {
        if ($this->id === null) {
            return false;
        }

        $mapper = Mapper::getMapper(get_called_class());

        $colsForUpdate = $mapper->mapModelToDb($this);

        $success = $mapper->where(['id = :id'])
            ->setParams(['id' => $this->id])
            ->update($colsForUpdate);
                    
        return $success;
    }

    public function delete()
    {
        $mapper = Mapper::getMapper(get_called_class());
        $success = $mapper->delete($this);
        return  $success ;
    }

    public function load(array $attributes)
    {
        foreach ($attributes as $attrName => $attrValue) {
            $setter = 'set' . ucfirst($attrName);
            if (method_exists($this, $setter)) {
                $this->$attrName = $attrValue;
            }
        }
    }
}
