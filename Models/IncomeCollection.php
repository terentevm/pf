<?php

namespace Models;
use tm\Model;
use tm\CollectionAbstract;

class IncomeCollection extends CollectionAbstract
{
    public function __construct(Model $owner) {
        $this->owner = $owner;
        $this->storage = [];
    }
}