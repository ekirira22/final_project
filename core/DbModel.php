<?php


namespace app\core;
/*
 * Class DbModel
 * This class will be responsible for mapping, it will do object-relational mapping
 * Here, we will map the e.g usersclass into db table. The aim of this class is to create reusable methods
 */

/*
 * This will be a base active record class for mapping data into database
 */

abstract class DbModel extends Model
{

    /*
     * Abstract functions that must be defined for all classes that extend to DbModel
     */

    abstract public function tableName() : string;

    abstract public function attributes() : array;


    public function save(): bool
    {
        try {
            $tableName = $this->tableName();
            $attributes = $this->attributes();

            $params = array_map(fn($attr) => ":$attr", $attributes );

            $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
                    VALUES (".implode(',', $params).")");

            foreach ($attributes as $attribute)
            {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }

            $statement->execute();

        } catch (\PDOException $e){
            echo "The record could not be saved. Error: " . $e->getMessage();
        }

        return true;
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

}