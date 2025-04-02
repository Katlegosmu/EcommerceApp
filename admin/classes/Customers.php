<?php 
session_start();
require_once("Database.php");

class Customers {
    private $con;

    public function __construct() {
        $db = new Database();
        $this->con = $db->connect();
    }

    // Get all customers
    public function getCustomers() {
        try {
            $stmt = $this->con->prepare("SELECT `user_id`, `first_name`, `last_name`, `email`, `mobile`, `address1`, `address2` FROM `user_info`");
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $customers = $result->fetch_all(MYSQLI_ASSOC);
                return ['status' => 200, 'message' => $customers];
            }
            return ['status' => 404, 'message' => 'No customer data found'];
        } catch (Exception $e) {
            return ['status' => 500, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    // Get customer orders
    public function getCustomersOrder() {
        try {
            $stmt = $this->con->prepare("
                SELECT o.order_id, o.product_id, o.qty, o.trx_id, o.p_status, 
                       p.product_title, p.product_image 
                FROM orders o 
                JOIN products p ON o.product_id = p.product_id
            ");
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $orders = $result->fetch_all(MYSQLI_ASSOC);
                return ['status' => 200, 'message' => $orders];
            }
            return ['status' => 404, 'message' => 'No orders found'];
        } catch (Exception $e) {
            return ['status' => 500, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
}

// Handle AJAX requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['admin_id'])) {
        echo json_encode(['status' => 403, 'message' => 'Unauthorized access']);
        exit();
    }

    $customerObj = new Customers();

    if (isset($_POST["GET_CUSTOMERS"])) {
        echo json_encode($customerObj->getCustomers());
        exit();
    }

    if (isset($_POST["GET_CUSTOMER_ORDERS"])) {
        echo json_encode($customerObj->getCustomersOrder());
        exit();
    }
}

?>
