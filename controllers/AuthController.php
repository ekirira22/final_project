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

use app\models\DepartmentModel;
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


    /*STAFF REGISTRATION MODULE*/


    public function index()
    {
        $this->setLayout('app');
        $staff = UserModel::fetchWithRelation(['dep_id']);

       return $this->render('../app/staff/staff_view', [
            'model' => $staff
        ]);

    }

    /*
     * Registers User or Directs to register page depending on the method
     */
    public function register(Request $request)
    {
        $this->setLayout('app');

        $userModel = new UserModel();
        $departments = DepartmentModel::all();

        if($request->getMethod() === "post"):
            $userModel->loadData($request->getBody());
            /*
             * If the loaded data passes validation and registers user in db, do this
             */
            if($userModel->validate() && $userModel->register())
            {
                Application::$app->session->setFlashMessage('success', 'User registered Successfully');
                Application::$app->response->redirect('/staff');
            }

            /*
             * Else, return the user back to the /register page, with the $userModel object as params
             * In order to access the added Errors in the array and output them
             */

            return $this->render('../app/staff/staff_register', [
                'model' => $userModel,
                'departmentModel' => $departments
            ]);
        endif;

        /*
         * If neither of the above are met, it means the page is using get method, do this;
         */
        return $this->render('../app/staff/staff_register', [
            'model' => $userModel,
            'departmentModel' => $departments
        ]);
    }

    public function edit(Request $request)
    {
        $this->setLayout('app');

        /*Fetches The Staff and Departments together from the DB using INNER JOIN*/
        $staffNdepartments = UserModel::fetchByIdWithRelation($request->getReqId(), ['dep_id']);
        $departments = DepartmentModel::all();


        return $this->render('../app/staff/staff_edit', [
           'model' => $staffNdepartments,
            'departmentModel' => $departments
        ]);
    }

    public function update(Request $request)
    {
        $this->setLayout('app');
        /*Fetches The Staff data by passing the id to the findById method which is called statically via UserModel*/
        $staff = UserModel::findById($request->getReqId());

        $data = $request->getBody();

        $user = new UserModel();
        $user->loadData([
            'names' => $data['names'],
            'dep_id' => (int)$data['dep_id'],
            'id_number' => $data['id_number'],
            'mobile_no' => $data['mobile_no'],
            'email' => $data['email'],
            'password' => $staff->password,
            'confirmPassword' => $staff->password,
            'status' => $data['status'],
            'user_type' => $data['user_type']

        ]);
        if($user->update($request->getReqId()))
        {
            /*Bug located: Cannot update upon second request after validation fails */

            Application::$app->session->setFlashMessage('success', 'User successfully Updated');
            Application::$app->response->redirect('/staff');
        }

        return $this->render('../app/staff/staff_edit', [
            'model' => $staff
        ]);


    }

    public function change_password(Request $request)
    {
        $this->setLayout('app');
        $userId = $_SESSION['user']['id'];

        $user = new UserModel();
        $staff = UserModel::findById($userId);

        if($request->getMethod() === "post")
        {
            $data = $request->getBody();

            $user->loadData([
                'names' => $staff->names,
                'dep_id' => (int)$staff->dep_id,
                'id_number' => $staff->id_number,
                'mobile_no' => $staff->mobile_no,
                'email' => $staff->email,
                'password' => md5($data['password']),
                'confirmPassword' => md5($data['confirmPassword']),
                'status' => $staff->status,
                'user_type' => $staff->user_type
            ]);

            if(md5($user->password) !== md5($user->confirmPassword))
            {
                Application::$app->session->setFlashMessage('failed', 'Error!! Passwords must match');
            }

            else
            {
                $user->update($userId);
                Application::$app->session->setFlashMessage('success', 'Security Password Changed Successfully');
                Application::$app->response->redirect('/staff');
            }
            return $this->render('../app/staff/staff_change_pass', [
                'model' => $user
            ]);
        }

        return $this->render('../app/staff/staff_change_pass', [
            'model' => $user
        ]);
    }

    public function delete(Request $request)
    {
        $user = new UserModel();
        /*Deletes staff by passing the id which is gotten using the get method to the deleteById method inside DbMdel class*/
        $delete = $user->deleteById($request->getReqId());
        if($delete):
            Application::$app->session->setFlashMessage('success', 'User Deleted Successfully');
            Application::$app->response->redirect('/staff');
        endif;
        exit;
    }


    public function logout()
    {
        Application::$app->logout();
    }

}