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
use app\models\TaskModel;
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

        /*
         * Renders the edit page with the view and the parameters i.e the data of all the tables
         * that are related to the projects table in the database
         */
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

            /*If project updates i.e returns true
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

        /*Deletes project by passing the id which is gotten using the get method to the deleteById method
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

    /*
     * FUNCTIONALITY FOR CEC
     */
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

    /*
     * FUNCTIONALITY FOR PROJECT MANAGER AND STAFF (PROJECT HANDLER)
     */

    public function projects_start(Request $request)
    {
        //This is where project execution will take place depending on whether the user is pm or staff
        //We want to fetch all projects where status is approved and display them for project manager to start

        //set layout
        $this->setLayout('app');
        //fetch all projects where status is approved for the pm to view and start the project and displays them
        $ongoingProjects = ProjectModel::fetchWithRelationWhere(['pr_status' => 'approved'], ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //if an id exists in the get request, do this
        if($request->getReqId())
        {
            $id = $request->getReqId();
            $ongoing_pr = ProjectModel::fetchByIdWithRelation($id, ['dep_id', 'sub_id', 'year_id', 'staff_id']);
            //new instance of model to get table properties

            $data = new ProjectModel();

            //load the data and only change status to approved, the rest remain constant
            $data->loadData([
                'project_name' => $ongoing_pr->project_name,
                'staff_id' => $ongoing_pr->staff_id,
                'dep_id' => $ongoing_pr->dep_id,
                'sub_id' => $ongoing_pr->sub_id,
                'year_id' => $ongoing_pr->year_id,
                'budget' => $ongoing_pr->budget,
                'pr_status' => 'ongoing',
                'start_date' => $ongoing_pr->start_date,
                'end_date' => $ongoing_pr->end_date,
                'remarks' => $ongoing_pr->remarks,
                'reasons' => ''
            ]);

            //no need for validation since data is taken and returned to database with
            //status as approved

            if($data->update($id))
            {
                /*
                 * First We log the Users' activity using the static class in DbModel
                 */
                DbModel::logUserActivity('started a project - ' . $ongoing_pr->project_name);

                /*
                 * If this function runs it means status was changed to approved
                 */
                Application::$app->session->setFlashMessage('success', 'Project has Started!!');
                Application::$app->response->redirect('/projects_start');
                exit;
            }

        }
        //if no id exists == false
        //render the view and passes the view
        //we need to also search and pass the view if user filters by sub county
        return $this->render('../app/projects/projects_start', [
            'model' => [
                'projects' => $ongoingProjects,
            ]
        ]);
    }

    public function projects_manage()
    {
        //Here also is where project execution will take place depending on whether the user is pm or staff
        //Render page only for ongoing projects

        $this->setLayout('app');
        //fetches all projects for project manager where status is ongoing i.e has already been started

        $ongoingProjects = ProjectModel::fetchWithRelationWhere(['pr_status' => 'ongoing'], ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //and as for the staff, we want to display for them their own projects, i.e they should not see projects that belong to their fellow staff
        //so we fetch  the id of the user in session and then we fetchWithRelationWhere the id of the user in question is the id
        //of th user in session

        $staffProjects = ProjectModel::fetchWithRelationWhere(['staff_id' => $_SESSION['user']['id'], 'pr_status' => 'ongoing'], ['dep_id', 'sub_id', 'year_id', 'staff_id']);


        //renders the page if method is get and passes the parameters

        return $this->render('../app/projects/projects_manage', [
            'model' => [
                'projects' => $ongoingProjects,
                'staffProjects' => $staffProjects
            ]
        ]);
    }

    public function projects_showcase(Request $request)
    {
        //here we want to see what the staff is doing, also we want to budget for our project
        //set layout
        $this->setLayout('app');
        //return all ongoing models where id is id passed, that is we get for a specific project being
        //tracked

        $id = $request->getReqId();
        $ongoingProjects = ProjectModel::fetchByIdWithRelation($id, ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //We find all tasks where the project id is the id of the project being tracked and display in view
        $tasks = TaskModel::findAllWhere(['proj_id' => $id]);

        if($request->getMethod() === "post")
        {
            /*
             * if request method is post, get body information from post data of task and load, we
             * will use this information to deduct amount from the project budget posted and append to the
             * tasks table in db
             * Do to the nature and sensitivity of the tasks, we will not have a Task Controller
             */


            $tasks = new TaskModel();
            $tasks->loadData($request->getBody());


            //if task budget is less than or equal to current project, do this
            if($tasks->budget <= $ongoingProjects->budget)
            {
                //get the remaining amount in project
                $proj_balance = $ongoingProjects->budget - $tasks->budget;
                //update budget field in both projects and tasks

                //projects
                $projectData = new ProjectModel();
                //load the data
                $projectData->loadData([
                    'project_name' => $ongoingProjects->project_name,
                    'staff_id' => $ongoingProjects->staff_id,
                    'dep_id' => $ongoingProjects->dep_id,
                    'sub_id' => $ongoingProjects->sub_id,
                    'year_id' => $ongoingProjects->year_id,
                    'budget' => $proj_balance,
                    'pr_status' => $ongoingProjects->pr_status,
                    'start_date' => $ongoingProjects->start_date,
                    'end_date' => $ongoingProjects->end_date,
                    'remarks' => $ongoingProjects->remarks,
                    'reasons' => ''
                ]);
                //We now update the projects table in the database

                $projectData->update($request->getReqId());

                //And then save the new task added that will be displayed
                $tasks->save();

                /*
                * First We log the Users' activity using the static class in DbModel
                */
                DbModel::logUserActivity('added a new task in ' . $projectData->project_name . ' worth Ksh ' . $tasks->budget);

                //Add success message and redirect user
                Application::$app->session->setFlashMessage('success', 'Task Added Successfully, Project Updated');
                Application::$app->response->redirect('/projects_manage');
                exit;
            }

            //if the above is false it means task budget was higher than project budget, therfore display error
            Application::$app->session->setFlashMessage('failed', 'Task Budget cannot surpass Project Budget');
            Application::$app->response->redirect('/projects_manage');


        }

        /*
         * This runs if request method is get, it renders the view passing the project being tracked along with
         * its tasks
         */
        return $this->render('../app/projects/projects_showcase', [
            'model' => [
                'projects' => $ongoingProjects,
                'tasks' => $tasks,
            ]
        ]);
    }

    public function projects_complete(Request $request)
    {
        //Just like we did in approved
        //get all projects with Relation where id is the id that was posted in get body
        $id = $request->getReqId();
        $completed_pr = ProjectModel::fetchByIdWithRelation($id, ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //new instance of model to get table properties

         $data = new ProjectModel();

        //load the data and only change status to completed, the rest remain constant
        $data->loadData([
            'project_name' => $completed_pr->project_name,
            'staff_id' => $completed_pr->staff_id,
            'dep_id' => $completed_pr->dep_id,
            'sub_id' => $completed_pr->sub_id,
            'year_id' => $completed_pr->year_id,
            'budget' => $completed_pr->budget,
            'pr_status' => 'complete',
            'start_date' => $completed_pr->start_date,
            'end_date' => $completed_pr->end_date,
            'remarks' => $completed_pr->remarks,
            'reasons' => ''
        ]);

        //no need for validation since data is taken and returned to database with
        //status as approved
        if($data->budget == 0 && $data->update($id))
        {
            /*
             * First We log the Users' activity using the static class in DbModel
             */
            DbModel::logUserActivity('completed a project - ' . $completed_pr->project_name);

            /*
             * If this function runs it means status was changed to approved
             */
            Application::$app->session->setFlashMessage('success', 'Project is Complete!!');
            Application::$app->response->redirect('/projects');
        }
        else
        /*
         * Else it means pm tried to finish a project that is not complete yet, so display an error
         */
        {
            Application::$app->session->setFlashMessage('failed', 'Project cannot be completed until account is Ksh 0');
            Application::$app->response->redirect('/projects_manage');
        }

    }

}