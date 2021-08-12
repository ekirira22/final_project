<?php

namespace app\core;
/* This will be the parent class for most classes*/

use app\controllers\Controller;
use app\models\UserModel;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Session $session;
    public ?DbModel $user; //User may not exist, user can be guest
    public Database $db;



    /*
     * We will create a constructor that instantiates all important classes once Application is instantiated
     */
    public function __construct(string $rootPath, array $config){

        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->session = new Session();
        $this->db = new Database($config['db']);


        /*
         * Session Implementation
         */
        $primaryValue = $this->session->get('user');
        if($primaryValue)
        {
            //Meaning user is logged in since 'user' has a value
            $primaryKey = UserModel::primaryKey();
            $this->user = UserModel::findOneRecord([$primaryKey => $primaryValue]);
            //This makes sure you can access the userObj at any point in the application
        }else{
            $this->user = null;
        }

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
    public function login(DbModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $userType = $user->userType();
        $primaryValue = $user->{$primaryKey};
        $userTypeValue = $user->{$userType};

        //set session for user

        $this->session->set('user', [$primaryKey => $primaryValue, $userType => $userTypeValue]);

        /*
         * NB: This will be only set when user is logged in, if another request is made,
         * The user will not be set and we need to read the session, get primary value, select the
         * user and specify. This will be implemented in constructor
         */

    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
        $this->response->redirect('/');
    }



}