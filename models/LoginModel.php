<?php

namespace app\models;
/*
 * This class will basically fetch data from db and do validations for the AuthController class
 * in order to determine whether to login user etc.
 */

use app\core\DbModel;


class LoginModel extends DbModel
{
    /*Declare variables from the form input*/

    public string $email;
    public string $password;

    public function loginUser()
    {
       //todo
    }

    public function rules(): array
    {
        return [
          'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
          'password' => [self::RULE_REQUIRED]
        ];
    }

    public function tableName(): string
    {
        // TODO: Implement tableName() method.
    }

    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }
}