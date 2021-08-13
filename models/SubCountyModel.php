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


    public function tableName(): string
    {
        return 'sub_counties';
    }

    public function attributes(): array
    {
        return [
          'sub_name', 'ward'
        ];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function userType(): string
    {
        // TODO: Implement userType() method.
    }

    public function rules(): array
    {
        return [
            'sub_name' => [self::RULE_REQUIRED],
            'ward' => [self::RULE_REQUIRED],
        ];
    }
}