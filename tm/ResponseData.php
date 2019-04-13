<?php

namespace tm;

class ResponseData
{
    public $success;
    public $data = null;
    public $msg = "";

    public function __construct(bool $success, $data = null, string $msg ="")
    {
        $this->success = $success;
        $this->data = $data;
        $this->msg = $msg;
    }
}
