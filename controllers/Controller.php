<?php


namespace app\controllers;
/*
 * Base class Controller
 * All controllers will extend to this class ad the parent controller class
 * This is done to render the renderView function that is inside the ROuter class easily
 */

use app\core\Application;

class Controller
{
    /*
     * Here we want to set the specific layout depending on controller e.g
     * Authcontrollers will trigger auth.php layout, Sitecontrollers will trigger main.php and so on
     */
    public string $layout = 'main';

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params){
        return Application::$app->router->renderView($view, $params);
    }

}