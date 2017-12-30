<?php

namespace tm\renderer;

use tm\View;
use tm\renderers\RenderInterface;

class JsonRender extends View implements RenderInterface
{

    public function render($vars) : string {
        return \json_encode($vars, JSON_UNESCAPED_UNICODE);
    }
}