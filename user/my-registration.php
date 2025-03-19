<?php
include '../sql/sql.php';
session_start();

// Add JSON header for AJAX requests
if(isset($_POST['cancel_id'])) {
    header('Content-Type: application/json');
    
    $id = mysqli_real_escape_string($conn, $_POST['cancel_id']);
    
    // Update the status and description
    $query = "UPDATE person_register SET 
              status = 'Cancelled',
              description = 'Cancelled by participant',
              updated_at = NOW()
              WHERE id = ?";
              
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        exit;
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
                  <h2>My Event Registration</h2>
                </div>
                <div class="col-sm-6 col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                    <li class="breadcrumb-item">Register</li>
                    <li class="breadcrumb-item active">My Event Registration</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">My Event Registration</h6>
                </div>
                <div class="card-body">
                    

                    <!-- Residents Table -->
                    <div class="list-product">
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-top">
                                
                                
                            </div>
                            <div class="datatable-container">
                                <table id="residents-table" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true"><span class="f-light f-w-600">ID</span></th>
                                            <th data-sortable="true"><span class="f-light f-w-600">Resident ID</span></th>
                                            <th data-sortable="true"><span class="f-light f-w-600">Posts ID</span></th>
                                            <th data-sortable="true"><span class="f-light f-w-600">Description</span></th>
                                            <th data-sortable="true"><span class="f-light f-w-600">Status</span></th>
                                            <th data-sortable="true"><span class="f-light f-w-600">Created At</span></th>
                                            <th data-sortable="true"><span class="f-light f-w-600">Updated At</span></th>
                                            <th data-sortable="true"><span class="f-light f-w-600">Action</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- PHP code to fetch and display residents -->
                                        <?php
                                        $query = "SELECT * FROM person_register";
                                        $query_run = mysqli_query($conn, $query);

                                        if(mysqli_num_rows($query_run) > 0) {
                                            foreach($query_run as $register) {
                                                ?>
                                                <tr>
                                                    <td><?= $register['id'] ?></td>
                                                    <td><?= $register['resident_id'] ?></td>
                                                    <td><?= $register['posts_id'] ?></td>
                                                    <td><?= $register['description'] ?></td>
                                                    <td><?= $register['status'] ?></td>
                                                    <td><?= date('M d, Y H:i:s', strtotime($register['created_at'])) ?></td>
                                                    <td><?= $register['updated_at'] ? date('M d, Y H:i:s', strtotime($register['updated_at'])) : 'N/A' ?></td>
                                                    <td>
                                                        <?php if($register['status'] === 'Cancelled'): ?>
                                                            <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                                Cancelled
                                                            </button>
                                                        <?php elseif($register['status'] === 'Approved'): ?>
                                                            <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                                Cannot Cancel
                                                            </button>
                                                        <?php else: ?>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal<?= $register['id'] ?>">
                                                                Cancel
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
    </script>

    <!-- Cancel Modals -->
    <?php
    $query_run = mysqli_query($conn, $query);
    if(mysqli_num_rows($query_run) > 0) {
        foreach($query_run as $register) { ?>
            <div class="modal fade" id="cancelModal<?= $register['id'] ?>" tabindex="-1" aria-labelledby="cancelModalLabel<?= $register['id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelModalLabel<?= $register['id'] ?>">Confirm Cancellation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to cancel this registration?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="cancelRegistration(<?= $register['id'] ?>)">Confirm Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
    } ?>

    <script>
    function cancelRegistration(id) {
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                cancel_id: id
            },
            dataType: 'json', // Specify that we expect JSON response
            success: function(response) {
                try {
                    if(response.success) {
                        // Close the modal
                        $(`#cancelModal${id}`).modal('hide');
                        // Reload the page to show updated data
                        location.reload();
                    } else {
                        alert('Error cancelling registration: ' + (response.error || 'Unknown error'));
                    }
                } catch(e) {
                    console.error('Error parsing response:', e);
                    alert('Error processing server response');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Error processing request: ' + error);
            }
        });
    }
    </script>
  </body>
</html>