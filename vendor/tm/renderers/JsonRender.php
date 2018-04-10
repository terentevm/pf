<?php

namespace tm\renderers;

use tm\View;
use tm\renderers\RenderInterface;

class JsonRender extends View implements RenderInterface
{
    public function render($vars) : string
    {
        $json_str =  \json_encode($vars, JSON_UNESCAPED_UNICODE);
        
        $err = "";
        switch (\json_last_error()) {
        case JSON_ERROR_NONE:
           $err = ' - Ошибок нет';
        break;
        case JSON_ERROR_DEPTH:
            $err = ' - Достигнута максимальная глубина стека';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            $err = ' - Некорректные разряды или несоответствие режимов';
        break;
        case JSON_ERROR_CTRL_CHAR:
            $err = ' - Некорректный управляющий символ';
        break;
        case JSON_ERROR_SYNTAX:
            $err = ' - Синтаксическая ошибка, некорректный JSON';
        break;
        case JSON_ERROR_UTF8:
            $err = ' - Некорректные символы UTF-8, возможно неверно закодирован';
        break;
        default:
            $err = ' - Неизвестная ошибка';
        break;
    }
    
    return $json_str;

    }
}
