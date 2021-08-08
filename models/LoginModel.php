<?php

namespace app\models;
/*
 * This class will basically fetch data from db and do validations for the AuthController class
 * in order to determine whether to login user etc.
 */

use app\core\Model;

class LoginModel extends Model
{
    /*Declare variables from the form input*/

    public string $email;
    public string $password;

    public function loginUser()
    {
        return "Logging in user";
    }

    public function rules(): array
    {
        return [
          'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
          'password' => [self::RULE_REQUIRED]
        ];
    }
}