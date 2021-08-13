<?php


namespace app\controllers;
/*
 * Class SubCountyController
 * This class will be used to control how the sub county pages will look like along
 * with the sub CRUD FunctionALITY
 */

use app\core\Application;
use app\core\Request;
use app\models\SubCountyModel;

class SubCountyController extends Controller
{
    public function index()
    {
        $this->setLayout('app');
        $sub_counties = SubCountyModel::all();

        return $this->render('../app/sub_counties/sub_view', [
            'model' => $sub_counties
        ]);
    }

    public function create(Request $request)
    {
        $this->setLayout('app');
        $sub_counties = new SubCountyModel();

        if($request->getMethod() === "post")
        {
            $sub_counties->loadData($request->getBody());
            if($sub_counties->validate() && $sub_counties->save())
            {
                Application::$app->session->setFlashMessage('success', 'Sub county created Successfully');
                Application::$app->response->redirect('/sub_counties');
            }
            return $this->render('../app/sub_counties/sub_create', [
                'model' => $sub_counties
            ]);
        }

        return $this->render('../app/sub_counties/sub_create', [
            'model' => $sub_counties
        ]);
    }

    public function edit(Request $request)
    {
        $this->setLayout('app');

        $sub_counties = SubCountyModel::findById($request->getReqId());

        return $this->render('../app/sub_counties/sub_edit', [
            'model' => $sub_counties
        ]);
    }

    public function update(Request $request)
    {
        $this->setLayout('app');
        $sub_county = new SubCountyModel();

        $sub_county->loadData($request->getBody());

        if($sub_county->validate() && $sub_county->update($request->getReqId()))
        {
            Application::$app->session->setFlashMessage('success', 'Sub County updated Successfully');
            Application::$app->response->redirect('/sub_counties');
        }

        return $this->render('../app/sub_counties/sub_edit', [
            'model' => $sub_county
        ]);
    }

    public function delete(Request $request)
    {
        $sub_county = new SubCountyModel();
        /*Deletes Financial Year by passing the id which is gotten using the get method to the deleteById method inside DbModel class*/

        $delete = $sub_county->deleteById($request->getReqId());

        if($delete)
        {
            Application::$app->session->setFlashMessage('success', 'Sub county deleted Successfully');
            Application::$app->response->redirect('/sub_counties');
            exit;

        }
        Application::$app->session->setFlashMessage('failed', 'Something went wrong');
        exit;
    }
}