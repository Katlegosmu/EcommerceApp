<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

$query = "INSERT INTO user_feedback (user_id, recommended_product_id, feedback) 
          VALUES (1, {$data->product_id}, '{$data->feedback}')";

mysqli_query($conn, $query);
?>
