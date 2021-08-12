<?php


namespace app\models;
/*
 * This class, just like login will basically fetch data from db and do validations for the AuthController class
 * in order to determine whether to register user etc.
 */

use app\core\DbModel;


class UserModel extends DbModel
{

    public string $names = '';
    public string $id_number = '';
    public string $mobile_no = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public string $status = '';
    public string $user_type = '';

    public function tableName(): string
    {
        return 'staff';
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function userType(): string
    {
        return 'user_type';
    }

    public function attributes(): array
    {
        return ['names', 'id_number', 'mobile_no', 'email', 'password', 'status', 'user_type'];
    }

    public function register(): bool
    {
        $this->password = md5($this->password);
        return parent::save();
    }

    /*
     * Here, we are defining the rules specific to the register model, each model can have different sets of rules
     */
    public function rules(): array
    {
        return[
            'names' => [self::RULE_REQUIRED],
            'id_number' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class, 'attr' => 'id_number']],
            'mobile_no' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class, 'attr' => 'email']],
            'password' => [self::RULE_REQUIRED],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'status' => [self::RULE_REQUIRED],
            'user_type' => [self::RULE_REQUIRED],


        ] ;
    }


}