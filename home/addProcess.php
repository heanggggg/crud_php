<?php
include("../connection.php");


$conn = connection();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    $address = $_POST["address"];
    $active = isset($_POST["active"]) ? 1 : 0;
    $targetDir = "uploads/"; 
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); 
    }

    $fileName = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];

    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $stmt = $conn->prepare("INSERT INTO tb_student (first_name, last_name, gender, email, dob, address, image, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssi", $first_name, $last_name, $gender, $email, $dob, $address, $fileName, $active);
            if ($stmt->execute()) {
               header("Location:home.php");
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "File upload failed.";
        }
    } else {
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
    }
}

$conn->close();
?>
