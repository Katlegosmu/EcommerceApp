<?php

/**
 * Database class for handling database connections
 */
class Database
{
    // Database connection object
    private $con;

    /**
     * Method to establish a connection to the database
     * @return mysqli The database connection object
     */
    public function connect(){
        // Create a new Mysqli object to connect to the database
        // Parameters: host, username, password, database name
        $this->con = new Mysqli("localhost", "root", "", "ecommerce_db");

        // Return the database connection object
        return $this->con;
    }
}

?>
