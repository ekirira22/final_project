<?php

/* This will be the parent database class that will be use to create a connection to the
*immediately application is instantiated
*/
namespace app\core;

/*
 * Public function Database
 */
class Database
{
    /*
     * Class property $pdo of type PDO
     */
    public \PDO $pdo;

    public function __construct(array $config)
    {
        /*
         * NB: When instantiating the class Database in Application constructor, we passed an array config to Database
         * that contains the database configurables. We can only access then in this class constructor
         */
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $pass = $config['password'] ?? '';

        /*
         * Creates a new pdo connection
         */
        $this->pdo = new \PDO($dsn, $user, $pass);
        //we set the default pdo attribute error mode to error mode exception, meaning errors
        //are outputted in case of any bad connection
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /*
     * Public function prepare the basically calls pdo method prepare that accepts an sql statement and
     * prepares it for execution
     */

    public function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }



}