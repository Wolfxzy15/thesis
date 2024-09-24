<?php
include 'db.php'; // This should contain your database connection

// Prepare and execute the query
$sql = "SELECT SUM(num_members) AS total_members FROM tbl_families WHERE evacID = 1";
$result = mysqli_query($conn, $sql);

// Check if the query was successful and return the sum
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo $row['total_members'];
} 

// Close the database connection
mysqli_close($conn);
?>
