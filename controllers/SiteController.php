<?php

namespace app\controllers;
/*
 * Class SiteController
 * This class will be extended to by other controllers, it will basically determine what
 * views should be rendered to user
 */
use app\core\Application;
use app\controllers\Controller;
use app\core\Request;

class SiteController extends Controller
{

    public function home()
    {

        return $this->render('home');
    }
    public function contact(): string
    {

        return $this->render('contact');
    }

    public function invalid(){

    }


}