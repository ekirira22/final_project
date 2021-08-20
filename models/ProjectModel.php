<?php


namespace app\models;
/*
 * This class will model the Project properties and will extend to DbModel for
 * database access
 */


use app\core\DbModel;


class ProjectModel extends DbModel
{

    public string $project_name = '';
    public string $staff_id = '';
    public string $dep_id = '';
    public string $sub_id = '';
    public string $year_id = '';
    public string $budget = '';
    public string $pr_status = 'pending';
    public string $start_date = '';
    public string $end_date = '';
    public string $remarks = '';
    public string $reasons = ' ';


    public function tableName(): string
    {
        return 'projects';
    }

    public function attributes(): array
    {
        return [
            'project_name',
            'staff_id',
            'dep_id',
            'sub_id',
            'year_id',
            'budget',
            'pr_status',
            'start_date',
            'end_date',
            'remarks',
            'reasons'
        ];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function save(): bool
    {
        $this->staff_id = (int)$this->staff_id;
        $this->dep_id = (int) $this->dep_id;
        $this->sub_id = (int) $this->sub_id;
        $this->year_id = (int) $this->year_id;
        $this->budget = (int) $this->budget;
        return parent::save();

    }


    public function rules(): array
    {
        return [
          'project_name' => [self::RULE_REQUIRED],
          'staff_id' => [self::RULE_REQUIRED],
            'dep_id' => [self::RULE_REQUIRED],
          'sub_id' => [self::RULE_REQUIRED],
          'year_id' => [self::RULE_REQUIRED],
          'budget' => [self::RULE_REQUIRED],
          'pr_status' => [self::RULE_REQUIRED],
          'start_date' => [self::RULE_REQUIRED, [self::RULE_VALID_START_DATE, 'start_date' => \date("Y-m-d") ]],
            'end_date' => [self::RULE_REQUIRED, [self::RULE_VALID_END_DATE, 'end_date' => 'start_date']],
            'remarks' => [self::RULE_REQUIRED],


        ];
    }

    public function relationTables(): array
    {
        return [
          'departments', 'sub_counties', 'financial_years', 'staff'
        ];
    }
    public function userType(): string
    {
        // TODO: Implement userType() method.
    }
}