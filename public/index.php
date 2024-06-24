<?php

require_once __DIR__ . '/../myAutoloader.php';

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\DepartmentController;
use app\controllers\FinancialYearController;
use app\controllers\SubCountyController;
use app\controllers\ProjectController;
use app\controllers\TaskController;


/*
 * An instance of Application is run, we pass directory name of current directory using magic constant
 * __DIR__ so that we can always call root directory from Application class constructor, we also pass the db configuration
 */

$config = [
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=pms',
        'user' => 'root',
        'password' => '',
    ]
];

$app = new Application(dirname(__DIR__), $config);

/*
 * Below,get function inside router instance takes all the given routes here and stores them
 * inside the protected routes array inside Router class
 */

/*Main Site Routes*/
$app->router->get('/', [SiteController::class, 'guest']);
$app->router->get('/home', [SiteController::class, 'home']);
$app->router->get('/user_activity', [SiteController::class, 'activity']);
$app->router->get('/reports', [SiteController::class, 'reports']);


/* Auth Routes*/
/*Login and Logout*/
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);

/*Department Routes*/
$app->router->get('/departments', [DepartmentController::class, 'index']);
$app->router->get('/department_create', [DepartmentController::class, 'create']);
$app->router->post('/department_create', [DepartmentController::class, 'create']);
$app->router->get('/department_edit', [DepartmentController::class, 'edit']);
$app->router->post('/department_edit', [DepartmentController::class, 'edit']);
$app->router->get('/department_del', [DepartmentController::class, 'delete']);

/*County Staff*/
$app->router->get('/staff', [AuthController::class, 'index']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/staff_edit', [AuthController::class, 'edit']);
$app->router->post('/staff_update', [AuthController::class, 'update']);
$app->router->get('/staff_change_password', [AuthController::class, 'change_password']);
$app->router->post('/staff_change_password', [AuthController::class, 'change_password']);
$app->router->get('/staff_del', [AuthController::class, 'delete']);

/*Financial Years*/
$app->router->get('/financial_years', [FinancialYearController::class, 'index']);
$app->router->get('/f_year_create', [FinancialYearController::class, 'create']);
$app->router->post('/f_year_create', [FinancialYearController::class, 'create']);
$app->router->get('/f_year_edit', [FinancialYearController::class, 'edit']);
$app->router->post('/f_year_update', [FinancialYearController::class, 'update']);
$app->router->get('/f_year_del', [FinancialYearController::class, 'delete']);

/*Sub Counties and Wards*/
$app->router->get('/sub_counties', [SubCountyController::class, 'index']);
$app->router->get('/sub_create', [SubCountyController::class, 'create']);
$app->router->post('/sub_create', [SubCountyController::class, 'create']);
$app->router->get('/sub_edit', [SubCountyController::class, 'edit']);
$app->router->post('/sub_update', [SubCountyController::class, 'update']);
$app->router->get('/sub_del', [SubCountyController::class, 'delete']);

/*Projects*/
$app->router->get('/projects', [ProjectController::class, 'index']);
$app->router->get('/project_create', [ProjectController::class, 'create']);
$app->router->post('/project_create', [ProjectController::class, 'create']);
$app->router->get('/project_edit', [ProjectController::class, 'edit']);
$app->router->post('/project_update', [ProjectController::class, 'update']);
$app->router->get('/project_del', [ProjectController::class, 'delete']);

/* CEC Tasks*/
$app->router->get('/projects_pending', [ProjectController::class, 'pending']);
$app->router->get('/projects_approve', [ProjectController::class, 'approved']);
$app->router->get('/projects_delay', [ProjectController::class, 'delay']);

/* PM and staff tasks */
$app->router->get('/projects_start', [ProjectController::class, 'projects_start']);
$app->router->get('/projects_manage', [ProjectController::class, 'projects_manage']);
$app->router->get('/projects_showcase', [ProjectController::class, 'projects_showcase']);
$app->router->post('/projects_showcase', [ProjectController::class, 'projects_showcase']);
$app->router->get('/projects_complete', [ProjectController::class, 'projects_complete']);



/*
 * Runs the main application
 */


$app->run();

