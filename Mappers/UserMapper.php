<?php

namespace mappers;
use tm\Mapper;

class UserMapper extends Mapper
{
    public static $db_columnes = ['id', 'login', 'password','name'];

    public static function setTable() {
        return "users";
    }


}