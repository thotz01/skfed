<?php
include '../sql/sql.php';
session_start();

if(isset($_POST['save_post'])){
    try {
        // Add error reporting
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Validate connection
        if (!$conn) {
            throw new Exception("Database connection failed");
        }

        // Only validate essential fields
        if (empty($_POST['post_title'])) {
            throw new Exception("Post title is required");
        }

        // Handle file upload
        $post_image = '';
        if(isset($_FILES['post_image']) && $_FILES['post_image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['post_image']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            if(!in_array(strtolower($filetype), $allowed)) {
                throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed");
            }

            // Create uploads directory if it doesn't exist
            $upload_dir = '../uploads/posts/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Generate unique filename
            $new_filename = uniqid() . '.' . $filetype;
            $upload_path = $upload_dir . $new_filename;

            if(move_uploaded_file($_FILES['post_image']['tmp_name'], $upload_path)) {
                $post_image = 'uploads/posts/' . $new_filename;
            } else {
                throw new Exception("Failed to upload image");
            }
        }

        // Escape all input values to prevent SQL injection
        $post_title = $conn->real_escape_string($_POST['post_title']);
        $post_description = $conn->real_escape_string($_POST['post_description'] ?? '');
        $post_category = $conn->real_escape_string($_POST['post_category'] ?? '');
        $post_priority = $conn->real_escape_string($_POST['post_priority'] ?? '');
        $post_image = $conn->real_escape_string($post_image);

        // Direct SQL query
        $sql = "INSERT INTO posts (
            post_title, post_description, post_image, post_category, post_priority,
            created_at
        ) VALUES (
            '$post_title', '$post_description', '$post_image', '$post_category', '$post_priority',
            NOW()
        )";

        // Execute query
        if($conn->query($sql)){
            $_SESSION['success'] = "Post added successfully";
            header("Location: add-post.php");
            exit();
        } else {
            throw new Exception("Error executing query: " . $conn->error);
        }

    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: add-post.php");
        exit();
    }
}

