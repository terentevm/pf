<?php

namespace tm\renderers;

use tm\ResponseData;

interface RenderInterface
{
    /**
     * build respose body
     *
     * @param mixed $vars - array or object for outputting
     *
     * @return string
     */
    public function render(ResponseData $vars) : string;
}
