<?php
include("./connection.php");
$conn = connection();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM tb_student WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Student not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid request.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student ID Card</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e9f0f7;
    }
    .id-card {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 40px;
      position: relative;
      overflow: hidden;
    }
    .id-card h3 {
      font-weight: 700;
      color: #0077cc;
      margin-bottom: 30px;
      text-align: center;
    }
    .id-photo {
      border-radius: 50%;
      border: 5px solid #00c4cc;
      width: 150px;
      height: 150px;
      object-fit: cover;
    }
    .label {
      font-weight: 600;
      color: #333;
    }
    .value {
      color: #222;
    }
    .highlight {
      color: #0077cc;
    }
    .barcode {
      height: 50px;
      background: repeating-linear-gradient(
        90deg,
        #000,
        #000 2px,
        #fff 2px,
        #fff 4px
      );
      margin-top: 20px;
    }
    .corner-banner {
      position: absolute;
      top: 0;
      right: 0;
      background-color: #0077cc;
      color: white;
      padding: 15px 20px;
      font-size: 14px;
      font-weight: bold;
      border-bottom-left-radius: 20px;
    }
  </style>
</head>
<body>

<div class="id-card mt-5">
  <div class="corner-banner">
    ROYAL UNIVERSITY OF PP
  </div>
  <h3>STUDENT ID CARD</h3>
  <div class="row align-items-center">
    <div class="col-md-4 text-center">
      <img src="uploads/<?php echo $row['image']; ?>" alt="Student Photo" class="id-photo mb-3">
    </div>
    <div class="col-md-8">
      <p><span class="label">NAME:</span> <span class="value"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></span></p>
      <p><span class="label">STUDENT ID:</span> <span class="value">GU-<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?></span></p>
      <p><span class="label">PROGRAM:</span> <span class="value">Bachelor of Science in Computer Science</span></p>
      <p><span class="label">DATE OF BIRTH:</span> <span class="value"><?php echo date("F d, Y", strtotime($row['dob'])); ?></span></p>
    </div>
  </div>
  <div class="barcode"></div>
</div>

</body>
</html>
