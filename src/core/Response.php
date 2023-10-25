<?php

namespace MVC\core;

class Response
{
    public function srtStatusCode($code)
    {
        http_response_code($code);
    }

    public function redirect($url)
    {
        header('location: '.$url);
    }
}