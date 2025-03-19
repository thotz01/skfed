<?php
include '../sql/sql.php';
session_start();

// Fetch barangay data once at the beginning
$barangay_query = "SELECT * FROM barangay ORDER BY barangay_name";
$barangay_result = mysqli_query($conn, $barangay_query);
$barangays = []; // Store barangays in an array to reuse
if(mysqli_num_rows($barangay_result) > 0) {
    while($row = mysqli_fetch_assoc($barangay_result)) {
        $barangays[] = $row;
    }
}

// Function to calculate age and validate range (13-30)
function calculateAge($birthdate) {
    $birth = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $birth->diff($today)->y;

    if ($age < 13 || $age > 30) {
        return "Invalid age. Must be between 13 and 30 years old.";
    }

    return $age;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $birthdate = $_POST['birthdate'];
    $age = calculateAge($birthdate);

    // Check if the result is an error message or a valid age
    if (is_string($age)) {
        $error_message = $age; // Store the error message
        $age = ''; // Clear the age field
    } else {
        $error_message = ''; // Clear the error message if age is valid
    }
}



/*
// Function to calculate age
function calculateAge($birthdate) {
    $birth = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $birth->diff($today)->y;
    return $age;
}
*/
if(isset($_POST['save_resident'])){
    try {
        // Add error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Validate connection
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        // Only validate essential fields
        if (empty($_POST['firstname']) || empty($_POST['lastname'])) {
            throw new Exception("First name and last name are required");
        }

        // Create uploads directory if it doesn't exist
        $upload_dir = "../uploads/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Handle file upload
        $profile_image = "";
        if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png'];
            $filename = $_FILES['profile_image']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            // Verify file extension
            if(!in_array(strtolower($filetype), $allowed)) {
                throw new Exception("Only JPG, JPEG and PNG files are allowed");
            }

            // Verify file size - 2MB maximum
            $maxsize = 2 * 1024 * 1024;
            if($_FILES['profile_image']['size'] > $maxsize) {
                throw new Exception("File size is larger than 2MB");
            }

            // Generate unique filename
            $new_filename = uniqid() . '.' . $filetype;
            $destination = $upload_dir . $new_filename;

            // Move uploaded file
            if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination)) {
                $profile_image = $new_filename;
            } else {
                throw new Exception("Error uploading file");
            }
        }

        // Calculate age from birthdate
        $bdate = $conn->real_escape_string($_POST['bdate'] ?? '');
        if(empty($bdate)) {
            throw new Exception("Birth date is required");
        }
        $age = calculateAge($bdate);

        // Escape all input values to prevent SQL injection
        $firstname = $conn->real_escape_string($_POST['firstname']);
        $lastname = $conn->real_escape_string($_POST['lastname']);
        $middlename = $conn->real_escape_string($_POST['middlename'] ?? '');
        $suffix = $conn->real_escape_string($_POST['suffix'] ?? '');
        $sex = $conn->real_escape_string($_POST['sex'] ?? '');
        $region = $conn->real_escape_string($_POST['region'] ?? '');
        $province = $conn->real_escape_string($_POST['province'] ?? '');
        $city_municipality = $conn->real_escape_string($_POST['city_municipality'] ?? '');
        $barangay = $conn->real_escape_string($_POST['barangay'] ?? '');
        $purok_zone = $conn->real_escape_string($_POST['purok_zone'] ?? '');
        $username = $conn->real_escape_string($_POST['username'] ?? '');
        $password = $conn->real_escape_string($_POST['password'] ?? '');
        $user_type = $conn->real_escape_string($_POST['user_type'] ?? '');
        $email = $conn->real_escape_string($_POST['email'] ?? '');
        $phone_number = $conn->real_escape_string($_POST['phone_number'] ?? '');
        $marital_status = $conn->real_escape_string($_POST['marital_status'] ?? '');

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Direct SQL query
        $sql = "INSERT INTO residents (
            firstname, lastname, middlename, suffix, sex, bdate, age,
            email, phone_number, marital_status,
            region, province, city_municipality, barangay, purok_zone,
            username, password, user_type, profile_image
        ) VALUES (
            '$firstname', '$lastname', '$middlename', '$suffix', '$sex', '$bdate', '$age',
            '$email', '$phone_number', '$marital_status',
            '$region', '$province', '$city_municipality', '$barangay', '$purok_zone',
            '$username', '$hashed_password', '$user_type', '$profile_image'
        )";

        // Execute query
        if($conn->query($sql)){
            $_SESSION['success'] = "Resident added successfully";
        } else {
            throw new Exception("Error executing query: " . $conn->error);
        }

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    
    // Always redirect after form submission
    header("Location: add-residents.php");
    exit();
}

