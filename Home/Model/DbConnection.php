<?php

// Define a class for handling database connections
class DbConnection
{
    // Database connection parameters
    public $host = "localhost";
    public $port = 3306;
    public $dbname = "homefinder";
    public $user = "root";
    public $pass = "";

    // PDO connection object
    public $conn;

    /**
     * Database Connection Constructor
     */
    public function __construct(){

        try {
            // Set up the Data Source Name (DSN) for PDO
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";

            // Set PDO options for error handling and result fetching
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );

            // Create a new PDO instance with the specified parameters
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            // Handle any exceptions that occur during the connection attempt
            echo 'Cannot connect to database server: ' . $e->getMessage();
            exit;
        }
    }
}
