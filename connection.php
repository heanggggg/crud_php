<?php
function connection() {
    $host = "sql101.infinityfree.com";
    $username = "if0_38981129";
    $password = "USt3BA1rJFvJR"; 
    $database = "if0_38981129_db_crud";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        echo "<script>alert('Connection failed: " . $conn->connect_error . "');</script>";
        exit;
    } else {
        // echo "<script>alert('Connected successfully!');</script>";
    }

    return $conn;
}
?>