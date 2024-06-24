<?php


namespace app\models;
/*
 * This class will model the FinancialYear properties and will extend to DbModel for
 * database access
 */


use app\core\DbModel;

class FinancialModel extends DbModel
{

    public string $year_name = '';


    //returns table name in db
    public function tableName(): string
    {
        return 'financial_years';
    }

    //returns columns in db
    public function attributes(): array
    {
        return [
          'year_name'
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


    //returns the rules that this class is supposed to follow
    public function rules(): array
    {
        return [
          'year_name' => [self::RULE_REQUIRED]
        ];
    }
}