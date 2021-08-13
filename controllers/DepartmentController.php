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
    public function index(Request $request)
    {

        $this->setLayout('app');
        $departments = DepartmentModel::all();


        return $this->render('../app/departments/dep_view', [
            'model' => $departments
        ]);

    }

    public function create(Request $request)
    {
        $this->setLayout('app');
        $departments = new DepartmentModel();

        if($request->getMethod() === "post")
        {
            $departments->loadData($request->getBody());
            if($departments->validate() && $departments->save())
            {
                Application::$app->session->setFlashMessage('success', 'Department added Successfully');
                Application::$app->response->redirect('/departments');
            }

            return $this->render('../app/departments/dep_create', [
                'model' => $departments
            ]);
        }
        return $this->render('../app/departments/dep_create', [
            'model' => $departments
        ]);

    }

    public function edit(Request $request)
    {
        $this->setLayout('app');
        $departments = DepartmentModel::findOneRecord(['id' => $request->getReqId()]);

        if($request->getMethod() === "post")
        {
            $departments = new DepartmentModel();
            $departments->loadData($request->getBody());
            if($departments->validate() && $departments->update($request->getReqId()))
            {
                /*Bug located: Cannot update upon second request after validation fails */

                Application::$app->session->setFlashMessage('success', 'Department successfully Updated');
                Application::$app->response->redirect('/departments');
            }
            return $this->render('../app/departments/dep_edit', [
                'model' => $departments
            ]);
        }

        return $this->render('../app/departments/dep_edit', [
            'model' => $departments
        ]);
    }

    public function delete(Request $request)
    {
        $department = new DepartmentModel();
        $departmentId = $request->getReqId();
        $delete = $department->deleteById($departmentId);
        if($delete):
            Application::$app->session->setFlashMessage('success', 'Department Deleted Successfully');
            Application::$app->response->redirect('/departments');
        endif;
        exit;
    }

}