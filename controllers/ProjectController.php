<?php


namespace app\controllers;
/*
 * Class ProjectController
 * This is the main focus of the project
 *Use imports the required classes in this controller
 */
use app\core\Application;
use app\core\DbModel;
use app\core\Request;
use app\models\DepartmentModel;
use app\models\FinancialModel;
use app\models\ProjectModel;
use app\models\SubCountyModel;
use app\models\UserModel;


class ProjectController extends Controller
{
    /*
     * Function index calls a function in DbModel fetchWithRelation() since Projects has foreign keys
     * it must join all parent tables with the subsequent foreign keys and display them
     */
    public function index()
    {
        $this->setLayout('app');
        /* Sets the rendered page layout to app*/

        $projectData = ProjectModel::fetchWithRelation(['dep_id', 'sub_id', 'year_id', 'staff_id']);
        /*We call fetchWithRelation() statically (in order to get an array) through the ProjectModel class
         * and pass the foreign keys associated with relation tables within the respective model
         * NB: (also in the order in which the relation tables are passed in the Model which is passed
         * in the view though the router
         */

        return $this->render('../app/projects/project_view', [
            'model' => $projectData
        ] );


    }

    /*
     * Function create that renders a page where the project manager can add the desired project
     * An instance of projects is made that returns the project model property, we'll use this to get user input\
     * and also validate it
     * A function all() is called statically through the SubCountyModel, DepartmentModel and FinancialModel classes
     * to get subsequent table details and post them in the select options in the form
     */

    public function create(Request $request)
    {
        $this->setLayout('app');
        /* Sets the rendered page layout to app*/
        $projects = new ProjectModel();
        $sub_counties = SubCountyModel::all();
        $departments = DepartmentModel::all();
        $f_years = FinancialModel::all();
        $staffs = UserModel::fetchWithRelationWhere(['user_type' => 'staff'], ['dep_id']);

        $projects->loadData($request->getBody());
        /* Data from the page body is taken and passed as a parameter to this loadData function that loads
         * loads the data and returns it to the $projects object
         */
        if ($request->getMethod() === "post")
        /* Checks if page method is post, if it is do this*/
        {
            if($projects->validate() && $projects->save())
            {
                /*
                 * First We log the Users' activity using the static class in DbModel
                 */
                DbModel::logUserActivity('created a new project - ' . $projects->project_name);

                /*
                 * If validate passes i.e returns true and save passes i.e also returns true
                 * set flash message to success and redirect the user to the /projects route
                 */
                Application::$app->session->setFlashMessage('success', 'Project Added Successfully');
                Application::$app->response->redirect('/projects');
            }
            /*
             * if method is post and doesn't validate, we have to show the user what went wrong,
             * so we store an instance of the projectModel which extends DbModel that extends Model which
             * has the errors, this way we can fetch the errors per the attribute and display it for the user
             * We still
             */
            return $this->render('../app/projects/project_create', [
                'projectModel' => $projects,
                'subCountyModel' => $sub_counties,
                'departmentModel' => $departments,
                'fyearModel' => $f_years,
                'staffs' => $staffs
            ]);

        }
        /* If page method is not post i.e it is get, do this*/
        /* render the page and if the page is reloaded we also pass the preloaded classes for
         *departments, subcounties and departments for post data and also to keep user data
         */
        return $this->render('../app/projects/project_create', [
            'projectModel' => $projects,
            'subCountyModel' => $sub_counties,
            'departmentModel' => $departments,
            'fyearModel' => $f_years,
            'staffs' => $staffs
        ]);

    }

    public function edit(Request $request)
    {
        $this->setLayout('app');
        /*
         * Fetch all project data array for a specific id. i.e with all the joined data for
         * subcounties, departments and fyears by statically calling the fetchByIdRelation via ProjectsModel class
         * We get the id from the URL using getReqId() from Request class that is passed to this function
         */
        $projects = ProjectModel::fetchByIdWithRelation($request->getReqId(), ['dep_id', 'sub_id', 'year_id', 'staff_id']);
        return $this->render('../app/projects/project_edit', [
            'model' => [
                'project' => $projects,
                'departments' => DepartmentModel::all(),
                'sub_counties' => SubCountyModel::all(),
                'f_years' => FinancialModel::all(),
                'staffs' => UserModel::fetchWithRelation(['dep_id'])
            ]
        ]);

    }

    public function update(Request $request)
    {
        $project = new ProjectModel();
        /*An instance of ProjetModel is made and we get the body from the Request pass that is passed to this routes's callback
         */
        $data = $request->getBody();
        /*
         * We load the data as per the user's input via function loadData in model
         */
        $project->loadData([
            'project_name' => $data['project_name'],
            'staff_id' => $data['staff_id'],
            'dep_id'  => (int)$data['dep_id'],
            'sub_id' => (int)$data['sub_id'],
            'year_id' => (int)$data['year_id'],
            'budget' => $data['budget'],
            'pr_status' => 'pending',
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'remarks' => $data['remarks'],
            'reasons' => $data['reasons']

        ]);

//        echo '<pre>';
//        var_dump($project);
//        echo '</pre>';
        //If project does not pass validate.. ie validate returns false, display an error flash message and redirect
        //user to projects page in order to fetch the id again and exit
        if(!$project->validate())
        {
            Application::$app->session->setFlashMessage('failed', 'Kindly Fill all the data accurately. Hint: Check if dates are valid');
            Application::$app->response->redirect('/projects');
            exit;
        }

        if($project->update($request->getReqId()))
        {

            /*
             * First We log the Users' activity using the static class in DbModel
             */
            DbModel::logUserActivity('updated a project - ' . $project->project_name);

            /*
             * If this function runs it means validation has passed and now we can update the project as per the id gotten from get
             * and display success message and return use back to projects page
             */
            Application::$app->session->setFlashMessage('success', 'Project successfully Updated');
            Application::$app->response->redirect('/projects');
        }

    }

