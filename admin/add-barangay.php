<?php
include '../sql/sql.php';
session_start();

if(isset($_POST['save_barangay'])){
    try {
        // Add error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Validate connection
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        // Validate essential fields
        if (empty($_POST['barangay_name'])) {
            throw new Exception("Barangay name is required");
        }

        // Escape all input values to prevent SQL injection
        $barangay_name = $conn->real_escape_string($_POST['barangay_name']);
        $longitude = $conn->real_escape_string($_POST['longitude'] ?? '');
        $latitude = $conn->real_escape_string($_POST['latitude'] ?? '');

        // Direct SQL query
        $sql = "INSERT INTO barangay (
            barangay_name, longitude, latitude, created_at
        ) VALUES (
            '$barangay_name', '$longitude', '$latitude', NOW()
        )";

        // Execute query
        if($conn->query($sql)){
            $_SESSION['success'] = "Barangay added successfully";
            header("Location: add-barangay.php");
            exit();
        } else {
            throw new Exception("Error executing query: " . $conn->error);
        }

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: add-barangay.php");
        exit();
    }
}

// Handle delete action
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    try {
        $id = $conn->real_escape_string($_GET['id']);
        
        // Delete the barangay
        $sql = "DELETE FROM barangay WHERE id = '$id'";
        if($conn->query($sql)) {
            $_SESSION['success'] = "Barangay deleted successfully";
        } else {
            throw new Exception("Error deleting barangay");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    header("Location: add-barangay.php");
    exit();
}

// Handle edit action
if(isset($_POST['edit_barangay'])) {
    try {
        $id = $conn->real_escape_string($_POST['barangay_id']);
        
        // Escape all input values
        $barangay_name = $conn->real_escape_string($_POST['barangay_name']);
        $longitude = $conn->real_escape_string($_POST['longitude'] ?? '');
        $latitude = $conn->real_escape_string($_POST['latitude'] ?? '');

        // Update query
        $sql = "UPDATE barangay SET 
                barangay_name = '$barangay_name', 
                longitude = '$longitude', 
                latitude = '$latitude',
                updated_at = NOW()
                WHERE id = '$id'";

        if($conn->query($sql)) {
            $_SESSION['success'] = "Barangay updated successfully";
        } else {
            throw new Exception("Error updating barangay");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    header("Location: add-barangay.php");
    exit();
}

// Display messages if any
if(isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>".$_SESSION['success']."</div>";
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>".$_SESSION['error']."</div>";
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html >
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Admiro admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities."/>
    <meta name="keywords" content="admin template, Admiro admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app"/>
    <meta name="author" content="pixelstrap"/>
    <title>Resident</title>
    <!-- Favicon icon-->
    <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon"/>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet"/>
    <!-- Flag icon css -->
    <link rel="stylesheet" href="../assets/css/vendors/flag-icon.css"/>
    <!-- iconly-icon-->
    <link rel="stylesheet" href="../assets/css/iconly-icon.css"/>
    <link rel="stylesheet" href="../assets/css/bulk-style.css"/>
    <!-- iconly-icon-->
    <link rel="stylesheet" href="../assets/css/themify.css"/>
    <!--fontawesome-->
    <link rel="stylesheet" href="../assets/css/fontawesome-min.css"/>
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/weather-icons/weather-icons.min.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/scrollbar.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/slick-theme.css"/>
    <!-- App css -->
    <link rel="stylesheet" href="../assets/css/style.css"/>
    <link id="color" rel="stylesheet" href="../assets/css/color-1.css" media="screen"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/vendors/datatables.css">
  </head>
  <body>
    <!-- page-wrapper Start-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
      <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper"> 
      <?php include 'topbar.php'; ?>
      <!-- Page Body Start-->
        <!-- Page sidebar start-->
        <?php include 'sidebar.php'; ?>
        <!-- Page sidebar end-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-sm-6 col-12"> 
                  <h2>Barangay List</h2>
                </div>
                <div class="col-sm-6 col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                    <li class="breadcrumb-item">Barangay</li>
                    <li class="breadcrumb-item active">Add Barangay</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Barangay</h6>
                </div>
                <div class="card-body">
                    <div class="list-product-header">
                        <div> 
                            
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBarangayModal">
                                <i class="fa-solid fa-plus"></i>Add Barangay
                            </button>
                        </div>
                    </div>

                    <!-- Barangay Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="barangay-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Barangay Name</th>
                                    <th>Longitude</th>
                                    <th>Latitude</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM barangay ORDER BY created_at DESC";
                                $result = $conn->query($query);
                                
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . htmlspecialchars($row['barangay_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['longitude']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['latitude']) . "</td>";
                                        echo "<td>" . $row['created_at'] . "</td>";
                                        echo "<td>";
                                        echo "<div class='product-action'>";
                                        echo "<a href='#' data-bs-toggle='modal' data-bs-target='#editBarangayModal" . $row['id'] . "'>";
                                        echo "<svg><use href='../assets/svg/icon-sprite.svg#edit-content'></use></svg>";
                                        echo "</a>";
                                        echo "<a href='add-barangay.php?action=delete&id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this barangay?\")'>";
                                        echo "<svg><use href='../assets/svg/icon-sprite.svg#trash1'></use></svg>";
                                        echo "</a>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "</tr>";

                                        // Edit Modal for each barangay
                                        ?>
                                        <div class="modal fade" id="editBarangayModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Barangay</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editBarangayForm<?php echo $row['id']; ?>" action="add-barangay.php" method="POST">
                                                            <input type="hidden" name="barangay_id" value="<?php echo $row['id']; ?>">
                                                            <input type="hidden" name="edit_barangay" value="1">
                                                            
                                                            <div class="form-group">
                                                                <label for="barangay_name">Barangay Name</label>
                                                                <input type="text" name="barangay_name" class="form-control" value="<?php echo htmlspecialchars($row['barangay_name']); ?>" required>
                                                            </div>
                                                            
                                                            <div class="form-group mt-3">
                                                                <label for="longitude">Longitude</label>
                                                                <input type="text" name="longitude" class="form-control" value="<?php echo htmlspecialchars($row['longitude']); ?>">
                                                            </div>
                                                            
                                                            <div class="form-group mt-3">
                                                                <label for="latitude">Latitude</label>
                                                                <input type="text" name="latitude" class="form-control" value="<?php echo htmlspecialchars($row['latitude']); ?>">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" form="editBarangayForm<?php echo $row['id']; ?>" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No barangays found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Barangay Modal -->
                    <div class="modal fade" id="addBarangayModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Barangay</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addBarangayForm" action="add-barangay.php" method="POST">
                                        <div class="form-group">
                                            <label for="barangay_name">Barangay Name</label>
                                            <input type="text" name="barangay_name" class="form-control" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="longitude">Longitude</label>
                                            <input type="text" name="longitude" class="form-control">
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="latitude">Latitude</label>
                                            <input type="text" name="latitude" class="form-control">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="save_barangay" form="addBarangayForm" class="btn btn-primary">Save Barangay</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- jquery-->
    <script src="../assets/js/vendors/jquery/jquery.min.js"></script>
    <!-- bootstrap js-->
    <script src="../assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js" defer=""></script>
    <script src="../assets/js/vendors/bootstrap/dist/js/popper.min.js" defer=""></script>
    <!--fontawesome-->
    <script src="../assets/js/vendors/font-awesome/fontawesome-min.js"></script>
    <!-- feather-->
    <script src="../assets/js/vendors/feather-icon/feather.min.js"></script>
    <script src="../assets/js/vendors/feather-icon/custom-script.js"></script>
    <!-- sidebar -->
    <script src="../assets/js/sidebar.js"></script>
    <!-- height_equal-->
    <script src="../assets/js/height-equal.js"></script>
    <!-- config-->
    <script src="../assets/js/config.js"></script>
    <!-- apex-->
    <script src="../assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="../assets/js/chart/apex-chart/stock-prices.js"></script>
    <!-- scrollbar-->
    <script src="../assets/js/scrollbar/simplebar.js"></script>
    <script src="../assets/js/scrollbar/custom.js"></script>
    <!-- slick-->
    <script src="../assets/js/slick/slick.min.js"></script>
    <script src="../assets/js/slick/slick.js"></script>
    <!-- data_table-->
    <script src="../assets/js/js-datatables/datatables/jquery.dataTables.min.js"></script>
    <!-- page_datatable-->
    <script src="../assets/js/js-datatables/datatables/datatable.custom.js"></script>
    <!-- page_datatable1-->
    <script src="../assets/js/js-datatables/datatables/datatable.custom1.js"></script>
    <!-- page_datatable-->
    <script src="../assets/js/datatable/datatables/datatable.custom.js"></script>
    <!-- theme_customizer-->
    <!-- tilt-->
    <script src="../assets/js/animation/tilt/tilt.jquery.js"></script>
    <!-- page_tilt-->
    <script src="../assets/js/animation/tilt/tilt-custom.js"></script>
    <!-- dashboard_1-->
    <script src="../assets/js/dashboard/dashboard_1.js"></script>
    <!-- custom script -->
    <script src="../assets/js/script.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Keep only the sidebar toggle functionality
        const pageWrapper = document.querySelector('.page-wrapper');
        const toggleBtn = document.querySelector('.toggle-sidebar');
        
        function toggleSidebar() {
            pageWrapper.classList.toggle('sidebar-close');
            if(pageWrapper.classList.contains('sidebar-close')) {
                document.querySelector('.page-sidebar').style.width = '0';
                document.querySelector('.page-body').style.marginLeft = '0';
            } else {
                document.querySelector('.page-sidebar').style.width = '280px';
                document.querySelector('.page-body').style.marginLeft = '280px';
            }
        }

        if(toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }
    });
    </script>
    <style>
    .page-sidebar {
        width: 250px;
        position: fixed;
        background: white;
        height: 100%;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .page-body {
        margin-left: 250px;
        transition: all 0.3s ease;
    }

    .sidebar-close .page-body {
        margin-left: 0;
    }

    .sidebar-links {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .sidebar-link {
        padding: 12px 15px;
        display: block;
        color: #1e2f65;
        text-decoration: none;
    }

    .sidebar-submenu {
        padding-left: 15px;
        list-style: none;
    }

    .badge {
        float: right;
        margin-top: 4px;
    }

    .posts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .post-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.2s ease;
    }

    .post-card:hover {
        transform: translateY(-5px);
    }

    .post-image {
        height: 200px;
        overflow: hidden;
    }

    .post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f5f5;
        color: #666;
    }

    .post-content {
        padding: 15px;
    }

    .post-title {
        margin: 0 0 10px;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .post-desc {
        color: #666;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }

    .post-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .category, .priority {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        background: #f0f0f0;
    }

    .post-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .post-actions a {
        padding: 5px;
        border-radius: 4px;
        display: flex;
        align-items: center;
    }

    .post-actions svg {
        width: 20px;
        height: 20px;
    }

    .edit-btn:hover {
        background: #e3f2fd;
    }

    .delete-btn:hover {
        background: #ffebee;
    }

    .btn-sm {
        padding: 0.4rem;
        line-height: 1;
        border-radius: 4px;
    }

    .btn-sm i {
        font-size: 14px;
    }

    .d-flex.gap-2 {
        gap: 0.5rem !important;
    }

    .edit-btn {
        background-color: #28a745;
        border-color: #28a745;
    }

    .edit-btn:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .delete-btn {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .delete-btn:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .btn-sm i {
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .me-2 {
        margin-right: 0.5rem;
    }

    .table-responsive {
        margin-top: 1rem;
    }

    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }

    .list-product-header {
        margin-bottom: 1rem;
    }

    .edit-btn {
        color: #fff;
    }

    .delete-btn {
        color: #fff;
    }

    .table th {
        background-color: #f8f9fc;
        border-bottom: 2px solid #e3e6f0;
    }

    .table td {
        vertical-align: middle;
    }

    .product-action {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .product-action a {
        color: #1e2f65;
        transition: color 0.3s ease;
    }

    .product-action a:hover {
        color: #0d6efd;
    }

    .product-action svg {
        width: 20px;
        height: 20px;
    }
    </style>
    <script>
    $(document).ready(function() {
        $('#barangay-table').DataTable({
            "order": [[0, "desc"]], // Sort by first column (ID) in descending order
            "pageLength": 10,
            "responsive": true
        });
    });
    </script>
  </body>
</html>