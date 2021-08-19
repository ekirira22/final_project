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
use app\models\ProjectModel;

class SiteController extends Controller
{


    public function guest(Request $request)
    {

        $projects = ProjectModel::fetchWithRelation(['dep_id', 'sub_id', 'year_id', 'staff_id']);
        $search = $request->getSearchVal();

        $results = ProjectModel::fetchBySearchWithRelation($search,['project_name', 'dep_name', 'sub_name'], ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //var_dump($results);

        $this->setLayout('main');

        return $this->render('home', [
            'model' => $projects,
            'search' => [
                'value' => $search,
                'results' => $results
            ]
        ]);
    }

    public function home(Request $request)
    {

        $projects = ProjectModel::fetchWithRelation(['dep_id', 'sub_id', 'year_id', 'staff_id']);
        $search = $request->getSearchVal();

        $results = ProjectModel::fetchBySearchWithRelation($search,['project_name', 'dep_name', 'sub_name'], ['dep_id', 'sub_id', 'year_id', 'staff_id']);

        //var_dump($results);

        $this->setLayout('app');

        return $this->render('home', [
            'model' => $projects,
            'search' => [
                'value' => $search,
                'results' => $results
            ]
        ]);
    }

    public function contact(): string
    {
        $params =[];
        return $this->render('contact', $params);
    }


}