<?php

/*
 * Public calss Response that is used for page responses
 */
namespace app\core;


class Response
{
    public int $code;
    /*
     * This class sets the status code of an unrouted page to 404 instead of the usual
     * 200 which stand for OK
     */
    public function setStatusCode(int $code){
        $this->code = $code;
        http_response_code($code);
    }

    /*
     * This gets the page status code for input
     */

    public function getStatusCode(): int
    {
        return $this->code;
    }

    /*
     * Public function redirect that will be used over the application to
     * redirec the user to a certain path
     */
    public function redirect(string $path)
    {
        header('Location: ' . $path);
    }

}