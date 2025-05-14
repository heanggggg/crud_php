<?php
include("./connection.php");

$conn = connection();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id         = intval($_POST['id']);
$first_name = $_POST['first_name'];
$last_name  = $_POST['last_name'];
$gender     = $_POST['gender'];
$email      = $_POST['email'];
$dob        = $_POST['dob'];
$address    = $_POST['address'];
$active     = isset($_POST['active']) ? 1 : 0;
$old_image  = $_POST['old_image']; 

$new_image_name = $old_image;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file_tmp  = $_FILES['image']['tmp_name'];
    $file_name = time() . '_' . basename($_FILES['image']['name']);
    $target_dir = "./uploads/";
    $target_file = $target_dir . $file_name;
    if (move_uploaded_file($file_tmp, $target_file)) {
        $new_image_name = $file_name;
        if (file_exists($target_dir . $old_image)) {
            unlink($target_dir . $old_image);
        }
    }
}

$stmt = $conn->prepare("UPDATE tb_student SET first_name=?, last_name=?, gender=?, email=?, dob=?, address=?, image=?, active=? WHERE id=?");
$stmt->bind_param("sssssssii", $first_name, $last_name, $gender, $email, $dob, $address, $new_image_name, $active, $id);

if ($stmt->execute()) {
    echo '
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: "Success!",
                text: "Student record updated successfully.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "index.php";
            });
        </script>
    </body>
    </html>';
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
