<?php

namespace tm;

use tm\database\AbstractDb;

abstract class Model extends Base
{
    /**
     * Creates class mapper instanse usig model class name
     *
     * @return Mapper instance
     */
    public static function find()
    {
        return Mapper::getMapper(get_called_class());
    }

    /**
     * Return data (array or model instance) selected by user id from DB.
     *
     * @param string $user_id User id in UUID format
     * @param int $limit Number of records selected from the database
     * @param int $offset
     * @param bool $asArray If true return array, else model instance
     *
     * @return mixed Array or model instance
     */
    public static function findByUser(string $user_id, int $limit = 50, int $offset = 0, bool $asArray = true)
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
        $success = Mapper::getMapper(get_called_class())->save($this);

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
            ->update($this, $colsForUpdate);
                    
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

    public function loadSafe(array $attributes)
    {
        $filters = get_called_class()::getFilterRules();
        $sanitizedData = filter_var_array($attributes, $filters);
        foreach ($sanitizedData as $attrName => $attrValue) {
            $setter = 'set' . ucfirst($attrName);
            if (method_exists($this, $setter)) {
                $this->$attrName = $attrValue;
            }
        }
    }
}
