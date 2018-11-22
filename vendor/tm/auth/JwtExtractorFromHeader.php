<?php

namespace tm\auth;

use tm\auth\IJwtExtractor;
use Slim\Http\Request;

class JwtExtractorFromHeader implements IJwtExtractor
{
    public function extractJWT(Request $req)
    {
        $authHeader = $req->getHeader('HTTP_AUTHORIZATION');

        if (empty($authHeader)) {
            return null;
        }
        
        $headerValue = $authHeader[0];

        if (empty($headerValue)) {
            return null;
        }

        list($type, $jwt) = explode(" ", $headerValue);

        if ((strcasecmp($type, "Bearer") == 0)) {
            
            return empty($jwt) ? null : $jwt;
                 
        }

        return null;
    }   
}