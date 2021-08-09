<?php

/* This will be the parent databse class that will be use to create a connection to the
*immeadiatley application is instantiated
*/
namespace app\core;

class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $pass = $config['password'] ?? '';

        $this->pdo = new \PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }



}