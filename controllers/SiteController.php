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


    public function guest()
    {

        $params =[];
        return $this->render('guest', $params);
    }

    public function home()
    {

        $params =[];
        $this->setLayout('app');
        return $this->render('home', $params);
    }

    public function contact(): string
    {
        $params =[];
        return $this->render('contact', $params);
    }


}