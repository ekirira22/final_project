<?php

require_once __DIR__ . '/../myAutoloader.php';

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;


/*
 * An instance of Application is run, we pass directory name of current directory using magic constant
 * __DIR__ so that we can always call root directory from Application class constructor
 */


$app = new Application(dirname(__DIR__));

/*
 * Below,get function inside router instance takes all the given routes here and stores them
 * inside the protected routes array inside Router class
 */
$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact', [SiteController::class, 'contact']);

/* Auth Routes*/
/*Login*/
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

/*Register*/
$app->router->get('/register', [AuthController::class, 'register']);

$app->router->post('/register', [AuthController::class, 'register']);

$app->run();

