<?php


namespace app\core;
/*
 * Class DbModel
 * This class will be responsible for mapping, it will do object-relational mapping and directly interact with the
 * database for CRUD functionality. Here we will create one time functions that will be called either statically
 * or through instantiating classes
 * Here, we will map the e.g users class into db table. The aim of this class is to create reusable methods
 */

/*
 * This will be a base active record class for mapping data into database
 */

abstract class DbModel extends Model
{

    /*
     * Abstract functions that must be defined for all classes that extend to DbModel in order to model
     * the tableNames, attributes and primaryKeys specific to that Model extendiing to this class
     */

    abstract public function tableName() : string;

    abstract public function attributes() : array;

    abstract public function primaryKey(): string;

    abstract public function userType(): string;

    /*
     * Public function all() that has to be called statically through the intended Model class
     * we pass it through a function prepare which is a static function of this class(DbModel)
     * it prepares the statement via pdo(php data objects) for execution
     * It is then executed and returns an array through fetchAll that returns everything in that table(tableName)
     */

    public function all()
    {
        $tableName = static::tableName();

        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();
        return $statement->fetchAll();

    }

    public function findAllWhere(array $where) //where will be associative Eg. ['status' => 'approved', 'user_type' => 'staff' ]
    {


        $tableName = static::tableName();
        $attributes = array_keys($where);
        //SELECT * FROM $tableName WHERE status = :status AND user_type = :user_type

        $attr = array_map(fn($attr) => "$attr = :$attr", $attributes);
        $partSql = implode(" AND ", $attr);

        $statement = self::prepare("SELECT * FROM $tableName WHERE $partSql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchAll();
    }

    /*
     * Public function save() where the model class calling this function has to be instantiated
     * i.e cannot be called statically since it won't read $this->tableName()
     */

    public function save(): bool
    {
        try {
            /*
             * We read the tableName and the attributes specific to the active model that extends to this class
             * and store them in variables
             */
            $tableName = $this->tableName();
            $attributes = $this->attributes();

            /*
             * The $attributes var will be an array, therefore we need to use this attributes twice, first: for the
             * database column names and for the values that will take typed parameters
             * Eg. if attributes look like this ['names', 'id_number', mobile_no'] etc
             * array_map loops through all array values and adds a colon in front of all attributes
             * [':names', ':id_number', ':mobile_no'] and stores the values in $params
             */

            $params = array_map(fn($attr) => ":$attr", $attributes );

            /*
             * implode on the other hand accepts two parameters, a separator and an array. implode function loops
             * through all the array values and puts a separator between them, if an array only has one value, nothing
             * happens, Eg. ==> $tableName(names, id_number, mobile_no) etc
             * We then implode through the $params Eg. ==> VALUES(:names, :mobile_no, :mobile_no) etc
             */

            $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
                    VALUES (".implode(',', $params).")");

            /*
             * Attributes can be many, so we loops through each attribute and bind it to its respective value
             * Since all the data has to be loaded before saving, the model properties are loaded with user input
             * We therefore bind each typed param attribute Eg :names to the user value in the model property
             * $this->{$attribute} == $this->names and so on
             */

            foreach ($attributes as $attribute)
            {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }

            /*
             * We then execute and save
             */

            $statement->execute();

        } catch (\PDOException $e){
            //If the above doesn't execute, through the try catch statement, catch posts the error in the 'failed' flash message
            Application::$app->session->setFlashMessage('failed', 'The record could not be saved. Error: ' . $e->getMessage());
        }

        /*
         * This function returns a bool value since we are not fetching anything
         */

        return true;
    }

        /*
         * Public function update() that accepts an id where the model class calling this function has to be instantiated
         * i.e cannot be called statically since it won't read $this->tableName() or $this->attributes()
         */
    public function update($id): bool
    {
        //We put it into a try catch statement
        try {
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $primaryKey = $this->primaryKey();

            /*
             * In this case SQL should look sth like E.g UPDATE $tablename SET dep_name = :dep_name, status = :status WHERE id=$id
             * Between SET AND WHERE we see a common pattern that can be refactored
             * We need to take an attr like dep_name and change it to dep_name = :dep_name (typed parameter)
             * We achieve this just like in save function using the array_map, if the attr are moore than one
             * We implode through each and add a separator. Eg, dep_name = :dep_name, status = :status
             * We then store it in a variable $partSql
             */

            $partSql = implode(',', array_map(fn($attr) => "$attr = :$attr", $attributes));

            /*
             * We prepare the statement by passing the whole statement in static function prepare
             * and store the result in statement
             */

            $statement = self::prepare("UPDATE $tableName SET $partSql WHERE $primaryKey = $id");

            /*
             * Loop and bind the value to the respective typed parameter attribute
             */

            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }

           $statement->execute();

        }catch (\PDOException $e){
            //If the above doesn't execute, through the try catch statement, catch posts the error in the 'failed' flash message
            Application::$app->session->setFlashMessage('failed', 'Please input the data correctly: ' . $e->getMessage());
        }

        /*
        * This function returns a bool value since we are not fetching anything
        */
        return true;
    }

