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
use app\models\ActivityModel;
use app\models\ProjectModel;
use app\models\UserModel;

class SiteController extends Controller
{

    /*
     * This is the landing page where every user lands upon opening the nyeri county pms
     */

    public function guest(Request $request)
    {
        /*
         * We want to fetch all the projects irregardless, so we fetchWithRelation joining all the tables related
         * to the projects table
         *
         * Refactored code to accommodate search, noted a neat php trick, when a user searches for nothing it returns
         * everything, so we will use this to our advantage
         */

        $projects = ProjectModel::fetchWithRelation(['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //If a user searches for something, we get it from the URL using method is request class called getSearchVal()
        //that gets the posted value
        $search = $request->getSearchVal();

        //we then pass the posted value to function fetchBySearchWithRelation in DbModel that accepts three parameters
        //i.e the searchValue, column tables we want to search from and the foreign keys for joining the tables

        $results = ProjectModel::fetchBySearchWithRelation($search,['project_name', 'dep_name', 'sub_name'], ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //var_dump($results);

        //sets the layout
        $this->setLayout('main');


        //renders the view of home passing the parameters for projects, we will set the page in such a way that if the
        //user doesn't search for anything, i.e the search value is false, we will used the passed $projects instead
        return $this->render('home', [
            'model' => $projects,
            'search' => [
                'value' => $search,
                'results' => $results
            ],
            'counters' => [
                'completed' => ProjectModel::findAllWhere(['pr_status' => 'complete']),
                'approved' => ProjectModel::findAllWhere(['pr_status' => 'approved']),
                'pending' => ProjectModel::findAllWhere(['pr_status' => 'pending']),
                'ongoing' => ProjectModel::findAllWhere(['pr_status' => 'ongoing']),
                'delayed' => ProjectModel::findAllWhere(['pr_status' => 'delayed'])

            ]
        ]);
    }

    public function home(Request $request)
    {
        /*
         * This is the same as the landing page, the only difference is that is for the county staff who have credentials
         * to the system because of the navigation layout 'app' which has all the managerial options
         */

        $projects = ProjectModel::fetchWithRelation(['dep_id', 'sub_id', 'year_id', 'staff_id']);

        /*
         * The search and the project options also work the same as the function guest above
         */
        $search = $request->getSearchVal();

        $results = ProjectModel::fetchBySearchWithRelation($search,['project_name', 'dep_name', 'sub_name'], ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //var_dump($results);

        $this->setLayout('app');

        /*
         * Renders the view for county staff to see
         */
        return $this->render('home', [
            'model' => $projects,
            'search' => [
                'value' => $search,
                'results' => $results
            ],
            'counters' => [
                'completed' => ProjectModel::findAllWhere(['pr_status' => 'complete']),
                'approved' => ProjectModel::findAllWhere(['pr_status' => 'approved']),
                'pending' => ProjectModel::findAllWhere(['pr_status' => 'pending']),
                'ongoing' => ProjectModel::findAllWhere(['pr_status' => 'ongoing']),
                'delayed' => ProjectModel::findAllWhere(['pr_status' => 'delayed'])

            ]
        ]);
    }
    /*
     * This public function log will be for the admin, it will use the user_activity model class
     * to render the users' activity for the admin to see what the users have been up to
     */
    public function activity(Request $request)
    {
        /*
         * When a get request is made on this page, we want to fetch all the user's activity with the latest
         * activity being the latest activity to be posted
         */
        //set the layout
        $this->setLayout('app');

        /*
         * We call all statically through the ActivityModel that returns the tableName and attributes
         * to be used to fetch data from the database
         */
        $activity = ActivityModel::fetchWithRelation(['staff_id', 'dep_id']);
        //fetch all staffs
        $staffs = UserModel::all();

        //In case admin filters user activity by date, we want to get straight from database and display in view
        //We first get the dates

        //I have manually entered the date to get an obvious start date
        $from_date = $request->getFilteredValue('from_date') ?? '2021-08-01';
        $to_date = $request->getFilteredValue('to_date') ?? date('Y-m-d');

        //here if we get the page (since method is get) it gives an error since by default there is no value
        //so i passed staff_id column if $user is not found to return all users

        $user = $request->getFilteredValue('staff_id') ?? 'staff_id';

//        var_dump($user);

         $filtered_activity = ActivityModel::fetchByFilterWithRelation($from_date, $to_date, ['staff_id' => $user], ['staff_id', 'dep_id']);

        //We then pass this to the render along with the view to render the view to admin

        return $this->render('activity', [
            'model' => $activity,
            'staffs' => $staffs,
            'filtered' => [
                'values' => [$from_date, $to_date],
                'results' => $filtered_activity
            ]
        ]);
    }

    /*
     * Function  that will filter reports
     */

    public function reports(Request $request)
    {
        /*
         * Here, we want to also make reports and
         */

        /*
         * When a get request is made on this page, we want to fetch all the reports
         */
        //set the layout
        $this->setLayout('app');
        //In case whomever filters user activity by date, we want to get straight from database and display in view
        //We first get the dates

        //I have manually entered the date to get an obvious start date like above

        $from_date = $request->getFilteredValue('from_date') ?? '2021-08-01';
        $to_date = $request->getFilteredValue('to_date') ?? date('Y-m-d');

        //we get the status we shall filter with
        $status = $request->getFilteredValue('pr_status') ?? 'pr_status';

        $filtered_reports = ProjectModel::fetchByFilterWithRelation($from_date, $to_date, ['pr_status' => $status], ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //We then pass this to the render along with the view to render the view to admin

            return $this->render('reports', [
                'filtered' => [
                    'values' => [$from_date, $to_date],
                    'results' => $filtered_reports
                ]
            ]);

    }


}