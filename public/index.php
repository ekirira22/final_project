<?php

require_once __DIR__ . '/../myAutoloader.php';

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;


/*
 * An instance of Application is run, we pass directory name of current directory using magic constant
 * __DIR__ so that we can always call root directory from Application class constructor, we also pass the db configuration
 */

$config = [
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=final_pms',
        'user' => 'root',
        'password' => '',
    ]
];

$app = new Application(dirname(__DIR__), $config);

/*
 * Below,get function inside router instance takes all the given routes here and stores them
 * inside the protected routes array inside Router class
 */


$app->router->get('/', [SiteController::class, 'guest']);
$app->router->get('/home', [SiteController::class, 'home']);
$app->router->get('/contact', [SiteController::class, 'contact']);

/* Auth Routes*/
/*Login and Logout*/
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);


/*Register*/
$app->router->get('/register', [AuthController::class, 'register']);

$app->router->post('/register', [AuthController::class, 'register']);

$app->run();

