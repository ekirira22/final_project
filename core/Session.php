<?php

/*
 * This class will
 * This will also put messages in the session after redirect, it will need to be deleted after one request
 * The idea behind session flash messages is that you put some message in the session which is only
 * there for one request, as soon as another request is made it disappears
 */
namespace app\core;


class Session
{
    /*
     *  flash_messages = [
     *      'success' => [
     *          'remove' => true / false,
     *          'value' => message
     *      ]
     * ]
     */

    protected const FLASH_KEYS = 'flash_messages';

    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEYS] ?? [];
        foreach ($flashMessages as $key => &$flashMessage)
        {
            //Mark to be removed after a new session is started i.e a new request is made
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEYS] = $flashMessages;

    }


    public function setFlashMessage($key, $message)
    {

        $_SESSION[self::FLASH_KEYS][$key] = [
            'remove' => false,
            'value' => $message
        ];

    }

    public function getFlashMessage($key)
    {
        return $_SESSION[self::FLASH_KEYS][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        //iterate over flash messages to unset them once a request is done
        $flashMessages = $_SESSION[self::FLASH_KEYS];
        foreach ($flashMessages as $key => &$flashMessage) {
            if($flashMessage['remove'])
            {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEYS] = $flashMessages;


    }
}