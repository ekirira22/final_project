<?php

namespace app\core;
/* This will be the parent class for most classes*/

use app\controllers\Controller;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;


    /*
     * We will create a constructor that instantiates all important classes once Application is instantiated
     */
    public function __construct($rootPath){

        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->request);

    }

    public function run()
    {
        echo $this->router->resolve();
    }

//    /**
//     * @return Controller
//     */
//    public function getController(): Controller
//    {
//        return $this->controller;
//    }
//
//    /**
//     * @param Controller $controller
//     */
//    public function setController(Controller $controller): void
//    {
//        $this->controller = $controller;
//    }

}