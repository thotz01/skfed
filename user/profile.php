<?php
ob_start(); // Start output buffering
include '../sql/sql.php';
session_start();

// After session_start(), add this to fetch user data
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM residents WHERE id = '$user_id'";
$result = $conn->query($query);
$user_data = $result->fetch_assoc();

// Get profile image path
$profile_image = "../assets/images/profile.png"; // default image
if (!empty($user_data['profile_image'])) {
    $profile_image = "../uploads/" . $user_data['profile_image'];
}

// Add this script to handle messages
if(isset($_SESSION['success_message']) || isset($_SESSION['error_message']) || isset($_SESSION['info_message'])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            ";
            
    if(isset($_SESSION['success_message'])) {
        echo "Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '" . addslashes($_SESSION['success_message']) . "',
            timer: 2000,
            showConfirmButton: false
        });";
        unset($_SESSION['success_message']);
    }

    if(isset($_SESSION['error_message'])) {
        echo "Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '" . addslashes($_SESSION['error_message']) . "'
        });";
        unset($_SESSION['error_message']);
    }

    if(isset($_SESSION['info_message'])) {
        echo "Swal.fire({
            icon: 'info',
            title: 'Information',
            text: '" . addslashes($_SESSION['info_message']) . "',
            timer: 2000,
            showConfirmButton: false
        });";
        unset($_SESSION['info_message']);
    }

    echo "});
    </script>";
}