    public function delete(Request $request)
    {
        $projects = new ProjectModel();
        /* Gets project info where id is the id in get */
        $project_info = ProjectModel::findById($request->getReqId());
        /*
         * First We log the Users' activity using the static class in DbModel before delete is executed
         */
        DbModel::logUserActivity('deleted a project - ' . $project_info->project_name);

        /*Deletes staff by passing the id which is gotten using the get method to the deleteById method
        inside DbModel class*/

        $delete = $projects->deleteById($request->getReqId());
        if ($delete):
            /*
             * If delete has a value i.e returns true, set a success message and confirm if user is sure
             * to delete
             */

            Application::$app->session->setFlashMessage('success', 'Project Deleted Successfully');
            Application::$app->response->redirect('/projects');
        endif;
        exit;

    }

    /* END OF MAIN CRUD FUNCTIONALITY*/

    /* PROJECT APPROVAL, TRACKING AND PROJECT COMPLETION */

    public function pending()
    {
        /*
         * This function should basically return all the PENDING AND APPROVED projects to the chief officer (CEC)
         * For either approval or denial. Approved projects
         * Once projects are approved the cannot be
         */
        $this->setLayout('app');
        $projects = ProjectModel::fetchWithRelationWhere(['pr_status' => 'pending'], ['dep_id', 'sub_id', 'year_id', 'staff_id']);


        /*
         * Renders  a view with all projects whose status is pending
         */
        return $this->render('../app/projects/project_pending', [
           'model' => $projects
        ]);
    }

    public function approved(Request $request)
    {
        //get all projects with Relation where id is the id that was posted in get body
        $id = $request->getReqId();
        $approved_pr = ProjectModel::fetchByIdWithRelation($id, ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //new instance of model to get table properties

         $data = new ProjectModel();

        //load the data and only change status to approved, the rest remain constant
        $data->loadData([
            'project_name' => $approved_pr->project_name,
            'staff_id' => $approved_pr->staff_id,
            'dep_id' => $approved_pr->dep_id,
            'sub_id' => $approved_pr->sub_id,
            'year_id' => $approved_pr->year_id,
            'budget' => $approved_pr->budget,
            'pr_status' => 'approved',
            'start_date' => $approved_pr->start_date,
            'end_date' => $approved_pr->end_date,
            'remarks' => $approved_pr->remarks,
            'reasons' => ''
        ]);

        //no need for validation since data is taken and returned to database with
        //status as approved
        $data->update($id);

        if($data->update($id))
        {
            /*
             * First We log the Users' activity using the static class in DbModel
             */
            DbModel::logUserActivity('approved a project - ' . $approved_pr->project_name);

            /*
             * If this function runs it means status was changed to approved
             */
            Application::$app->session->setFlashMessage('success', 'Project has been Approved!!');
            Application::$app->response->redirect('/projects_pending');
        }

    }

    public function delay(Request $request)
    {
        /*
         * We will basically do everything as above only with a delayed project in mind
         */
        //get all projects with Relation where id is the id that was posted in get body
        $id = $request->getReqId();
        $delayed_pr = ProjectModel::fetchByIdWithRelation($id, ['dep_id', 'sub_id', 'year_id', 'staff_id']);
        //new instance of model to get table properties

        $data = new ProjectModel();

        //load the data and only change status to approved, the rest remain constant
        $data->loadData([
            'project_name' => $delayed_pr->project_name,
            'staff_id' => $delayed_pr->staff_id,
            'dep_id' => $delayed_pr->dep_id,
            'sub_id' => $delayed_pr->sub_id,
            'year_id' => $delayed_pr->year_id,
            'budget' => $delayed_pr->budget,
            'pr_status' => 'delayed',
            'start_date' => $delayed_pr->start_date,
            'end_date' => $delayed_pr->end_date,
            'remarks' => $delayed_pr->remarks,
            'reasons' => ''
        ]);

        //no need for validation since data is taken and returned to database with
        //status as approved
        $data->update($id);

        if($data->update($id))
        {
            /*
             * First We log the Users' activity using the static class in DbModel
             */
            DbModel::logUserActivity('delayed a project - ' . $delayed_pr->project_name);

            /*
             * If this function runs it means status was changed to approved
             */
            Application::$app->session->setFlashMessage('failed', 'Project has been Delayed!!');
            Application::$app->response->redirect('/projects_pending');
        }

    }
}