<?php

namespace tm;

interface IReport
{
    public function setParam(string $paramName);
    
    public function execute() : array;
    
}