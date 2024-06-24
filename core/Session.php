<?php

/*
 * This class will
 * This will also put messages in the session after redirect, it will need to be deleted after one request
 * The idea behind session flash messages is that you put some message in the session which is only
 * there for one request, as soon as another request is made it disappears
 */
namespace app\core;

/*
 * Main class Session
 */
class Session
{

    /*
     * Basically flash_messages will look like this
     *  flash_messages = [
     *      'key' => [
     *          'remove' => true / false,
     *          'value' => message
     *      ],
     *      'key' => [
     *          'remove' => true / false,
     *          'value' => message
     *      ]
     * ]
     */


    //constant to store flash_messages
    protected const FLASH_KEYS = 'flash_messages';


    /*
     * Constructor will be used to start a session every time session is called
     * Session will always be instantiated inside the Application class
     */
    public function __construct()
    {
        //starts session
        session_start();
        //we create variable $flash_keys that will be used in this constructor and assign the $_SESSION flash keys
        //to it, we do this to modify it by reference, if false throw an empty array

        $flashMessages = $_SESSION[self::FLASH_KEYS] ?? [];

        foreach ($flashMessages as $key => &$flashMessage)
        {
            //For the given key e.g. success or failed, mark to be removed
            // after a new session is started i.e a new request is made

            $flashMessage['remove'] = true;
        }
        /*
         * NB: The amperstand & is used for reference, without it nothing is altered
         * Assign the flash message back to $_SESSION
         */

        $_SESSION[self::FLASH_KEYS] = $flashMessages;
//        var_dump($_SESSION);
    }

    /*
     * Public function setFlashMessage that accepts two parameters, the key and the message
     */

    public function setFlashMessage($key, $message)
    {
        /*
         * Set remove to be false so that it may not disappear and be displayed
         */

        $_SESSION[self::FLASH_KEYS][$key] = [
            'remove' => false,
            'value' => $message
        ];

    }

    /*
     *
     * Public function setFlashMessage that accepts one parameter, the key and then
     * returns the message (value) that exist in $_SESSION to be displayed
     */
    public function getFlashMessage($key)
    {
        return $_SESSION[self::FLASH_KEYS][$key]['value'] ?? false;
    }

    /*
     * Here in the destructor, we want to get all flashmessages that remove has been set to true
     * and unset them so that they cannot be displayed once another request is made
     */

    public function __destruct()
    {
        //iterate over flash messages to unset them once a request is done
        $flashMessages = $_SESSION[self::FLASH_KEYS];

        //unset by reference using amperstand &

        foreach ($flashMessages as $key => &$flashMessage) {
            if($flashMessage['remove'])
            {
                //for the remove key inside the key provided, if the value is set
                //to true, unset the flash_message
                unset($flashMessages[$key]);
            }
        }
        //return the value to $_SESSION
        $_SESSION[self::FLASH_KEYS] = $flashMessages;


    }

    /*Maintaining sessions*/

    /*
     * Sets user in session
     */
    public function set(string $key, array $values)
    {
        $_SESSION[$key] = $values;
    }

    /*
     * Gets user in session using id
     */
    public function get(string $key)
    {
        return $_SESSION[$key]['id'] ?? false;
    }

    /*
     * Removes user from session when they log out
     */
    public function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

}