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

    abstract public function primaryKey(): string;

    abstract public function userType(): string;


    public function all()
    {
        $tableName = static::tableName();

        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();
        return $statement->fetchAll();

    }
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

    public function update($id)
    {
        try {
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $primaryKey = $this->primaryKey();
            $partSql = implode(',', array_map(fn($attr) => "$attr = :$attr", $attributes));

            //UPDATE $tablename SET dep_name = :dep_name, status = :status WHERE id=$id

            $statement = self::prepare("UPDATE $tableName SET $partSql WHERE $primaryKey = $id");
            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
            $statement->execute();
        }catch (\PDOException $e){
            echo "The record could not be updated. Error: " . $e->getMessage();
        }
    }

    public function deleteById($id)
    {
        try {
            $tableName = static::tableName();
            $primaryKey = static::primaryKey();

            //DELETE FROM $tableName WHERE id = :id

            $statement = self::prepare("DELETE FROM $tableName WHERE $primaryKey = $id");
            return $statement->execute();
        }catch (\PDOException $e){
            echo "The record could not be deleted. Error: " . $e->getMessage();
            return false;
        }
    }

    public function findOneRecord(array $where)
    {
        /* $where will look sth like  ['email' => name@example.com, 'names' => John Doe] etc  */
        $tableName = static::tableName();
        $attributes = array_keys($where);

        $partSql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        //SELECT * FROM $tableName WHERE email = :email AND names = :names

        $statement = self::prepare("SELECT * FROM $tableName WHERE $partSql");

        foreach ($where as $key => $value)
        {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();

        return $statement->fetchObject(static::class);
        /*
         * A static class is passed to the fetchObject to pass the class from which the method was called from
         * In this case UserModel
         */

    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

}