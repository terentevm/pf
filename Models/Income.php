<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;
use tm\Model;
use Models\IncomeCollection;

class Income extends Model
{
    private $id;
    private $items = null; //collection

    public function &getItems() {
        if ($this->items === null) {
            $this->items = new IncomeCollection($this);
        }

        return $this->items;
    }
}