// Move the update handler here, after SweetAlert is loaded
if(isset($_POST['update_profile'])) {
    try {
        $updates = array();
        
        // Handle profile image upload first
        if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['profile_image']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            if(!in_array(strtolower($filetype), $allowed)) {
                throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed");
            }

            // Create uploads directory if it doesn't exist
            $upload_dir = '../uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Delete old profile image if exists
            if(!empty($user_data['profile_image'])) {
                $old_image = $upload_dir . $user_data['profile_image'];
                if(file_exists($old_image)) {
                    unlink($old_image);
                }
            }

            // Generate unique filename
            $new_filename = uniqid() . '.' . $filetype;
            $upload_path = $upload_dir . $new_filename;

            if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_path)) {
                $updates[] = "profile_image = '" . $conn->real_escape_string($new_filename) . "'";
            } else {
                throw new Exception("Failed to upload image");
            }
        }

        // Check each field for changes with trimmed values
        if(trim($user_data['username']) !== trim($_POST['username'])) {
            $updates[] = "username = '" . $conn->real_escape_string(trim($_POST['username'])) . "'";
        }
        if(trim($user_data['firstname']) !== trim($_POST['firstname'])) {
            $updates[] = "firstname = '" . $conn->real_escape_string(trim($_POST['firstname'])) . "'";
        }
        if(trim($user_data['middlename']) !== trim($_POST['middlename'])) {
            $updates[] = "middlename = '" . $conn->real_escape_string(trim($_POST['middlename'])) . "'";
        }
        if(trim($user_data['lastname']) !== trim($_POST['lastname'])) {
            $updates[] = "lastname = '" . $conn->real_escape_string(trim($_POST['lastname'])) . "'";
        }
        if(trim($user_data['email']) !== trim($_POST['email'])) {
            $updates[] = "email = '" . $conn->real_escape_string(trim($_POST['email'])) . "'";
        }
        if(trim($user_data['phone_number']) !== trim($_POST['phone_number'])) {
            $updates[] = "phone_number = '" . $conn->real_escape_string(trim($_POST['phone_number'])) . "'";
        }
        if(trim($user_data['barangay']) !== trim($_POST['barangay'])) {
            $updates[] = "barangay = '" . $conn->real_escape_string(trim($_POST['barangay'])) . "'";
        }
        if(trim($user_data['purok_zone']) !== trim($_POST['purok_zone'])) {
            $updates[] = "purok_zone = '" . $conn->real_escape_string(trim($_POST['purok_zone'])) . "'";
        }
        if(trim($user_data['city_municipality']) !== trim($_POST['city_municipality'])) {
            $updates[] = "city_municipality = '" . $conn->real_escape_string(trim($_POST['city_municipality'])) . "'";
        }
        
        // Check for password update
        if(!empty($_POST['password'])) {
            $updates[] = "password = '" . $conn->real_escape_string($_POST['password']) . "'";
        }

        // If there are changes, build and execute the query
        if(!empty($updates)) {
            $sql = "UPDATE residents SET " . implode(", ", $updates) . " WHERE id = '$user_id'";
            
            if($conn->query($sql)) {
                $changedFields = array_map(function($update) {
                    return ucfirst(explode(" = ", $update)[0]);
                }, $updates);
                
                $_SESSION['success_message'] = 'Updated: ' . implode(", ", $changedFields);
                header('Location: profile.php');
                exit();
            } else {
                throw new Exception("Error updating profile: " . $conn->error);
            }
        } else {
            $_SESSION['info_message'] = 'No changes were made to your profile.';
            header('Location: profile.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: profile.php');
        exit();
    }
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
    <!-- Add these in the head section -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    </style>
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
                <div class="col-6">
                  <h3>Edit Profile</h3>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home"></i></a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <h4 class="mb-4">My Profile</h4>
                    <div class="d-flex align-items-center mb-4">
                      <img src="<?php echo $profile_image; ?>" alt="Profile" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                      <div class="ms-3">
                        <h5 class="mb-0"><?php echo $user_data['firstname'] . ' ' . $user_data['lastname']; ?></h5>
                        <p class="text-muted mb-0"><?php echo $user_data['user_type']; ?></p>
                      </div>
                    </div>

                    <form method="POST" action="" enctype="multipart/form-data">
                      <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $user_data['username']; ?>">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="password">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                <i class="fa fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted">Leave blank if you don't want to change password</small>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstname" value="<?php echo $user_data['firstname']; ?>">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Middle Name</label>
                        <input type="text" class="form-control" name="middlename" value="<?php echo $user_data['middlename']; ?>">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastname" value="<?php echo $user_data['lastname']; ?>">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $user_data['email']; ?>">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" value="<?php echo $user_data['phone_number']; ?>">
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Address</label>
                        <div class="row">
                          <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" name="barangay" placeholder="Barangay" value="<?php echo $user_data['barangay']; ?>">
                          </div>
                          <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" name="purok_zone" placeholder="Purok/Zone" value="<?php echo $user_data['purok_zone']; ?>">
                          </div>
                          <div class="col-md-4 mb-3">
                            <input type="text" class="form-control" name="city_municipality" placeholder="City/Municipality" value="<?php echo $user_data['city_municipality']; ?>">
                          </div>
                        </div>
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="profile_image" id="profile_image" accept="image/*">
                            <label class="input-group-text" for="profile_image">Choose File</label>
                        </div>
                            <small class="form-text text-muted">Current image: <?php echo $user_data['profile_image'] ?: 'No image uploaded'; ?></small>
                      </div>

                      <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <!-- Add necessary JavaScript -->
    <script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#posts-table').DataTable({
            "pageLength": 10,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "searching": true
        });
    });
    </script>

    <!-- Update the JavaScript for handling registration -->
    <script>
    function confirmRegistration(postId) {
        Swal.fire({
            title: 'Event Registration',
            text: 'Do you want to register for this event?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, register me!',
            cancelButtonText: 'No, cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                <?php if(!isset($_SESSION['user_id'])): ?>
                    window.location.href = '../login.php';
                    return;
                <?php endif; ?>

                const formData = new FormData();
                formData.append('register_event', '1');
                formData.append('post_id', postId);
                formData.append('resident_id', '<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>');

                fetch('events.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registered!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload the page to update the button state
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registration Failed',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to register: ' + error
                    });
                });
            }
        });
    }
    </script>


    <script>
    // Update file name when file is selected
    document.getElementById('profile_image').addEventListener('change', function() {
        var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
        document.getElementById('file_name').textContent = fileName;
    });
    </script>

    <!-- Add this JavaScript for password toggle -->
    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
    </script>
  </body>
</html>
<?php ob_end_flush(); ?>