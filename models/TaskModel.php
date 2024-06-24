<?php


namespace app\models;
/*
 * This class will model the Project properties and will extend to DbModel for
 * database access
 */


use app\core\DbModel;


class TaskModel extends DbModel
{

    public string $task_name = '';
    public string $proj_id = '';
    public string $description = '';
    public string $budget = '';



    //returns table name in db
    public function tableName(): string
    {
        return 'tasks';
    }

    //returns columns in db
    public function attributes(): array
    {
        return [
            'task_name',
            'proj_id',
            'description',
            'budget',
        ];
    }

    //returns primaryKey in db
    public function primaryKey(): string
    {
        return 'id';
    }

    //calls parent method save that takes care of saving data in db
    public function save(): bool
    {

        $this->proj_id = (int)$this->proj_id;
        $this->budget = (int) $this->budget;
        return parent::save();

    }




    public function relationTables(): array
    {
        // TODO: Implement userType() method.
    }
    public function userType(): string
    {
        // TODO: Implement userType() method.
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
    }
}