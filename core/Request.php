<?php

namespace app\core;

/* This will be the class that returns super global server results
* This had to be a separate class for re-usability
*/
class Request
{
    public function getPath()
    {
        return $_SERVER['PATH_INFO'] ?? '/';

    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);

    }

    public function getBody()
    {
        $body = [];
        if($this->getMethod() === "get"):
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        endif;

        if($this->getMethod() === "post"):
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        endif;


        return $body;
    }


}