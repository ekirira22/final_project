<?php


namespace app\controllers;
/*
 * Class FinancialYearController
 * This class will be used to control how the Financial Year pages will look like along
 * with the department CRUD FunctionALITY
 */

use app\core\Application;
use app\core\DbModel;
use app\core\Request;
use app\models\FinancialModel;

class FinancialYearController extends Controller
{
    /*
     * Displays financial years along with the buttons for editing and deleting
     * depending on user permissions
     */
    public function index()
    {
         //sets layout to app
        $this->setLayout('app');
        //get all fyears array for display
        $f_years = FinancialModel::all();

        //we pass this model to the render function that renders the view and the passed params
        return $this->render('../app/financial_years/fy_view', [
           'model' => $f_years
        ]);
    }

    /*
     * Public function create that basically created a new financial year
     */

    public function create(Request $request)
    {
        //sets the layout
        $this->setLayout('app');

        $f_years = new FinancialModel();

        if($request->getMethod() === "post")
        {
            /*
             * If request made is post, take the data using getBody method and load the data
             */
            $f_years->loadData($request->getBody());
            if($f_years->validate() && $f_years->save())
            {
                /*
                 * If validate passes and save actually saves user data i.e both return true
                 * First We log the Users' activity using the static class in DbModel
                 */
                DbModel::logUserActivity('created a new financial year - ' . $f_years->year_name);

                Application::$app->session->setFlashMessage('success', 'Financial Year created Successfully');
                Application::$app->response->redirect('/financial_years');
            }

            //if method doesn't pass validate or doesnt save, render the view with an object
            //of instantiated financial years that has the errors array
            return $this->render('../app/financial_years/fy_create', [
                'model' => $f_years
            ]);
        }
        /*
         * This is executed if request made is get
         */
        return $this->render('../app/financial_years/fy_create', [
            'model' => $f_years
        ]);
    }

    /*
     * Public function edit that gets page as per the id posted
     */

    public function edit(Request $request)
    {
        //sets the layout
        $this->setLayout('app');
        //fetches all financial years where the id is the id getted
        $f_years = FinancialModel::findById($request->getReqId());

        //renders the view along the object of fetched information
        return $this->render('../app/financial_years/fy_edit', [
            'model' => $f_years
        ]);
    }

    /*
     * Public function update that basically updates the financial years
     */

    public function update(Request $request)
    {
        //sets the layout
        $this->setLayout('app');
        $f_year = new FinancialModel();

        //loads data
        $f_year->loadData($request->getBody());

        if($f_year->validate() && $f_year->update($request->getReqId()))
        {
            /*
             * If validate passes and save actually saves user data i.e both return true
             * First We log the Users' activity using the static class in DbModel
             */


            DbModel::logUserActivity('updated the financial year of - ' . $f_year->year_name);
            //display success message in session

            Application::$app->session->setFlashMessage('success', 'Financial Year updated Successfully');
            Application::$app->response->redirect('/financial_years');
        }
        /*
         * This is executed if request made is get
         */

        return $this->render('../app/financial_years/fy_edit', [
            'model' => $f_year
        ]);
    }

    public function delete(Request $request)
    {
        $f_year = new FinancialModel();
        /*Deletes Financial Year by passing the id which is gotten using the get method to the deleteById method inside DbModel class*/

        /*
         * First We log the Users' activity using the static class in DbModel before delete is executed
         * We get the year name being deleted
         */
        $f_year_info = FinancialModel::findById($request->getReqId());
        DbModel::logUserActivity('deleted a financial year - ' . $f_year_info->year_name);

        $delete = $f_year->deleteById($request->getReqId());

        if($delete)
        {
            /*
             * If the fyear is deleted, display success message and redirect user
             */
            Application::$app->session->setFlashMessage('success', 'Financial Year deleted Successfully');
            Application::$app->response->redirect('/financial_years');
            exit;

        }
    }


}