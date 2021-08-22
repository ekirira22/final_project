<?php


namespace app\models;
/*
 * This class, will render the UserActivity DB Table information in order for methods to be called
 * statically here so data can be fetched using the DbModel
 */


use app\core\DbModel;

class ActivityModel extends DbModel
{

    /*
     * we declare classes in the table user_activity
     */
    public string $staff_id = '';
    public string $user_type = '';
    public string $description = '';



    public function tableName(): string
    {
        return 'user_activity';
    }

    public function attributes(): array
    {
        return [
            'staff_id', 'user_type', 'description'
        ];
    }

    public function primaryKey(): string
    {
        return 'id';
    }


    public function relationTables(): array
    {
        return ['staff', 'departments'];
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