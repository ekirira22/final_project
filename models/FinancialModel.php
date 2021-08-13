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


    public function tableName(): string
    {
        return 'financial_years';
    }

    public function attributes(): array
    {
        return [
          'year_name'
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
          'year_name' => [self::RULE_REQUIRED]
        ];
    }
}