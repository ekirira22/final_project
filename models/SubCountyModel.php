<?php


namespace app\models;
/*
 * This class will model the Subcounty properties and will extend to DbModel for
 * database access
 */


use app\core\DbModel;

class SubCountyModel extends DbModel
{

    public string $sub_name = '';
    public string $ward = '';


    //returns table name in db
    public function tableName(): string
    {
        return 'sub_counties';
    }

    //returns columns in db
    public function attributes(): array
    {
        return [
          'sub_name', 'ward'
        ];
    }

    //returns primaryKey in db
    public function primaryKey(): string
    {
        return 'id';
    }

    public function userType(): string
    {
        // TODO: Implement userType() method.
    }

    //returns the rules this class should follow
    public function rules(): array
    {
        return [
            'sub_name' => [self::RULE_REQUIRED],
            'ward' => [self::RULE_REQUIRED],
        ];
    }
}