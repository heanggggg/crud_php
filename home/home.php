<?php
include("../connection.php");

// Number of records per page
$limit = 5;
$conn = connection();
// Get the current page number, defaulting to 1 if not set
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the starting record for the query
$start = ($page - 1) * $limit;

// Get the search term from the form (if any)
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Build the query with the search filter
$sql_query = "SELECT * FROM tb_student WHERE 
              first_name LIKE '%$search%' OR 
              last_name LIKE '%$search%' OR 
              gender LIKE '%$search%' OR 
              email LIKE '%$search%' OR 
              address LIKE '%$search%' 
              LIMIT $start, $limit";

// Get total number of records for pagination (apply search filter here too)
$total_result = $conn->query("SELECT COUNT(*) AS total FROM tb_student WHERE 
                             first_name LIKE '%$search%' OR 
                             last_name LIKE '%$search%' OR 
                             gender LIKE '%$search%' OR 
                             email LIKE '%$search%' OR 
                             address LIKE '%$search%'");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

$result = $conn->query($sql_query);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .custom-badge {
    padding: 5px 12px;
    border-radius: 5px;
    font-weight: 600;
    color: #d63384;
    border: 1px solid #f3c6d3;
    background-color: #fdf0f5;
    font-family: 'Segoe UI', sans-serif;
    font-size: 0.85rem;
  }
  .customs-badge {
    padding: 5px 12px;
    border-radius: 5px;
    font-weight: 600;
    color: rgb(31, 177, 56);
    border: 1px solid rgb(8, 207, 105);
    background-color: rgb(223, 249, 233);
    font-family: 'Segoe UI', sans-serif;
    font-size: 0.85rem;
  }
  .table-rounded {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
  }

  .table thead th {
    background-color: #e3f2fd;
    font-weight: 600;
    color: #333;
  }

  .table td, .table th {
    vertical-align: middle;
  }
</style>

<div class="container mt-5">
  <h1 class="mb-4 fw-bold">Student List</h1>
  <hr>
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <!-- Left side -->
    <div class="d-flex flex-wrap align-items-center">
      <form method="GET" class="d-flex me-3 mb-2 mb-sm-0">
        <input type="text" class="form-control me-2" name="search" value="<?php echo $search; ?>" placeholder="Search...">
        <button class="btn btn-primary" type="submit">
          <i class="fa fa-search"></i>
        </button>
      </form>
      <a href="addForm.php" class="btn btn-primary fw-semibold mb-2 mb-sm-0">
        <i class="fa-solid fa-user-tie me-2"></i> Add New Student
      </a>
    </div>
    <div class="mt-2 mt-sm-0">
      <a href="about.php" class="btn btn-outline-secondary">
        <i class="fa fa-info-circle me-2"></i> About
      </a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle text-center">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Image</th>
          <th>Gender</th>
          <th>Email</th>
          <th>Date of Birth</th>
          <th>Address</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            
            <td>
              <img src="./uploads/<?php echo $row['image']; ?>" alt="Employee Image" width="45" height="45" class="rounded-circle border border-secondary shadow-sm">
            </td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['dob']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td>
              <?php
                echo $row['active'] == 1
                  ? '<span class="customs-badge">Active</span>'
                  : '<span class="custom-badge">Stopped Learn</span>';
              ?>
            </td>
            <td>
              <a href="viewStudent.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success btn-sm">
                <i class="fa-regular fa-eye"></i>
              </a>
              <a href="formEdit.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-warning btn-sm">
                <i class="fa-solid fa-pen-to-square"></i>
              </a>
              <a href="delete.php?id=<?php echo $row['id']; ?>"class="btn btn-outline-danger btn-sm">
                <i class="fa-solid fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-end me-5">
        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
          <a class="page-link" href="?search=<?php echo $search; ?>&page=<?php echo $page - 1; ?>">Previous</a>
        </li>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
          <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
            <a class="page-link" href="?search=<?php echo $search; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>

        <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
          <a class="page-link" href="?search=<?php echo $search; ?>&page=<?php echo $page + 1; ?>">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</div>

<?php
// Free up memory and close the database connection
$conn->close();
mysqli_free_result($result);
?>
