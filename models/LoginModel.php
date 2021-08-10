<?php

namespace app\models;
/*
 * This class will basically fetch data from db and do validations for the AuthController class
 * in order to determine whether to login user etc.
 */

use app\core\Application;
use app\core\DbModel;
use app\core\Model;

class LoginModel extends DbModel
{
    /*Declare variables from the form input*/

    public string $email = '';
    public string $password = '';

    public function loginUser(): bool
    {
       /*
        * We need to find the user based on the email provided and if the user doesn't exist we
        * need to show an error, if user exists we need to check password provided against the one in db
        * If password is wrong we need to output an error for that as well
        * Otherwise authenticate user and store them in session
        */
        $user = UserModel::findOneRecord(['email' => $this->email]);

        if(!$user)
        {
            $this->addErrorMessages('email', 'User with this email does not exist');
            return false;
        }
        if($user->password !== md5($this->password))
        {
            $this->addErrorMessages('password', 'Wrong email or password');
            return false;

        }

        Application::$app->login($user);
        return true;
    }

    public function rules(): array
    {
        return [
          'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
          'password' => [self::RULE_REQUIRED]
        ];
    }


    public function attributes(): array
    {
        // TODO: Implement attributes() method.
    }

    public function tableName(): string
    {
        // TODO: Implement attributes() method.
    }

    public function primaryKey(): string
    {
        // TODO: Implement primaryKey() method.
    }
}