// Replace the PHP message display section with JavaScript
if(isset($_SESSION['success']) || isset($_SESSION['error'])) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(isset($_SESSION['success'])): ?>
                Swal.fire({
                    title: 'Success!',
                    text: '<?= $_SESSION['success'] ?>',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    timer: 3000, // Will close after 3 seconds
                    timerProgressBar: true
                });
            <?php unset($_SESSION['success']); endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                Swal.fire({
                    title: 'Error!',
                    text: '<?= $_SESSION['error'] ?>',
                    icon: 'error',
                    confirmButtonColor: '#d33',
                    timer: 5000, // Will close after 5 seconds
                    timerProgressBar: true
                });
            <?php unset($_SESSION['error']); endif; ?>
        });
    </script>
    <?php
}

// Update Resident
if(isset($_POST['update_resident'])) {
    try {
        // Add error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Validate connection
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        // Validate required fields
        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['edit_id'])) {
            throw new Exception("First name, last name and ID are required");
        }

        $edit_id = $conn->real_escape_string($_POST['edit_id']);
        $bdate = $conn->real_escape_string($_POST['bdate'] ?? '');
        if(empty($bdate)) {
            throw new Exception("Birth date is required");
        }
        
        // Calculate age
        $age = calculateAge($bdate);

        // Escape all input values
        $firstname = $conn->real_escape_string($_POST['firstname']);
        $lastname = $conn->real_escape_string($_POST['lastname']);
        $middlename = $conn->real_escape_string($_POST['middlename'] ?? '');
        $suffix = $conn->real_escape_string($_POST['suffix'] ?? '');
        $sex = $conn->real_escape_string($_POST['sex'] ?? '');
        $email = $conn->real_escape_string($_POST['email'] ?? '');
        $phone_number = $conn->real_escape_string($_POST['phone_number'] ?? '');
        $marital_status = $conn->real_escape_string($_POST['marital_status'] ?? '');
        $region = $conn->real_escape_string($_POST['region'] ?? '');
        $province = $conn->real_escape_string($_POST['province'] ?? '');
        $city_municipality = $conn->real_escape_string($_POST['city_municipality'] ?? '');
        $barangay = $conn->real_escape_string($_POST['barangay'] ?? '');
        $purok_zone = $conn->real_escape_string($_POST['purok_zone'] ?? '');

        // Prepare UPDATE query
        $query = "UPDATE residents SET 
            firstname = ?,
            lastname = ?,
            middlename = ?,
            suffix = ?,
            sex = ?,
            bdate = ?,
            age = ?,
            email = ?,
            phone_number = ?,
            marital_status = ?,
            region = ?,
            province = ?,
            city_municipality = ?,
            barangay = ?,
            purok_zone = ?
            WHERE id = ?";

        // Prepare and bind
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("sssssssssssssssi", 
            $firstname,
            $lastname,
            $middlename,
            $suffix,
            $sex,
            $bdate,
            $age,
            $email,
            $phone_number,
            $marital_status,
            $region,
            $province,
            $city_municipality,
            $barangay,
            $purok_zone,
            $edit_id
        );

        // Execute the statement
        if($stmt->execute()) {
            $_SESSION['success'] = "Resident updated successfully";
        } else {
            throw new Exception("Error updating resident: " . $stmt->error);
        }

        $stmt->close();

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    
    // Redirect after update
    header("Location: add-residents.php");
    exit();
}

