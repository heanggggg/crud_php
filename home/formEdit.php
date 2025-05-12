<?php
include("../connection.php");

if (!isset($_GET['id'])) {
    echo "No ID specified.";
    exit;
}
$conn = connection();
$id = intval($_GET['id']);
$query = "SELECT * FROM tb_student WHERE id = $id";
$result = $conn->query($query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Student not found.";
    exit;
}

$row = mysqli_fetch_assoc($result);
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  .form-label { font-weight: bold; }
  .required::after { content: " *"; color: red; }
</style>

<div class="container mt-5">
    <h3 class="mb-4 text-warning">Edit Employee</h3>
    <div class="p-4 border rounded shadow-sm">
        <form method="POST" action="editProcess.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label required">First Name</label>
                    <input type="text" name="first_name" required class="form-control" id="first_name"
                        value="<?php echo $row['first_name']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label required">Last Name</label>
                    <input type="text" name="last_name" required class="form-control" id="last_name"
                        value="<?php echo $row['last_name']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="gender" class="form-label required">Gender</label>
                    <select class="form-select" required name="gender" id="gender">
                        <option value="">Select gender</option>
                        <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" required name="email" class="form-control" id="email"
                        value="<?php echo $row['email']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="dob" class="form-label required">Date of Birth</label>
                    <input type="date" required name="dob" class="form-control" id="dob"
                        value="<?php echo $row['dob']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label required">Address</label>
                    <input type="text" required name="address" class="form-control" id="address"
                        value="<?php echo $row['address']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="image" class="form-label">Upload New Image</label>
                    <input class="form-control" type="file" accept="image/*" id="image" name="image">
                    <div class="mt-2">
                        <img src="./uploads/<?php echo $row['image']; ?>" width="80" class="rounded border" alt="Current Image">
                        <input type="hidden" name="old_image" value="<?php echo $row['image']; ?>">
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center mt-4">
                    <div class="form-check">
                        <input type="checkbox" name="active" class="form-check-input" id="active"
                            <?php if ($row['active']) echo 'checked'; ?>>
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-warning px-4">Update</button>
            <a href="home.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
