<?php


namespace app\controllers;
/*
 * Class DepartmentController
 * This class will be used to control how the Department pages will look like along
 * with the department CRUD FunctionALITY
 */
use app\core\Application;
use app\core\DbModel;
use app\core\Request;
use app\models\DepartmentModel;

class DepartmentController extends Controller
{
    /*
     * Displays departments along with the buttons for editing and deleting
     * depending on user permissions
     */
    public function index(Request $request)
    {
        //sets layout to app
        $this->setLayout('app');

        //get all departments array for display
        $departments = DepartmentModel::all();

        //we pass this model to the render function that renders the view and the passed params
        return $this->render('../app/departments/dep_view', ['model' => $departments]);

    }

    /*
     * Function that allows the admin in this case to create a department
     */

    public function create(Request $request)
    {
        //sets the layout
        $this->setLayout('app');

        $departments = new DepartmentModel();

        if($request->getMethod() === "post")
        {
            /*
             * If request made is post, take the data using getBody method and load the data
             */
            $departments->loadData($request->getBody());

            if($departments->validate() && $departments->save())
            {
                /*
                 * If validate passes and save actually saves user data i.e both return true
                 * First We log the Users' activity using the static class in DbModel
                 */
                DbModel::logUserActivity('created a new department - ' . $departments->dep_name);

                //displays success message and redirects the user to path /departments
                Application::$app->session->setFlashMessage('success', 'Department added Successfully');
                Application::$app->response->redirect('/departments');
            }

            //if method doesn't pass validate ot doesnt save, render the view with an object
            //of instantiated departments that has the errors array

            return $this->render('../app/departments/dep_create', [
                'model' => $departments
            ]);
        }

        /*
         * This is executed if request made is get
         */
        return $this->render('../app/departments/dep_create', [
            'model' => $departments
        ]);

    }

    /*
     * Public function edit gets the specific department to be edited
     */

    public function edit(Request $request)
    {
        //sets the layout
        $this->setLayout('app');

        /*Fetches The Departments data by passing the id to the findById method which is called statically via DepartmentModel*/
        $departments = DepartmentModel::findOneRecord(['id' => $request->getReqId()]);

        if($request->getMethod() === "post")
        {
            /*
             * If a post request is made, do this
             */
            $departments = new DepartmentModel();
            //get user post data from body
            //load the data through loadData methods

            $departments->loadData($request->getBody());
            if($departments->validate() && $departments->update($request->getReqId()))
            {
                /*Bug located: Cannot update upon second request after validation fails */
                /*
                 * First We log the Users' activity using the static class in DbModel
                 */
                DbModel::logUserActivity('updated a department - ' . $departments->dep_name);

                Application::$app->session->setFlashMessage('success', 'Department successfully Updated');
                Application::$app->response->redirect('/departments');
            }
            //renders this view along with the object that can access errors array and display on view

            return $this->render('../app/departments/dep_edit', [
                'model' => $departments
            ]);
        }
        /*
         * If method is get, then render the view with a list of all deparments
         */
        return $this->render('../app/departments/dep_edit', [
            'model' => $departments
        ]);
    }
    /*
     * Public function for deleting
     */

    public function delete(Request $request)
    {
        /*
         * If a delete request is made, we want to delete the department and also log the user activity
         *
         */
        $department = new DepartmentModel();
        $departmentId = $request->getReqId();

        /*
         * First We log the Users' activity using the static class in DbModel
         * We first get the name of the department being deleted, this is done before deletion
         */
        $dep_info = DepartmentModel::findById($departmentId);
        DbModel::logUserActivity('deleted a department - ' . $dep_info->dep_name);

        /*
         * We then proceed to delete the department
         */
        $delete = $department->deleteById($departmentId);
        if($delete):
            /*
             * Display success message and redirect the user to /departments
             */
            Application::$app->session->setFlashMessage('success', 'Department Deleted Successfully');
            Application::$app->response->redirect('/departments');
        endif;
        exit;
    }

}