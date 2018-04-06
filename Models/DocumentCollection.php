<?php

namespace Models;
use tm\Model;
use tm\CollectionAbstract;

class DocumentCollection extends CollectionAbstract
{
    public function __construct(Model $owner) {
    
        $this->storage = [];
    }
}