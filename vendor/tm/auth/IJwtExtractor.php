<?php

namespace tm\auth;

use Slim\Http\Request;

interface IJwtExtractor
{
    /**
     * Extracts JWT key from source(header or cookie)
     * Функция извлекает jwt токен из заголовков запроса или из кук
     * @param $req Slim\Http\Request
     * 
     * @return string||null 
     */
    public function extractJWT(Request $req);
}