<?php
include("./connection.php");
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  .form-label {
    font-weight: bold;
  }
  .required::after {
    content: " *";
    color: red;
  }
</style>

<div class="container mt-5">
    <h3 class="mb-4 text-primary">Add New Employee</h3>
    <div class="p-4 border rounded shadow-sm">
        <form method="POST" action="addProcess.php" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label required">First Name</label>
                    <input type="text" name="first_name" required class="form-control" id="first_name" placeholder="Enter first name">
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label required">Last Name</label>
                    <input type="text" name="last_name" required class="form-control" id="last_name" placeholder="Enter last name">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="gender" class="form-label required">Gender</label>
                    <select class="form-select" required name="gender" id="gender">
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" required name="email" class="form-control" id="email" placeholder="example@gmail.com">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="dob" class="form-label required">Date of Birth</label>
                    <input type="date" required name="dob" class="form-control" id="dob">
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label required">Address</label>
                    <input type="text" required name="address" class="form-control" id="address" placeholder="Street, home number, city, country">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="image" class="form-label required">Upload Image</label>
                    <input class="form-control" type="file" accept="image/*" id="image" name="image" required>
                </div>
                <div class="col-md-6 d-flex align-items-center mt-4">
                    <div class="form-check">
                        <input type="checkbox" name="active" class="form-check-input" id="active">
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4">Submit</button>
        </form>
    </div>
</div>
