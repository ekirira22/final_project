<?php


namespace app\controllers;
/*
 * Class AuthController
 * This class will be used to control how the login authentication page will look like
 * This being a secure government system, not everyone can just register, users can only login
 */
use app\core\Application;
use app\controllers\Controller;
use app\core\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        /*
         * If the method return is post, do the thing, if it isn't do the other thing
         */
        $this->setLayout('auth');

        if($request->getMethod() === "post"):


        endif;

        return $this->render('login');


    }

}