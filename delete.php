<?php
include("./connection.php");
$conn = connection();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]); 
    $sql = "UPDATE tb_student SET active=0 WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo '
        <html>
        <head>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    title: "Deleted!",
                    text: "Student has been deactivated successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "index.php";
                });
            </script>
        </body>
        </html>';
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "ID parameter missing.";
}

$conn->close();
