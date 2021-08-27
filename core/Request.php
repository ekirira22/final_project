<?php

namespace app\core;

/* This will be the class that returns super global server results. This class will deal with users get and post
 * requests
 * This had to be a separate class for re-usability
*/
class Request
{
    /*
     * Public function get path that returns the path of the currently active page, I also noted that
     * if the path was root '/' , no key ['PATH_INFO'] popped up, so if path info is not found, then return
     * '/' as default path
     */
    public function getPath()
    {
        return $_SERVER['PATH_INFO'] ?? '/';

    }

    /*
     * Public function getMethod that checks the request method of the current page from global
     * server variable, the result is always in caps, so we use strtolower() to convert it back
     * to lowercase
     */

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);

    }

    /*
     * Public function getReqId() that gets the id value passed to GET request when GET is used
     * We will use this to edit specific users, projects, departments etc.
     */

    public function getReqId()
    {
        return $_GET['id'] ?? false;
    }

    /*
     * Public function getBody() that gets the body, loads the body and returns it
     */
    public function getBody()
    {
        //We declare an empty array $body
        $body = [];

        //for this specific getBody we will use for "post" values
        //if request method is "post, then

        if($this->getMethod() === "post"):
            //post values will look something like ['name' => 'Eric Maranga', etc. etc.]
            //loop through the assoc array
            foreach ($_POST as $key => $value) {

                /*
                 * we then store the result inside the respective key, AND call filter_input method that accepts three arguments
                 * The input type, key of the value, and the method special_chars AKA FILTER_SANITIZE_SPECIAL_CHARS where
                 * HTML-encode '"<>& and characters with ASCII value less than 32, optionally strip or encode other special characters.
                 */
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        endif;

            //we then return the body with the loaded values
        return $body;
    }

    /*
     * Public function getSearchValue that gets the search value that a user searches with and uses
     * it to get the value using methods in DbModel
     */

    public function getSearchVal()
    {
        return $_GET['search'] ?? false;
    }

    /*
     * We use this function to get values used in filtering, e.g dates
     */

    public function getFilteredValue($filter)
    {
        return $_GET[$filter] ?? null;
    }


}