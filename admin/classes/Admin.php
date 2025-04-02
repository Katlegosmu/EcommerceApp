<?php

/**
 * Admin class for handling admin-related operations
 */
class Admin
{
    // Database connection object
    private $con;

    // Constructor to initialize the database connection
    function __construct()
    {
        // Include the Database class to establish a connection
        include_once("Database.php");
        $db = new Database();  // Create a new Database object
        $this->con = $db->connect();  // Assign the database connection to $con
    }

    /**
     * Method to fetch the list of admins from the database
     * @return array The response status and admin list or an error message
     */
    public function getAdminList(){
        // Query to select id, name, email, and is_active columns from the admin table
        $query = $this->con->query("SELECT `id`, `name`, `email`, `is_active` FROM `admin` WHERE 1");

        // Array to hold the results
        $ar = [];
        
        // Check if any rows are returned
        if ($query->num_rows > 0) {
            // Fetch each row and add it to the array
            while ($row = $query->fetch_assoc()) {
                $ar[] = $row;
            }
            // Return a response with status 202 (successful) and the admin data
            return ['status'=> 202, 'message'=> $ar];
        }
        
        // If no admin data is found, return a response with status 303 (error) and message 'No Admin'
        return ['status'=> 303, 'message'=> 'No Admin'];
    }
}

// Check if the GET_ADMIN POST request is set
if (isset($_POST['GET_ADMIN'])) {
    // Create a new Admin object
    $a = new Admin();
    // Call the getAdminList method and return the result as JSON
    echo json_encode($a->getAdminList());
    exit();  // Stop the script execution after responding
}

?>
