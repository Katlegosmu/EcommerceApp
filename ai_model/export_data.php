<?php
include 'db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="user_interactions.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['user_id', 'product_id', 'interaction_type']);

$query = "SELECT user_id, product_id, interaction_type FROM user_interactions";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

fclose($output);
?>