// Delete Resident
if(isset($_POST['delete_resident'])) {
    try {
        $delete_id = $conn->real_escape_string($_POST['delete_id']);
        
        // First, get the profile image filename
        $query = "SELECT profile_image FROM residents WHERE id='$delete_id'";
        $result = $conn->query($query);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row['profile_image']) {
                $image_path = "../uploads/" . $row['profile_image'];
                if(file_exists($image_path)) {
                    unlink($image_path); // Delete the image file
                }
            }
        }

        // Then delete the resident
        $query = "DELETE FROM residents WHERE id='$delete_id'";
        if($conn->query($query)) {
            $_SESSION['success'] = "Resident deleted successfully";
        } else {
            throw new Exception("Error deleting resident: " . $conn->error);
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    header("Location: add-residents.php");
    exit();
}
?>

<!DOCTYPE html >
<html lang="en">
  <head>

  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">



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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                  <h2>Resident List</h2>
                </div>
                <div class="col-sm-6 col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                    <li class="breadcrumb-item">Resident</li>
                    <li class="breadcrumb-item active">Resident List</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Resident Information</h6>
                </div>
                <div class="card-body">
                    <div class="list-product-header">
                        <div> 
                            
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addResidentModal">
                                <i class="fa-solid fa-plus"></i>Add Resident
                            </button>
                        </div>
                    </div>

                    <!-- Residents Table -->
                    <div class="list-product">
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                
                                
                            </div>
                            <div class="datatable-container">
                                <table id="residents-table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true" style="width: 20%;"><span class="f-light f-w-600">Name</span></th>
                                            <th data-sortable="true" style="width: 15%;"><span class="f-light f-w-600">Contact Info</span></th>
                                            <th data-sortable="true" style="width: 20%;"><span class="f-light f-w-600">Location</span></th>
                                            <th data-sortable="true" style="width: 10%;"><span class="f-light f-w-600">Sex</span></th>
                                            <th data-sortable="true" style="width: 10%;"><span class="f-light f-w-600">Birth Date</span></th>
                                            <th data-sortable="true" style="width: 10%;"><span class="f-light f-w-600">Status</span></th>
                                            <th data-sortable="true" style="width: 15%;"><span class="f-light f-w-600">Action</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- PHP code to fetch and display residents -->
                                        <?php
                                        $query = "SELECT * FROM residents";
                                        $query_run = mysqli_query($conn, $query);

                                        if(mysqli_num_rows($query_run) > 0) {
                                            foreach($query_run as $resident) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $resident['firstname'] . ' ' . 
                                                            ($resident['middlename'] ? $resident['middlename'] . ' ' : '') . 
                                                            $resident['lastname'] . ' ' . 
                                                            ($resident['suffix'] ? $resident['suffix'] : ''); ?>
                                                    </td>
                                                    <td>
                                                        Email: <?= $resident['email'] ?><br>
                                                        Phone: <?= $resident['phone_number'] ?>
                                                    </td>
                                                    <td>
                                                        <?= $resident['purok_zone'] . ', ' . 
                                                            $resident['barangay'] . ', ' . 
                                                            $resident['city_municipality'] . ', ' . 
                                                            $resident['province'] . ', ' . 
                                                            $resident['region']; ?>
                                                    </td>
                                                    <td><?= $resident['sex'] ?></td>
                                                    <td><?= date('M d, Y', strtotime($resident['bdate'])) ?></td>
                                                    <td><?= $resident['marital_status'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $resident['id'] ?>">
                                                            Edit
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $resident['id'] ?>)">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <!-- Edit Modal for each resident -->
                                                <div class="modal fade" id="editModal<?= $resident['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $resident['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel<?= $resident['id'] ?>">Edit Resident</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="add-residents.php" method="POST" id="editForm<?= $resident['id'] ?>">
                                                                    <input type="hidden" name="edit_id" value="<?= $resident['id'] ?>">
                                                                    <input type="hidden" name="update_resident" value="1">
                                                                    
                                                                    <div class="row">
                                                                        <!-- Personal Information -->
                                                                        <div class="col-md-6 border-end">
                                                                            <div class="form-section mb-4">
                                                                                <h5 class="section-title border-bottom pb-2">Personal Information</h5>
                                                                                <div class="row g-3">
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">First Name*</label>
                                                                                        <input type="text" name="firstname" class="form-control" value="<?= $resident['firstname'] ?>" required>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Middle Name</label>
                                                                                        <input type="text" name="middlename" class="form-control" value="<?= $resident['middlename'] ?>">
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Last Name*</label>
                                                                                        <input type="text" name="lastname" class="form-control" value="<?= $resident['lastname'] ?>" required>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Suffix</label>
                                                                                        <input type="text" name="suffix" class="form-control" value="<?= $resident['suffix'] ?>">
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Sex*</label>
                                                                                        <select name="sex" class="form-control" required>
                                                                                            <option value="">Select Sex</option>
                                                                                            <option value="Male" <?= $resident['sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                                                                            <option value="Female" <?= $resident['sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                                                                            <option value="LGBTQ" <?= $resident['sex'] == 'LGBTQ' ? 'selected' : '' ?>>LGBTQ</option>
                                                                                        </select>
                                                                                    </div>

                                                                        

                                                                                   
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Birth Date*</label>
                                                                                        <input type="date" name="bdate" class="form-control" value="<?= $resident['bdate'] ?>" required>
                                                                                    </div> 






                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Status*</label>
                                                                                        <select name="marital_status" class="form-control" required>
                                                                                            
                                                                                            <option value="Single" <?= $resident['marital_status'] == 'Single' ? 'selected' : '' ?>>Single</option>
                                                                                           
                                                                                        </select>
                                                                                    </div> 
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-md-6">
                                                                            <!-- Contact Information -->
                                                                            <div class="form-section mb-4">
                                                                                <h5 class="section-title border-bottom pb-2">Contact Information</h5>
                                                                                <div class="row g-3">
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Email*</label>
                                                                                        <input type="email" name="email" class="form-control" value="<?= $resident['email'] ?>" required>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Phone Number*</label>
                                                                                        <input type="text" name="phone_number" class="form-control" value="<?= $resident['phone_number'] ?>" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Location Information -->
                                                                            <div class="form-section mb-4">
                                                                                <h5 class="section-title border-bottom pb-2">Location Information</h5>



                                                                                <div class="row g-3">
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Region*</label>
                                                                                        <input type="text" name="region" class="form-control" value="<?= $resident['region'] ?>" required>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Province*</label>
                                                                                        <input type="text" name="province" class="form-control" value="<?= $resident['province'] ?>" required>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Municipality*</label>
                                                                                        <input type="text" name="city_municipality" class="form-control" value="<?= $resident['city_municipality'] ?>" required>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Barangay*</label>
                                                                                        <select name="barangay" class="form-control" required>
                                                                                            <option value="">Select Barangay</option>
                                                                                            <?php foreach($barangays as $barangay): ?>
                                                                                                <option value="<?= $barangay['barangay_name'] ?>" <?= $resident['barangay'] == $barangay['barangay_name'] ? 'selected' : '' ?>>
                                                                                                    <?= $barangay['barangay_name'] ?>
                                                                                                </option>
                                                                                            <?php endforeach; ?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-12">
                                                                                        <label class="form-label">Purok/Zone*</label>
                                                                                        <input type="text" name="purok_zone" class="form-control" value="<?= $resident['purok_zone'] ?>" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" form="editForm<?= $resident['id'] ?>" class="btn btn-primary">Update Resident</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Add this hidden form for delete -->
                                                <form action="add-residents.php" method="POST" style="display: none;" data-delete-id="<?= $resident['id'] ?>">
                                                    <input type="hidden" name="delete_id" value="<?= $resident['id'] ?>">
                                                    <input type="hidden" name="delete_resident" value="1">
                                                </form>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Add Resident Modal -->
                    <div class="modal fade" id="addResidentModal" tabindex="-1" aria-labelledby="addResidentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addResidentModalLabel">Add New Resident</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addResidentForm" action="add-residents.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="save_resident" value="1">
                                        <div class="row">
                                            <!-- Left Column -->
                                            <div class="col-md-6 border-end">
                                                <!-- Personal Information -->
                                                <div class="form-section mb-4">
                                                    <h5 class="section-title border-bottom pb-2">Personal Information</h5>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">First Name*</label>
                                                            <input type="text" name="firstname" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Middle Name</label>
                                                            <input type="text" name="middlename" class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Last Name*</label>
                                                            <input type="text" name="lastname" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Suffix</label>
                                                            <input type="text" name="suffix" class="form-control">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Sex*</label>
                                                            <select name="sex" class="form-control" required>
                                                                <option value="">Select Sex</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="LGBTQ">LGBTQ</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Birth Date*</label>
                                                            <input type="date" name="bdate" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Age</label>
                                                            <input type="number" name="age" class="form-control" readonly>
                                                        </div>


                                                        
                                                        <div class="col-md-6">
                                                            <label class="form-label"> Status*</label>
                                                            <select name="marital_status" class="form-control" required>
                                                                
                                                                <option value="Single">Single</option>
                                                               
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Contact Information -->
                                                <div class="form-section mb-4">
                                                    <h5 class="section-title border-bottom pb-2">Contact Information</h5>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Email*</label>
                                                            <input type="email" name="email" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Phone Number*</label>
                                                            <input type="text" name="phone_number" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Location Information -->
                                                <div class="form-section mb-4">
                                                    <h5 class="section-title border-bottom pb-2">Location Information</h5>
                                                    <div class="row g-3">


                                                    <div class="col-md-6">
                                                            <label class="form-label"> Region*</label>
                                                            <select name="region" class="form-control" required>
                                                                
                                                                <option value="XI">XI</option>
                                                               
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label"> Province*</label>
                                                            <select name="province" class="form-control" required>
                                                                
                                                                <option value="Davao del Sur">Davao del Sur</option>
                                                               
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label"> Municipality*</label>
                                                            <select name="city_municipality" class="form-control" required>
                                                                
                                                                <option value="Bansalan">Bansalan</option>
                                                               
                                                            </select>
                                                        </div>

                                                       <!--  <div class="col-md-6">
                                                            <label class="form-label">Region*</label>
                                                            <input type="text" name="region" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Province*</label>
                                                            <input type="text" name="province" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">City/Municipality*</label>
                                                            <input type="text" name="city_municipality" class="form-control" required>
                                                        </div> -->
                                                        <div class="col-md-6">
                                                            <label class="form-label">Barangay*</label>
                                                            <select name="barangay" class="form-control" required>
                                                                <option value="">Select Barangay</option>
                                                                <?php
                                                                foreach($barangays as $barangay) {
                                                                    echo "<option value='" . $barangay['barangay_name'] . "'>" . $barangay['barangay_name'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Purok/Zone*</label>
                                                            <input type="text" name="purok_zone" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Column -->
                                            <div class="col-md-6">
                                                <!-- Account Information -->
                                                <div class="form-section mb-4">
                                                    <h5 class="section-title border-bottom pb-2">Account Information</h5>
                                                    <div class="row g-3">
                                                        <div class="col-md-12">
                                                            <label class="form-label">Username*</label>
                                                            <input type="text" name="username" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label">Password*</label>
                                                            <input type="password" name="password" class="form-control" required>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label">User Type*</label>
                                                            <select name="user_type" class="form-control" required>
                                                                <option value="">Select User Type</option>
                                                                <option value="admin">admin</option>
                                                                <option value="user">user</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Profile Image -->
                                                <div class="form-section mb-4">
                                                    <h5 class="section-title border-bottom pb-2">Profile Image</h5>
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Profile Picture</label>
                                                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                                                            <small class="text-muted">Allowed formats: JPG, JPEG, PNG. Max size: 2MB</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" form="addResidentForm" class="btn btn-primary">Save Resident</button>
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
        const body = document.querySelector('body');
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

    .form-section {
        padding: 15px;
        background-color: #fff;
        border-radius: 5px;
    }

    .section-title {
        color: #1e2f65;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
    }

    .form-label:after {
        content: "*";
        color: red;
        margin-left: 3px;
    }

    .form-label:not([for*="required"]):after {
        content: none;
    }

    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }

    .border-end {
        border-right: 1px solid #dee2e6;
    }

    .select2-container {
        z-index: 9999;
    }

    .modal-body .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single {
        height: 38px;
        line-height: 38px;
        border: 1px solid #ced4da;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    </style>
    <!-- Add this modal markup before the closing body tag -->
    <div class="modal fade" id="addResidentModal" tabindex="-1" aria-labelledby="addResidentModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addResidentModalLabel">Add New Resident</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="addResidentForm" action="add-residents.php" method="POST" enctype="multipart/form-data">
              <!-- Your existing form fields go here -->
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="save_resident" form="addResidentForm" class="btn btn-primary">Save Resident</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Add necessary JavaScript -->
    <script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#residents-table').DataTable({
            "pageLength": 10,
            "ordering": true,
            "info": true,
            "lengthChange": true,
            "searching": true
        });
    });

    // Auto calculate age
    document.addEventListener('DOMContentLoaded', function() {
        function calculateAge(birthDate) {
            const today = new Date();
            const birth = new Date(birthDate);
            let age = today.getFullYear() - birth.getFullYear();
            const monthDiff = today.getMonth() - birth.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                age--;
            }
            return age;
        }

        // Add event listeners to all birth date inputs
        document.querySelectorAll('input[name="bdate"]').forEach(function(input) {
            const ageInput = input.closest('.row').querySelector('input[name="age"]');
            if(ageInput) {
                // Set initial age if birth date exists
                if(input.value) {
                    ageInput.value = calculateAge(input.value);
                }
                
                // Update age when birth date changes
                input.addEventListener('change', function() {
                    if(this.value) {
                        ageInput.value = calculateAge(this.value);
                    } else {
                        ageInput.value = '';
                    }
                });
            }
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        // Initialize Select2 for barangay dropdowns
        $('select[name="barangay"]').select2({
            placeholder: "Select Barangay",
            allowClear: true,
            width: '100%' // This ensures proper width
        });

        // Initialize modals properly
        $('.modal').on('shown.bs.modal', function () {
            $(this).find('select[name="barangay"]').select2({
                placeholder: "Select Barangay",
                allowClear: true,
                width: '100%',
                dropdownParent: $(this) // This ensures dropdown shows properly in modal
            });
        });
    });
    </script>
    <!-- Add this JavaScript before the closing body tag -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // Confirm delete with SweetAlert2
    function confirmDelete(deleteId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector(`form[data-delete-id="${deleteId}"]`).submit();
            }
        });
    }

    // Form submission handlers
    document.addEventListener('DOMContentLoaded', function() {
        // Add Resident Form
        const addForm = document.getElementById('addResidentForm');
        if(addForm) {
            addForm.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Saving...',
                    text: 'Please wait while we save the resident information.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                this.submit();
            });
        }

        // Edit Resident Forms
        document.querySelectorAll('form[id^="editForm"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Updating...',
                    text: 'Please wait while we update the resident information.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                this.submit();
            });
        });
    });

    // Modify the delete button click handlers
    document.querySelectorAll('[data-bs-target^="#deleteModal"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const residentId = this.getAttribute('data-bs-target').replace('#deleteModal', '');
            confirmDelete(residentId);
        });
    });
    </script>
  </body>
</html>