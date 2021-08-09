<?php

/*
 * This class sets the status code of an unrouted page to 404 instead of the usual
 * 200 which stand for OK
 */
namespace app\core;


class Response
{
    public int $code;
    public function setStatusCode(int $code){
        $this->code = $code;
        http_response_code($code);
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function redirect(string $path)
    {
        header('Location: ' . $path);
    }

}