    /*
     * Public function findById() that accepts $id parameter which has to be gotten via
     * GET method and has to be called statically through the active Model class
     * we pass it through a function prepare which is a static function of this class(DbModel)
     * it prepares the statement via pdo(php data objects) for execution
     */

    public static function findById($id)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE id = $id");
        $statement->execute();

        /*
         * This time we want an object of the data fetched from the database since we are looking at one record
         * where id = $id, so we fetch an object and pass static::class as an argument, i.e the class it was
         * statically called from, the returned object becomes an object of that class
         */
        return $statement->fetchObject(static::class);
    }

    /*
     * Public function deleteById() that is also called statically and accepts $id from GET
     * It accepts the tablename and id of the table we are deleting from, prepares the statement
     * and executes
     */

    public function deleteById($id)
    {
        try {
            $tableName = static::tableName();
            $primaryKey = static::primaryKey();

            //DELETE FROM $tableName WHERE id = :id

            $statement = self::prepare("DELETE FROM $tableName WHERE $primaryKey = $id");


            return $statement->execute();

        }catch (\PDOException $e){
            //if an error occurs, display flash message
            Application::$app->session->setFlashMessage('failed', 'The record could not be deleted. Error: ' . $e->getMessage());
            Application::$app->response->redirect('/' . $tableName);
            /*
             * This function returns a bool value since we are not fetching anything
             */
            return false;
        }
    }

    /*
     * Public function findOneRecord() that has to be called statically and accept array
     * that is an associative array the give the attribute and value E.g ['email' => $this->email]
     */

    public function findOneRecord(array $where)
    {
        /* $where will look sth like  ['email' => name@example.com, 'names' => John Doe] etc  */
        $tableName = static::tableName();

        /* We take the array keys using array_keys to get in this case email to get the attributes*/
        $attributes = array_keys($where);

        /*
         * If SQL looks something like //SELECT * FROM $tableName WHERE email = :email AND names = :names
         * We can see a pattern after WHERE
         * We use array_map to ad = : between tha attributes
         * We then implode through the result and add the separator AND
         */
        $partSql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));


        $statement = self::prepare("SELECT * FROM $tableName WHERE $partSql");

        /*
         * Loop and bind the value to the respective typed parameter attribute
         */
        foreach ($where as $key => $value)
        {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();

        return $statement->fetchObject(static::class);
        /*
         * A static class is passed to the fetchObject to pass the class from which the method was called from
         */

    }

    /**
     * Fetch all resources from database with relations
     * @param array $foreignKeys
     * @return array
     */

    /*
     * Public method fetchWithRelation() that accepts an array of foreign keys in which
     * we want to join and return an array of the related tables
     * Has to be called statically too
     * This function has to be re-usable, whether for one or multiple foreign keys
     */

    public function fetchWithRelation(array $foreignKeys): array //['staff_id', dep_id, sub_id, year_id]
    {
        $tableName = static::tableName();
        $primaryKey = static::primaryKey();
        $rel_tables = static::relationTables(); //departments, sub_counties, financial_years (receive the columns)

        /*
         * We want to select all projects and join the tables that the tableName relates to E.g for projects should look
         * SELECT *, projects.id FROM projects JOIN staff ON staff_id = staff.id JOIN
         * departments ON dep_id = departments.id JOIN sub_counties ON sub_id = sub_counties.id
         * ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
         * SELECT *, projects.id FROM projects JOIN staff ON :staff = staff.id JOIN
         * departments ON :departments = departments.id JOIN sub_counties ON :sub_counties = sub_counties.id
         * Above is a pattern we can refactor using array_map and implode
         */
         //array_map(fn($attr) => "$attr ON :$attr = $attr.$primaryKey", $attributes);

        /*
         * We implode and use JOIN as a separator
         */
        $partSql = implode(" JOIN ", array_map(fn($attr) => "$attr ON :$attr = $attr.$primaryKey", $rel_tables));
        /*
         * We want to replace eg :department with the respective foreign keys passed above
         */
        $attr_replace = array_map(fn($attr) => ":$attr", $rel_tables);
        $sql = str_replace($attr_replace, $foreignKeys, $partSql);

        $statement = self::prepare("SELECT *, $tableName.$primaryKey FROM $tableName JOIN $sql ORDER BY $tableName.id DESC");

        $statement->execute();

        return $statement->fetchAll();
        //Returns the fetched array with all the joined tables

    }

    /*
     * Public method fetchByIdWithRelation() that accepts an id and an array of foreign keys in which
     * we want to join and return an object of the results. It works just like the function above
     * Only difference is that it checks where $tableNames id = id passed as a param
     * Has to be called statically too
     * This function also has to be re-usable, whether for one or multiple foreign keys
     */

    public function fetchByIdWithRelation($id, array $foreignKeys)
    {
        $tableName = static::tableName();
        $rel_tables = static::relationTables();
        $primaryKey = static::primaryKey();

        /*For Example
         * SELECT *, projects.id FROM projects JOIN
         * departments ON dep_id = departments.id JOIN sub_counties ON sub_id = sub_counties.id
         * JOIN financial_years ON year_id = financial_years.id WHERE projects.id = $id
         *
         * departments ON :departments = departments.id JOIN sub_counties ON :sub_counties = sub_counties.id
         * JOIN financial_years ON :financial_years = financial_years.id WHERE projects.id = $id
         */
        $partSql = implode(" JOIN ", array_map(fn($attr) => "$attr ON :$attr = $attr.$primaryKey", $rel_tables));
        //var_dump($partSql);
        /*
         * We want to replace eg :department with the respective foreign keys passed above, we can think
         * of it as binding values
         */
        $attr_replace = array_map(fn($attr) => ":$attr", $rel_tables);
        $sql = str_replace($attr_replace, $foreignKeys, $partSql);

        $statement = self::prepare("SELECT *, $tableName.$primaryKey FROM $tableName JOIN $sql WHERE $tableName.$primaryKey = $id");

        $statement->execute();

        return $statement->fetchObject(static::class);

    }

    public function fetchWithRelationWhere($where, array $foreignKeys) //where will be associative Eg. ['status' => 'approved', 'user_type' => 'staff' ]
    {
        /*
         * We repeat as fetchWithRelation function only with $where assoc array
         */
        $tableName = static::tableName();
        $primaryKey = static::primaryKey();
        $rel_tables = static::relationTables(); //departments, sub_counties, financial_years (receive the columns)

        /*
         * SELECT *, staff.id FROM staff JOIN
         * departments ON :departments = departments.id WHERE status => 'approved' AND user_type => 'staff
         * Above is a pattern we can refactor using array_map and implode
         */
        //array_map(fn($attr) => "$attr ON :$attr = $attr.$primaryKey", $attributes);

        /*
         * We implode and use JOIN as a separator
         */
        $partSql = implode(" JOIN ", array_map(fn($attr) => "$attr ON :$attr = $attr.$primaryKey", $rel_tables));
        /*
         * We want to replace eg :department with the respective foreign keys passed above
         */
        $attr_replace = array_map(fn($attr) => ":$attr", $rel_tables);
        $sql = str_replace($attr_replace, $foreignKeys, $partSql);

        //$statement = self::prepare( "SELECT *, $tableName.$primaryKey FROM $tableName JOIN $sql WHERE $where $sql ");

        /*
         * For the Where clause
         * WHERE status = :status AND user_type = :user_type
         */

        $attributes = array_keys($where);
        $whereSql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT *, $tableName.$primaryKey FROM $tableName JOIN $sql WHERE $whereSql");
        //Bind the Values
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();

        return $statement->fetchAll();
        //Returns the fetched array with all the joined tables
    }

    public function fetchBySearchWithRelation($search, $columns,  $foreignKeys) :array
    {
        $tableName = static::tableName();
        $rel_tables = static::relationTables();
        $primaryKey = static::primaryKey();

        /*
         * SELECT *, project.id FROM projects JOIN
         * departments ON dep_id = departments.id JOIN sub_counties ON sub_id = sub_counties.id
         * JOIN financial_years ON year_id = financial_years.id WHERE CONCAT(project_name, dep_name, sub_name) LIKE '%$search%'
         */

        $partSql = implode(" JOIN ", array_map(fn($attr) => "$attr ON :$attr = $attr.$primaryKey", $rel_tables));
        /*
         * Bind the values by replacing
         */
        $attr_replace = array_map(fn($attr) => ":$attr", $rel_tables);
        /*
         * Take the columns to search from $columns and add a separator ','
         */
        $colums = implode(",", $columns);

        $sql = str_replace($attr_replace, $foreignKeys, $partSql);

        $statement = self::prepare("SELECT *, $tableName.$primaryKey FROM $tableName JOIN $sql WHERE CONCAT($colums) LIKE '%$search%' ORDER BY $tableName.id DESC");

        $statement->execute();

        return $statement->fetchAll();

    }

    public function fetchByFilterWithRelation($filter1, $filter2, $where, $foreignKeys) //$where E.g ['staff_id' => '81']
    {
        $tableName = static::tableName();
        $rel_tables = static::relationTables();
        $primaryKey = static::primaryKey();

        /*
         * For the Filtering of data it will look something like this
         * SELECT *, user_activity.id FROM user_activity JOIN
         * staff ON staff_id = staff.id JOIN departments ON dep_id = departments.id BETWEEN '$filter1' AND '$filter2'
         *
         */
        $partSql = implode(" JOIN ", array_map(fn($attr) => "$attr ON :$attr = $attr.$primaryKey", $rel_tables));
        /*
         * Bind the values by replacing
         */
        $attr_replace = array_map(fn($attr) => ":$attr", $rel_tables);

        //since we will need to reuse this class, we will use array keys and value to get where
        //we get the array_keys and values for the first elements [0]
        $col = array_keys($where); $val = array_values($where);

        $sql = str_replace($attr_replace, $foreignKeys, $partSql);

        //for the statement
        $statement = self::prepare("SELECT *, $tableName.$primaryKey FROM $tableName JOIN $sql WHERE $tableName.created_at
                                        BETWEEN '$filter1' AND '$filter2' AND $tableName.$col[0] = '$val[0]'");

        $statement->execute();

        return $statement->fetchAll();
    }


    public static function logUserActivity($description)
    {
        $id = (int)$_SESSION['user']['id'];
        $user_type = $_SESSION['user']['user_type'];
        $tableName = 'user_activity';
        $attributes = [
            'staff_id', 'user_type', 'description'
        ];
        $params = array_map(fn($attr) => ":$attr", $attributes);


        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
                    VALUES (".implode(',', $params).")");

        $statement->bindValue(':staff_id', $id);
        $statement->bindValue(':user_type', $user_type);
        $statement->bindValue(':description', $description);
        $statement->execute();

    }

    /*
     * Public function prepare that accepts an sql statement and passes it to pdo instantiated in Application class
     * and returns the result
     */

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

}







//CREATE TABLE departments
//( id INT PRIMARY KEY,
//  dep_name VARCHAR(50) NOT NULL,
//  status VARCHAR(25)
//);
//
//CREATE TABLE staff
//( id INT PRIMARY KEY,
//  names VARCHAR(50),
//  id_number VARCHAR(50),
//  mobile_number VARCHAR(50),
//  email VARCHAR(50),
//  password VARCHAR(50),
//  status VARCHAR(50),
//  user_type VARCHAR(50),
//  CONSTRAINT fk_dep_staff_id
//    FOREIGN KEY (id)
//    REFERENCES departments (id)
//    ON DELETE CASCADE  ON UPDATE CASCADE
//);

//ALTER TABLE staff
//ADD CONSTRAINT fk_name_id
//FOREIGN KEY (dep_id) REFERENCES departments(id)
//ON DELETE CASCADE  ON UPDATE CASCADE