<?php

namespace tm\renderers;

interface RenderInterface
{
    /**
     * build respose body
     *
     * @param mixed $vars - array or object for outputting
     *
     * @return string
     */
    public function render($vars) : string;
}
