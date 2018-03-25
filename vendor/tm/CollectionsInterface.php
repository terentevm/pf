<?php

namespace tm;

interface CollectionsInterface
{

    /**
     * add new row to collection
     * @param mixed row
     */
    public function add($row);
    
    /**
     * return array row by index
     * @param int index
     * @return mixed row (array) if key exists or null if not.
     */
    public function get(int $index);

    /**
     * delete row from collection
     * @param array row
     */
    public function delete(int $index);

    /**
     * function generator for loop collection
     */
    public function strings();
}
