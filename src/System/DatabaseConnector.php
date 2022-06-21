<?php
namespace Src\System;

class DatabaseConnector {

    private $dbConnection = null;

    public function __construct()
    {
        $host = $_SERVER['DB_HOST'];
        $db   = $_SERVER['DB_DATABASE'];
        $user = $_SERVER['DB_USERNAME'];
        $pass = $_SERVER['DB_PASSWORD'];
        
        define("MYSQL_CONN_ERROR", "Unable to connect to database.");
        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $this->dbConnection = new \mysqli($host, $user, $pass, $db);
        } catch (\mysqli_sql_exception $e) {
            throw $e;
        }
       
    }

    public function getConnection()
    {
        return $this->dbConnection;
    }
}
?>