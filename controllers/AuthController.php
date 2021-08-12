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

use app\models\LoginModel;
use app\models\UserModel;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        /*
         * If the method return is post, do the thing, if it isn't do the other thing
         */
        $this->setLayout('auth');

        /*
         * Here we create an instance of loginModel which has validation, load ang login methods
         */
        $loginModel = new LoginModel();

        if($request->getMethod() === "post"):

            $loginModel->loadData($request->getBody());
            /*
             * If the loaded data passes validation and logs in user in db, do this
             */
            if($loginModel->validate() && $loginModel->loginUser())
            {

                Application::$app->response->redirect('/home');
                return;
            }
            /*
             * Else, return the user back to the /login page, with the $loginModel object as params
             * In order to access the added Errors in the array and output them
             */
            return $this->render('login', [
                'model' => $loginModel
            ]);
        endif;
        /*
         * If neither of the above are met, it means the page is using get method, do this;
         */
        return $this->render('login', [
            'model' => $loginModel
        ]);


    }

    /*
     * Registers User or Directs to register page depending on the method
     */
    public function register(Request $request)
    {
        $this->setLayout('app');

        $userModel = new UserModel();

        if($request->getMethod() === "post"):
            $userModel->loadData($request->getBody());
            /*
             * If the loaded data passes validation and registers user in db, do this
             */
            if($userModel->validate() && $userModel->register())
            {
                Application::$app->session->setFlashMessage('success', 'User registered Successfully');
                Application::$app->response->redirect('/register');
            }

            /*
             * Else, return the user back to the /register page, with the $userModel object as params
             * In order to access the added Errors in the array and output them
             */

            return $this->render('../app/staff/register_staff', [
                'model' => $userModel
            ]);
        endif;

        /*
         * If neither of the above are met, it means the page is using get method, do this;
         */
        return $this->render('../app/staff/register_staff', [
            'model' => $userModel
        ]);
    }

    public function logout()
    {
        Application::$app->logout();
    }

}