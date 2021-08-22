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

    //Layout is set to main by default, any other layout to be rendered through the controllers
    //This variable will also be accessed in Router Class
    public string $layout = 'main';

    /*
     * Public function setLayout that sets layout to whatever is passed
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /*
     * Public function render, that has to be called by all controllers which extend to this class
     * It passes the view and the params(which in this case is the information passed to the controller
     * based on user requests from the DbModel) to the router which renders the view
     */

    public function render($view, $params){
        return Application::$app->router->renderView($view, $params);
    }

}