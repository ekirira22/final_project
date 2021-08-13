<?php


namespace app\controllers;
/*
 * Class FinancialYearController
 * This class will be used to control how the Financial Year pages will look like along
 * with the department CRUD FunctionALITY
 */

use app\core\Application;
use app\core\Request;
use app\models\FinancialModel;

class FinancialYearController extends Controller
{
    public function index()
    {
        $this->setLayout('app');
        $f_years = FinancialModel::all();

        return $this->render('../app/financial_years/fy_view', [
           'model' => $f_years
        ]);
    }

    public function create(Request $request)
    {
        $this->setLayout('app');
        $f_years = new FinancialModel();

        if($request->getMethod() === "post")
        {
            $f_years->loadData($request->getBody());
            if($f_years->validate() && $f_years->save())
            {
                Application::$app->session->setFlashMessage('success', 'Financial Year created Successfully');
                Application::$app->response->redirect('/financial_years');
            }
            return $this->render('../app/financial_years/fy_create', [
                'model' => $f_years
            ]);
        }

        return $this->render('../app/financial_years/fy_create', [
            'model' => $f_years
        ]);
    }

    public function edit(Request $request)
    {
        $this->setLayout('app');

        $f_years = FinancialModel::findById($request->getReqId());

        return $this->render('../app/financial_years/fy_edit', [
            'model' => $f_years
        ]);
    }

    public function update(Request $request)
    {
        $this->setLayout('app');
        $f_year = new FinancialModel();

        $f_year->loadData($request->getBody());

        if($f_year->validate() && $f_year->update($request->getReqId()))
        {
            Application::$app->session->setFlashMessage('success', 'Financial Year updated Successfully');
            Application::$app->response->redirect('/financial_years');
        }

        return $this->render('../app/financial_years/fy_edit', [
            'model' => $f_year
        ]);
    }

    public function delete(Request $request)
    {
        $f_year = new FinancialModel();
        /*Deletes Financial Year by passing the id which is gotten using the get method to the deleteById method inside DbModel class*/

        $delete = $f_year->deleteById($request->getReqId());

        if($delete)
        {
            Application::$app->session->setFlashMessage('success', 'Financial Year deleted Successfully');
            Application::$app->response->redirect('/financial_years');
            exit;

        }
        Application::$app->session->setFlashMessage('failed', 'Something went wrong');
        exit;
    }


}