// Handle delete action
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    try {
        $id = $conn->real_escape_string($_GET['id']);
        
        // Get image path before deleting
        $query = "SELECT post_image FROM posts WHERE id = '$id'";
        $result = $conn->query($query);
        if($row = $result->fetch_assoc()) {
            // Delete image file if exists
            if(!empty($row['post_image']) && file_exists('../' . $row['post_image'])) {
                unlink('../' . $row['post_image']);
            }
        }
        
        // Delete the post
        $sql = "DELETE FROM posts WHERE id = '$id'";
        if($conn->query($sql)) {
            $_SESSION['success'] = "Post deleted successfully";
        } else {
            throw new Exception("Error deleting post");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    header("Location: add-post.php");
    exit();
}

// Handle edit action
if(isset($_POST['edit_post'])) {
    try {
        $id = $conn->real_escape_string($_POST['post_id']);
        
        // Handle file upload for edit
        $post_image = '';
        if(isset($_FILES['post_image']) && $_FILES['post_image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['post_image']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            if(!in_array(strtolower($filetype), $allowed)) {
                throw new Exception("Only JPG, JPEG, PNG & GIF files are allowed");
            }

            $upload_dir = '../uploads/posts/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Delete old image if exists
            $query = "SELECT post_image FROM posts WHERE id = '$id'";
            $result = $conn->query($query);
            if($row = $result->fetch_assoc()) {
                if(!empty($row['post_image']) && file_exists('../' . $row['post_image'])) {
                    unlink('../' . $row['post_image']);
                }
            }

            $new_filename = uniqid() . '.' . $filetype;
            $upload_path = $upload_dir . $new_filename;

            if(move_uploaded_file($_FILES['post_image']['tmp_name'], $upload_path)) {
                $post_image = 'uploads/posts/' . $new_filename;
            } else {
                throw new Exception("Failed to upload image");
            }
        }

        // Escape all input values
        $post_title = $conn->real_escape_string($_POST['post_title']);
        $post_description = $conn->real_escape_string($_POST['post_description'] ?? '');
        $post_category = $conn->real_escape_string($_POST['post_category'] ?? '');
        $post_priority = $conn->real_escape_string($_POST['post_priority'] ?? '');

        // Update query
        $sql = "UPDATE posts SET 
                post_title = '$post_title', 
                post_description = '$post_description', 
                post_category = '$post_category', 
                post_priority = '$post_priority'";
        
        // Add image to update query only if new image was uploaded
        if(!empty($post_image)) {
            $sql .= ", post_image = '$post_image'";
        }
        
        $sql .= " WHERE id = '$id'";

        if($conn->query($sql)) {
            $_SESSION['success'] = "Post updated successfully";
        } else {
            throw new Exception("Error updating post");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    header("Location: add-post.php");
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
                  <h2>Announcement List</h2>
                </div>
                <div class="col-sm-6 col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                    <li class="breadcrumb-item">Announcements</li>
                    <li class="breadcrumb-item active">Latest Announcements</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Latest Announcements</h6>
                </div>
                <div class="card-body">
                    <!-- <div class="list-product-header">
                        <div> 
                            
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPostModal">
                                <i class="fa-solid fa-plus"></i>Add Post
                            </button>
                        </div>
                    </div> -->

                    <!-- Residents Table -->
                    <div class="list-product">
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                
                                
                            </div>
                            <div class="datatable-container">
                                <div class="posts-grid">
                                    <?php
                                    // Modified query to only select News posts
                                    $query = "SELECT * FROM posts WHERE post_category = 'Announcements' ORDER BY created_at DESC";
                                    $result = $conn->query($query);
                                    
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            ?>
                                            <div class="post-card">
                                                <div class="post-image">
                                                    <?php if(!empty($row['post_image'])): ?>
                                                        <img src="../<?php echo $row['post_image']; ?>" alt="Post Image">
                                                    <?php else: ?>
                                                        <div class="no-image">No image</div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="post-content">
                                                    <h3 class="post-title"><?php echo $row['post_title']; ?></h3>
                                                    <p class="post-desc"><?php echo substr($row['post_description'], 0, 50) . '...'; ?></p>
                                                    <div class="post-meta">
                                                        <span class="category"><?php echo $row['post_category']; ?></span>
                                                        <span class="priority"><?php echo $row['post_priority']; ?></span>
                                                    </div>
                                                    <!-- Removed edit and delete buttons since this is for viewing only -->
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="col-12 text-center">
                                            <h3>No news posts available at the moment.</h3>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Resident Modal -->
                    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPostModalLabel">Add New Post</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addPostForm" action="add-post.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="post_title">Title</label>
                                            <input type="text" name="post_title" class="form-control" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="post_description">Description</label>
                                            <textarea name="post_description" class="form-control" rows="4"></textarea>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="post_image">Image</label>
                                            <input type="file" name="post_image" class="form-control" accept="image/*">
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="post_category">Category</label>
                                            <select name="post_category" class="form-control">
                                                <option value="">Select Category</option>
                                                <option value="News">News</option>
                                                <option value="Events">Events</option>
                                                <option value="Announcements">Announcements</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="post_priority">Priority</label>
                                            <select name="post_priority" class="form-control">
                                                <option value="Low">Low</option>
                                                <option value="Medium">Medium</option>
                                                <option value="High">High</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="save_post" form="addPostForm" class="btn btn-primary">Save Post</button>
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
    </style>
    <!-- Add this modal markup before the closing body tag -->
    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addPostModalLabel">Add New Post</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="addPostForm" action="add-post.php" method="POST" enctype="multipart/form-data">
              <!-- Your existing form fields go here -->
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="save_post" form="addPostForm" class="btn btn-primary">Save Post</button>
          </div>
        </div>
      </div>
    </div>

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
  </body>
</html>