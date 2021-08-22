<?php


namespace app\controllers;
/*
 * Class AuthController
 * This class will be used to control how the login authentication page will look like, how the
 * uers will be registered, basically any interaction that involved users, it will also act as
 * a staff  controller
 * This being a secure government system, not everyone can just register, users can only login after being
 * registered by the super administrator
 */

/*
 * Here we import all the classes that we will use in this class that do not belong
 * in the namespace app\controllers
 */

use app\core\Application;
use app\core\DbModel;
use app\core\Request;

use app\models\DepartmentModel;
use app\models\LoginModel;
use app\models\UserModel;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        /*
         * If the method return is post, do the action below, if it isn't do the other thing
         */

        //sets the layout to app through the controller, which is then passed to the router class
        $this->setLayout('auth');

        /*
         * Here we create an instance of loginModel which has validation, load and login methods
         */

        $loginModel = new LoginModel();

        /*
         * if the method of the requested page is "post" then do this, otherwise execute the rest of the code
         * where method of request is "get"
         */

        if($request->getMethod() === "post"):

            $loginModel->loadData($request->getBody());
            /*
             * If the loaded data passes validation and logs in user in DbModel class, do this
             */
            if($loginModel->validate() && $loginModel->loginUser())
            {
                /*
                 * If the above conditions are met, it means user has been found in dd and passwords
                 * have matched, loginUser will take care of storing user in session, and user is redirected
                 * below to home page
                 */

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
        //sets the layout to app through the controller, which is then passed to the router class

        $this->setLayout('app');
        /*
         * We need to view all users and what departments they belong to
         * So we call a method in the DbModel fetchWithRelation statically through UserModel class along
         * with the foreign key of the table it related to, in this case departments, and returns an ARRAY
         * of all the information
         * It is then passed to the router class as params
         */

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
        //sets the layout to app through the controller, which is then passed to the router class

        $this->setLayout('app');

        //Creates an instance of UserModel class that we will use
        $userModel = new UserModel();

//        We call the all() method inside the DbModel class statically through the DepartmentModel that
//        returns an array of all the departments
        $departments = DepartmentModel::all();

        /*
         * if the method of the requested page is "post" then do this, otherwise execute the rest of the code
         * where method of request is "get"
         */

        if($request->getMethod() === "post"):
            $userModel->loadData($request->getBody());
            /*
             * If the loaded data passes validation and registers user in db, do this
             */
            if($userModel->validate() && $userModel->register())
            {
                /*
                 * If the above conditions are met it means validation passed and register() returns true
                 * i.e user has been registers,
                 */

                /*
                 * First We log the Users' activity using the static class in DbModel before create is executed
                 */
                DbModel::logUserActivity('created a user - ' . $userModel->names);

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

    /*
     * Edits User by getting their id and finding them in the database then displaying all the data for
     * updating,
     */

    public function edit(Request $request)
    {
        //sets the layout to app through the controller, which is then passed to the router class

        $this->setLayout('app');

        /*Fetches The Staff and Departments together from the DB using  JOIN when dep_id id departments.id */

        $staffNdepartments = UserModel::fetchByIdWithRelation($request->getReqId(), ['dep_id']);

        //fetch all the departments for display
        $departments = DepartmentModel::all();

        //returns the page and passes the object (staffNdepartments) and array (departments) to the view
        return $this->render('../app/staff/staff_edit', [
           'model' => $staffNdepartments,
            'departmentModel' => $departments
        ]);
    }

    public function update(Request $request)
    {
        /*Fetches The Staff data by passing the id to the findById method which is called statically via UserModel*/
        $staff = UserModel::findById($request->getReqId());

        /* Using the $request passed above, we get the body of post data, getBody() takes care of
         * retrieving user input and we will load data where it is updated,
         * Password will be a separate function, to allow the user to change the password from old password
         */
        $data = $request->getBody();

        $user = new UserModel();

        /*
         * We load the data manually like this instead of using get body since password and confirm password
         * will be null
         */
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
        /*
         * If validate is false, out put an error and return admin to the staff view
         */
        if (!$user->validate())
        {
            Application::$app->session->setFlashMessage('failed', 'Kindly Fill all the data');
            Application::$app->response->redirect('/staff');
            exit;
        }
        /*
         * If validate passes and update passes, then get the user id by a method getReqId from a function in request
         * Then pass it to update function in DbModel, if it passes, then  display success message and redirect user
         */
        if($user->update($request->getReqId()))
        {
            /*Bug located: Cannot update upon second request after validation fails. Presumably because you cannot get
             *posted id twice after another request is made?? --
             */

            /*
             * First We log the Users' activity using the static class in DbModel if update is true
             */
            DbModel::logUserActivity('updated staff for user ' . $user->names);

            Application::$app->session->setFlashMessage('success', 'User successfully Updated');
            Application::$app->response->redirect('/staff');
        }

    }

    /*
     * Change user password
     */

    public function change_password(Request $request)
    {
        //sets the layout to app through the controller, which is then passed to the router class
        $this->setLayout('app');

        //Since this will be accessible by all individuals, we get the user id by getting
        //the id of user stored in session once they were logged in

        $userId = $_SESSION['user']['id'];

        //We create an new instance of UserModel
        $user = new UserModel();

        //We use the function findById in DbModel that returns an object of the user data for that id
        $staff = UserModel::findById($userId);

        if($request->getMethod() === "post")
        {
            /*
             * This function will take care of changing the user password by taking the old password
             * And checking it against existing password, if it passes, change password
             */
            $data = $request->getBody();

            /*
             * We load the data manually like this and return everything from the database as is
             * apart from the password
             */
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
            //If the old password does not match with the existing password, return false and give error
            if($staff->password !== md5($data['oldPassword']))
            {
                Application::$app->session->setFlashMessage('failed', 'Error: Incorrect previous password');
            }
            //Else if the new password does not match with the confirm password, return false and give error
            else if(md5($user->password) !== md5($user->confirmPassword))
            {
                Application::$app->session->setFlashMessage('failed', 'Error: New Passwords must match');
            }
            //If all the above conditions are met, then update password per the id and return a success message, redirect to home
            else
            {
                /*
                 * First We log the Users' activity using the static class if password is updated
                 */
                DbModel::logUserActivity($user->names . ' updated their password');


                $user->update($userId);
                Application::$app->session->setFlashMessage('success', 'Security Password Changed Successfully');
                Application::$app->response->redirect('/home');
            }

            //If one of the conditions above is false, then pass the user model to the params to the view
            //for the user to re-enter their data
            return $this->render('../app/staff/staff_change_pass', [
                'model' => $user
            ]);
        }

        //This executes if request method is get, renders a page passing user object to the view
        return $this->render('../app/staff/staff_change_pass', [
            'model' => $user
        ]);
    }

    /*
     * Takes care of deleting a user where id is the id passed to the get request
     */
    public function delete(Request $request)
    {
        $user = new UserModel();
        /*Deletes staff by passing the id which is gotten using the get method to the deleteById method inside DbModel class*/
        /* Gets User info where id is the id in get */

        $staff_info = UserModel::findById($request->getReqId());
        /*
         * First We log the Users' activity using the static class in DbModel before delete is executed
         */
        DbModel::logUserActivity('deleted a User - ' . $staff_info->names);

        /*Deletes staff by passing the id which is gotten using the get method to the deleteById method
        inside DbModel class*/


        $delete = $user->deleteById($request->getReqId());
        if($delete):

            /*
             * If delete has a value i.e returns true, set a success message and confirm if user is sure
             * to delete
             */
            Application::$app->session->setFlashMessage('success', 'User Deleted Successfully');
            Application::$app->response->redirect('/staff');
        endif;
        exit;
    }


    public function logout()
    {
        /*
         * Calls the logout function inside the Application class, removes user from session and redirects them to
         * Guest Page
         */
        Application::$app->logout();
    }

}