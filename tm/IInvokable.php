<?php

namespace tm;

interface IInvokable
{
    public function __invoke($request, $response, $next);
}