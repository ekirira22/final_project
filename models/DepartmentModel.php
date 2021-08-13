<?php


namespace app\models;
/*
 * This class will model the Department properties and will extend to DbModel for
 * databse access
 */


use app\core\DbModel;

class DepartmentModel extends DbModel
{
    public string $dep_name = '';
    public string $status = '';



    public function tableName(): string
    {
        return 'departments';
    }

    public function attributes(): array
    {
        return [
          'dep_name', 'status'
        ];
    }

    public function primaryKey(): string
    {
        return 'id';
    }


    public function rules(): array
    {
        return [
          'dep_name' => [self::RULE_REQUIRED],
          'status' => [self::RULE_REQUIRED],
        ];
    }

    public function userType(): string
    {
        // TODO: Implement userType() method.
    }

}