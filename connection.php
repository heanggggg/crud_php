<?php
function connection() {
    $host = "localhost";
    $username = "root";
    $password = ""; // Leave empty if no password
    $database = "db_crud";

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
