<?php

namespace app\core;

/* This will be the class the sorts all the project routes */
use app\controllers\Controller;
class Router
{
    public Request $request;


    /*Protected array of routes that stores all the paths with their respective callback functions*/
    protected array $routes = [];

    /**
     * Router constructor.
     * @param Request $request
     */
    /*
     * NB: In the Application class, we passed the request property to the instantiated
     *  Router class, this $request of type Request is accessible in this class constructor
     * We assign it to $request of type Request of this class
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

    }

    /*Function that accepts path and callback fn of a selected route and returns the executable callback for get*/
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /*Function that accepts path and callback fn of a selected route and returns the executable callback for post*/
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }


    /*This determines the 'current' URL path and the current method, get or post?
     *From the routes[] array we need to take the corresponding callback and simply execute it
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if($callback === false):
            Application::$app->response->setStatusCode(404);
            //Here we have to initialize the controller for it to be accessible in the layoutContent Method
            Application::$app->controller = new Controller();
            return $this->renderView("/../other/_404");
        endif;

        /*check if the callback is a string if it is, render the respective view
        *if it isn't it means its an array or a function, execute the user defined function
        */

        if(is_string($callback)):
            return $this->renderView($callback);
        endif;

        /*
         * Check if the callback is an array, if it is, instantiate the first element of the array e.g if SiteController
         * is passed instantiate it and reassign the value to the first element, this is because $this cannot be used
         * on non-object entities
         */

        if(is_array($callback)):
            /*
             * Here, we're creating an instance of the respective controller and passing the object back to the first array
             * property, we're storing it to access it in layout and render the respective view
             */

            Application::$app->controller = new $callback[0];
            $callback[0] = Application::$app->controller;

            return call_user_func($callback, $this->request);

        endif;
        //if neither is a string or an array i.e it's a function otherwise known as closure,
        return call_user_func($callback, $this->request);
    }

    /*
     * This function takes the stringed values of the layout page and the page to be viewed, it then searches
     * for the placeholder {{content}} inside the layout page and replaces it with the view
     */

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    /*
     * The following two functions open an output buffer which takes all the content of the included pages, returns
     * the output as string which is stored in memory, it then clears the buffer
     */
    public function layoutContent()
    {

        //we render the layout that is passed to the controller, by default layout is 'main'
        $layout = Application::$app->controller->layout;
            ob_start();
            include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
            return ob_get_clean();

    }

    /*
     * Protected function renderOnlyView that renders the view only without the layout
     * As you can see it accepts params, these params are values gotten from the model by the controller
     * They are then passed here to be made accessible by the view
     */
    protected function renderOnlyView($view, $params){

        /*
         * Params will look something like ['model' => $object]
         * We loop through this assoc array and add a variable sign before the key '$' to convert
         * the key into a property, and then assign the corresponding value to it, this values are also loaded in the buffer
         */
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/pages/$view.php";
        return ob_get_clean();
    }


}