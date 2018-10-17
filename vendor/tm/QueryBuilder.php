<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tm;

use tm\Model;

/**
 * Description of QueryBuilder
 *
 * @author terentyev.m
 */
class QueryBuilder
{
    private $mapper = null;
    
    public function build(Mapper $mapperInstance)
    {
        $this->mapper = $mapperInstance;
        
        $query_parts = [
            $this->buildSelect(),
            $this->buildFrom(),
            $this->buildWhere(),
            $this->buildOrderBy(),
            $this->buildLimit(),
            $this->buildOffset()
        ];

        $sql = trim(implode(' ', $query_parts));

        return array($sql, $this->mapper->params);
    }

    public function buildSelect()
    {
        if (property_exists($this->mapper, 'db_columnes')) {
            $fields = implode(',', $this->mapper::$db_columnes);
        } else {
            $fields = '*';
        }

        return 'SELECT ' . $fields;
    }

    public function buildInsert(Mapper $mapperInstance)
    {
        $fields = '(' . implode(',', $mapperInstance::$db_columnes) . ')';
        $params = '(' . $this->performColumnesToParams($mapperInstance::$db_columnes) . ')';
        
        $sql = 'INSERT INTO ' . $mapperInstance::setTable() . ' ' . $fields . ' VALUES ' . $params;

        return $sql;
    }

    public function buildUpdate(Mapper $mapperInstance, $colsForUpdate)
    {
        $this->mapper = $mapperInstance;
        
        $keys_arr = array_keys($colsForUpdate);
        $colNames = '(' . implode(',', $keys_arr) . ')';
        $colValues = '(' . implode(',', array_values($colsForUpdate)) . ')';

        $params = ' ' . $this->performColumnesToUpdate($keys_arr) . ' ';
       
        $sql = 'UPDATE ' . $mapperInstance::setTable() . ' SET ' .  $params . $this->buildWhere();

        return $sql;
    }

    public function buildDelete(Mapper $mapperInstance)
    {
        $this->mapper = $mapperInstance;
        $sql = 'DELETE FROM ' . $mapperInstance::setTable() . $this->buildWhere();

        return $sql;
    }

    public function buildFrom()
    {
        if (!method_exists($this->mapper, 'setTable')) {
            $className = get_class($this->mapper);
            throw new \Exception("Table name define method hasn't defined in class {$className}");
        }

        return 'FROM ' . $this->mapper::setTable();
    }

    public function buildWhere()
    {
        if ($this->mapper->where !== null) {
            return " WHERE " . $this->buildCondition($this->mapper->where);
        }
        
        return '';
    }

    public function buildOrderBy()
    {
        if (empty($this->mapper->orderBy)) {
            return '';
        }

        return ' ORDER BY ' . \implode(',', $this->mapper->orderBy);
    }

    public function buildCondition($condition)
    {
        if (isset($condition[0])) {
            $operator = strtoupper($condition[0]);

            if ($operator == 'AND' || $operator == 'OR') {
                array_shift($condition);
                return $this->buildAndCondition($operator, $condition);
            } else {
                $str_cond = \implode(' AND ', $condition);
                return $str_cond;
            }
        }
    }

    public function buildAndCondition($operator, $operands)
    {
        $parts = [];
        foreach ($operands as $operand) {
            if (is_array($operand)) {
                $operand = $this->buildCondition($operand);
            }

            if ($operand !== '') {
                $parts[] = $operand;
            }
        }
        if (!empty($parts)) {
            return '(' . implode(") $operator (", $parts) . ')';
        }

        return '';
    }

    public function buildLimit()
    {
        if ($this->mapper->limit !== null) {
            return ' LIMIT ' . $this->mapper->limit;
        }

        return '';
    }

    public function buildOffset()
    {
        if ($this->mapper->offset !== null) {
            return ' OFFSET ' . $this->mapper->offset;
        }

        return '';
    }
    


    protected function performColumnesToParams($columnes)
    {
        foreach ($columnes as &$col) {
            $col = ':' . $col;
        }

        return implode(',', $columnes);
    }
    
    protected function performColumnesToUpdate($columnes)
    {
        $res_arr = [];
        
        foreach ($columnes as $col) {
            $res_arr[] = "${col} = :${col}";
        }
        
        return implode(",", $res_arr);
    }
    
    

}
