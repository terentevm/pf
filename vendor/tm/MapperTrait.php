<?php

namespace tm;

trait MapperTrait
{
    public $with = [];

    public $limit;

    public $offset;

    public $where;
   
    public $asArray = false;

    public $params;

    public function where(array $condition) {
        $this->where = $condition;
        return $this;
    }

    public function andWhere($condition)
    {
        if ($this->where === null) {
            $this->where = $condition;
        } else {
            $this->where = ['and', $this->where, $condition];
        }

        return $this;
    }

    public function orWhere($condition)
    {
        if ($this->where === null) {
            $this->where = $condition;
        } else {
            $this->where = ['or', $this->where, $condition];
        }

        return $this;
    }

    public function with() {
        $args = func_get_args();

        if (isset($args[0]) && is_array($args[0])) {
            $args = $args[0]; //Параметр передан как массив
        }

        if (empty($this->with)) {
            $this->with = $args;
        } elseif (!empty($args)) {
            foreach ($args as $name => $value) {
                if (is_int($name)) {
                    
                    $this->with[] = $value;
                } else {
                    $this->with[$name] = $value;
                }
            }
        }

        return $this;
    } 

    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset) {
        $this->offset  =$offset;
        return $this;
    }

    public function asArray() {
        $this->asArray = true;
        return $this;
    }

    public function setParams(array $params) {
        $this->params = $params;
        return $this;
    }

}