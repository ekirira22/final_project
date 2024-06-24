<?php


namespace app\controllers;
/*
 * Class SubCountyController
 * This class will be used to control how the sub county pages will look like along
 * with the sub CRUD FunctionALITY
 */

use app\core\Application;
use app\core\DbModel;
use app\core\Request;
use app\models\SubCountyModel;

class SubCountyController extends Controller
{
    /*
     * Displays sub counties along with the buttons for editing and deleting
     * depending on user permissions
     */
    public function index()
    {
        //sets layout to app
        $this->setLayout('app');
        //get all sub counties array for display
        $sub_counties = SubCountyModel::all();

        //we pass this model to the render function that renders the view and the passed params
        return $this->render('../app/sub_counties/sub_view', [
            'model' => $sub_counties
        ]);
    }
    /*
    * Function that allows the admin in this case to create a sub county
    */

    public function create(Request $request)
    {
        //sets layout to app
        
        $this->setLayout('app');
        $sub_counties = new SubCountyModel();

        if($request->getMethod() === "post")
        {
            /*
             * If request made is post, take the data using getBody method and load the data
             */
            $sub_counties->loadData($request->getBody());
            if($sub_counties->validate() && $sub_counties->save())
            {
                /*
                 * If validate passes and save actually saves user data i.e both return true
                 * First We log the Users' activity using the static class in DbModel
                 */
                DbModel::logUserActivity('created a new sub-county - ' . $sub_counties->sub_name);

                //set success message
                Application::$app->session->setFlashMessage('success', 'Sub county created Successfully');
                Application::$app->response->redirect('/sub_counties');
            }
            //if method doesn't pass validate ot doesnt save, render the view with an object
            //of instantiated subcountys that has the errors array
            
            return $this->render('../app/sub_counties/sub_create', [
                'model' => $sub_counties
            ]);
        }
        /*
         * This is executed if request made is get
         */

        return $this->render('../app/sub_counties/sub_create', [
            'model' => $sub_counties
        ]);
    }

    /*
     * Public function edit gets the specific subcounty to be edited
     */

    public function edit(Request $request)
    {
        //sets the layout
        $this->setLayout('app');

        /*Fetches The subcountys data by passing the id to the findById method which is called statically via subcountyModel*/
        $sub_counties = SubCountyModel::findById($request->getReqId());

        //renders the view along with the passed params
        return $this->render('../app/sub_counties/sub_edit', [
            'model' => $sub_counties
        ]);
    }

    public function update(Request $request)
    {
        //sets a layout
        /*
         * If a post request is made, do this
         */
        $this->setLayout('app');
        $sub_county = new SubCountyModel();
        //get user post data from body
        //load the data through loadData methods
        
        $sub_county->loadData($request->getBody());

        if($sub_county->validate() && $sub_county->update($request->getReqId()))
        {
            /*
             * If Update First We log the Users' activity using the static class in DbModel
             */
            DbModel::logUserActivity('updated a sub-county - ' . $sub_county->sub_name);
            
            Application::$app->session->setFlashMessage('success', 'Sub County updated Successfully');
            Application::$app->response->redirect('/sub_counties');
        }

        //renders this view along with the object that can access errors array and display on view if method is get
        return $this->render('../app/sub_counties/sub_edit', [
            'model' => $sub_county
        ]);
    }

    /*
     * Public function for deleting 
     */

    public function delete(Request $request)
    {
        /*
         * If a delete request is made, we want to delete the subcounty and also log the user activity
         *
         */
        
        $sub_county = new SubCountyModel();
        $sub_id = $request->getReqId();
        /*Deletes Financial Year by passing the id which is gotten using the get method to the deleteById method inside DbModel class*/
        /*
         * First We log the Users' activity using the static class in DbModel
         * We first get the name of the subcounty being deleted, this is done before deletion
         */
        $sub_info = SubCountyModel::findById($sub_id);
        
        DbModel::logUserActivity('deleted a sub-county - ' . $sub_info->sub_name);

        /*
         * We then proceed to delete the subcounty
         */
        $delete = $sub_county->deleteById($request->getReqId());

        if($delete)
        {
            /*
             * If delete passes, let us show the success message then redirect the user
             */
            Application::$app->session->setFlashMessage('success', 'Sub county deleted Successfully');
            Application::$app->response->redirect('/sub_counties');
            exit;

        }
    }
}