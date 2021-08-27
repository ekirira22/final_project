<?php

namespace app\core;
/*
 * This will be the parent/base class for most classes, it will be the first class that is instantiated whenever
 * a new route is called in order to resolve and display the provided callback for that path
 */
use app\controllers\Controller;
use app\models\UserModel;
/*
 * Main class Application
 */
class Application
{
    /* Class Properties */

    public static string $ROOT_DIR;
    public static Application $app;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Session $session;
    public ?UserModel $user; //User may not exist, user can be guest
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
         * we use the get method inside the session class to get the id of user in session, we do this so that we can
         * maintain user session each time a new request is made
         */

        $primaryValue = $this->session->get('user');
        //if the user exists,
        if($primaryValue)
        {
            //Meaning user is logged in since 'user' has a value
            $primaryKey = UserModel::primaryKey();
            $this->user = UserModel::findOneRecord([$primaryKey => $primaryValue]);
            //This makes sure you can access the userObj at any point in the application
        }else{
            //else set the user to null
            $this->user = null;
        }

    }

    /*
     * This is the main function of the application class that resolves the page and executes a callback if a
     * new request ins made
     */

    public function run()
    {
        echo $this->router->resolve();
    }

    /*
     * This method is called from the LoginUser method inside the LoginModel class, we receive an object $user of type UserModel
     * DbModel can also be used since UserModel extends DbModel
     */
    public function login(UserModel $user)
    {
        //we store the object inside property $user of this class, we want to do this so that we can store the user
        //in session
        $this->user = $user;
        //we get the primaryKey from userModel which basically returns column 'id'
        $primaryKey = $user->primaryKey();
        //we get the userType from userModel which basically returns column 'userType'
        $userType = $user->userType();
        //we get the primaryValue of user.. i.e id of user by calling $user->id and store it to primaryValue
        $primaryValue = $user->{$primaryKey};
        //we get the userTypeValue of user.. i.e user_type of user by calling $user->user_type and store it to userTypeValue
        $userTypeValue = $user->{$userType};

        //we then set session for user

        $this->session->set('user', [$primaryKey => $primaryValue, $userType => $userTypeValue]);

        /*
         * NB: This will be only set when user is logged in, if another request is made,
         * The user will not be set and we need to read the session, get primary value, select the
         * user and specify. This will be implemented in constructor
         */

        /*
         * Log user activity i.e. logged in user
         */
        DbModel::logUserActivity('logged into the system');

    }

    public function logout()
    {
        /*
         * Log logged out user before session is killed
         */
        DbModel::logUserActivity('logged out of the system');

        //set property $user of this class to null
        $this->user = null;

        //we call a method remove inside session that unsets the user key inside $_SESSION
        $this->session->remove('user');

        //we then redirect the user back to home page using the redirect method inside Response class
        $this->response->redirect('/');


    }



}