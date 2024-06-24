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
    public string $dep_id = '';
    public string $id_number = '';
    public string $mobile_no = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
    public string $status = '';
    public string $user_type = '';


    //returns table name in db
    public function tableName(): string
    {
        return 'staff';
    }

    //returns primary key
    public function primaryKey(): string
    {
        return 'id';
    }

    //returns user_type column
    public function userType(): string
    {
        return 'user_type';
    }

    //returns attributes / columns i n db beloging to this class
    public function attributes(): array
    {
        return ['names', 'dep_id', 'id_number', 'mobile_no', 'email', 'password', 'status', 'user_type'];
    }

    //hashes the password, this overwrites password with hashed value and called parent method in DbMOdel save()
    public function register(): bool
    {
        $this->password = md5($this->password);
        $this->dep_id = (int)$this->dep_id;
        return parent::save();
    }

    /*
     * Here, we are defining the rules specific to the register model, each model can have different sets of rules
     */
    public function rules(): array
    {
        return[
            'names' => [self::RULE_REQUIRED],
            'dep_id' => [self::RULE_REQUIRED],
            'id_number' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class, 'attr' => 'id_number']],
            'mobile_no' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class, 'attr' => 'email']],
            'password' => [self::RULE_REQUIRED],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'status' => [self::RULE_REQUIRED],
            'user_type' => [self::RULE_REQUIRED],


        ] ;
    }

    //returns relational tables
    public function relationTables(): array
    {
        return [
            'departments'
        ];
    }


}