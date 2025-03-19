<?php
session_start();

include 'sql/sql.php';
?>

<!DOCTYPE html>
<html lang="en"> 
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admiro admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Admiro admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <title>Bansalan Davao del Sur</title>
    <!-- Favicon icon-->
    <link rel="icon" href="assets/images/bansalan.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/bansalan.png" type="image/x-icon">
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&amp;family=Dancing+Script:wght@700&amp;family=Lobster&amp;display=swap" rel="stylesheet">
    <!-- Flag icon css -->
    <link rel="stylesheet" href="assets/css/vendors/flag-icon.css">
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/iconly-icon.css">
    <link rel="stylesheet" href="assets/css/bulk-style.css">
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/themify.css">
    <!--fontawesome-->
    <link rel="stylesheet" href="assets/css/fontawesome-min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body class="landing-page">
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="landing-page">
      <!-- Page Body Start-->
      <!-- header start-->
      <header class="landing-header">
        <div class="container-fluid fluid-space">
          <div class="row">
            <div class="col-12">
              <nav class="navbar navbar-light p-0" id="navbar-example2"><a class="navbar-brand" href="javascript:void(0)"><img class="img-fluid" src="../assets/images/landing/logo/logo.png" alt=""></a>
                <ul class="landing-menu nav nav-pills">
                  <li class="nav-item menu-back">back<i class="fa-solid fa-angle-right"></i></li>
                  <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                  <li class="nav-item"><a class="nav-link" href="#layout">News</a></li>
                  <li class="nav-item"><a class="nav-link" href="#applications">Events</a></li>
                  <li class="nav-item"><a class="nav-link" href="#core-feature">Announcements</a></li>
                </ul>
                <div class="buy-block"><a class="btn-header btn btn-primary" href="login.php">Login</a>
                  <div class="toggle-menu"><i class="fa-solid fa-bars"></i></div>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </header>
      <!-- header end-->
      <!--home-section-start-->
      <section class="landing-home" id="home">
        <div class="container">
          <div class="landing-center landing-center-responsive title-padding">
            <div class="main-content-home">
              <div class="title-content">
                <h1>Welcome to <span class="animation-line">Barangay </span> Demographic System</h1>
                <p>The amazing and user-friendly system was made using adaptable, modern, and strong unique elements.</p>
              </div>
            </div>
            <div class="container-fluid">
              <div class="landing_first_section_img">
                <div class="img-set1"><img class="img-fluid" src="../assets/images/landing/screen2.png" alt=""></div>
                <div class="img-set2"><img class="img-fluid" src="../assets/images/landing/screen3.png" alt=""></div>
                <div class="img-set3"><img class="img-fluid" src="../assets/images/landing/screen1.png" alt=""></div>
              </div>
            </div>
            <div class="bottom-img-1"></div>
            <div class="bottom-img-2"></div>
          </div><a class="tap-down" href="#layout"><i class="icon-angle-double-down"> </i></a>
        </div>
        <div class="round-tringle">
          <div class="bg_circle1"><img class="img-fluid" src="../assets/images/landing/shape/shape1.png" alt=""></div>
          <div class="bg_circle2"><img class="img-fluid" src="../assets/images/landing/shape/shape2.png" alt=""></div>
          <div class="bg_circle3">
            <div class="d-flex"><img class="img-fluid" src="../assets/images/landing/shape/shape3.png" alt="">
              <h4>Trendy</h4>
            </div>
          </div>
          <div class="bg_circle4"><img class="img-fluid" src="../assets/images/landing/shape/shape4.png" alt=""></div>
          <div class="bg_circle5"><img class="img-fluid" src="../assets/images/landing/shape/shape5.png" alt=""></div>
          <div class="bg_circle6"><img class="img-fluid" src="../assets/images/landing/shape/shape6.png" alt=""></div>
          <div class="bg_circle7"><img class="img-fluid" src="../assets/images/landing/shape/shape7.png" alt=""></div>
        </div>
      </section>
      <!--home-section-end-->
      <!--page-section-start-->
      <section class="section-py-space landing-page-design" id="layout">
        <div class="title-style wow pulse">
          <h5 class="main-title">Latest News<span class="description-title">All the latest news and updates</span></h5>
        </div>
        <div class="container-fluid fluid-space">
            <div class="row justify-content-center">
                <?php
                // Include database connection
                include 'sql/sql.php';

                // Query to get posts with category "News"
                $query = "SELECT * FROM posts WHERE post_category = 'News' ORDER BY created_at DESC";
                $result = mysqli_query($conn, $query);

                if(mysqli_num_rows($result) > 0) {
                    while($post = mysqli_fetch_assoc($result)) {
                        // Convert image to base64
                        $imagePath = $post['post_image']; // This already contains "uploads/posts/filename.jpg"
                        $imageData = '';
                        if(!empty($post['post_image']) && file_exists($imagePath)) {
                            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                            $imageData = base64_encode(file_get_contents($imagePath));
                        }
                        ?>
                        <div class="col-lg-4 col-sm-6 wow fadeInLeft animated" data-wow-delay="0.1s">
                            <div class="layout-box">
                                <div class="layout-name">
                                    <div class="dot-img">
                                        <ul class="dot-group"> 
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                        </ul>
                                    </div>
                                    <?= htmlspecialchars($post['post_title']) ?>
                                </div>
                                <div class="img-wrraper">
                                    <?php if(!empty($imageData)): ?>
                                        <img class="img-fluid" src="data:image/<?= $imageType ?>;base64,<?= $imageData ?>" alt="<?= htmlspecialchars($post['post_title']) ?>">
                                    <?php else: ?>
                                        <img class="img-fluid" src="assets/images/default-post.jpg" alt="Default Image">
                                    <?php endif; ?>
                                </div>
                                <div class="post-description">
                                    <p><?= substr(htmlspecialchars($post['post_description']), 0, 100) ?>...</p>
                                    <div class="post-meta">
                                        <span class="date"><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                                        <span class="priority"><?= htmlspecialchars($post['post_priority']) ?></span>
                                    </div>
                                </div>
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
      </section>
      <!--page-section-end-->
      <!-- application-section-start-->
      <section class="section-py-space application-section" id="applications">
        <div class="container-fluid fluid-space">
            <div class="row"> 
                <div class="col-sm-12 wow pulse">
                    <div class="title-style wow pulse">
                        <h5 class="main-title">Latest Events<span class="description-title">All Events and Activities</span></h5>
                    </div>
                </div>
                <div class="col-sm-12 application">
                    <div class="row application-block g-xl-5 g-4">
                        <?php
                        // Query to get posts with category "Events"
                        $query = "SELECT * FROM posts WHERE post_category = 'Events' ORDER BY created_at DESC";
                        $result = mysqli_query($conn, $query);

                        if(mysqli_num_rows($result) > 0) {
                            while($post = mysqli_fetch_assoc($result)) {
                                // Convert image to base64
                                $imagePath = $post['post_image'];
                                $imageData = '';
                                if(!empty($post['post_image']) && file_exists($imagePath)) {
                                    $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                    $imageData = base64_encode(file_get_contents($imagePath));
                                }
                                ?>
                                <div class="col-lg-4 col-sm-6 wow pulse">
                                    <div class="layout-box">
                                        <div class="layout-name">
                                            <div class="dot-img">
                                                <ul class="dot-group">
                                                    <li></li>
                                                    <li></li>
                                                    <li></li>
                                                </ul>
                                            </div>
                                            <?= htmlspecialchars($post['post_title']) ?>
                                        </div>
                                        <div class="img-wrraper">
                                            <?php if(!empty($imageData)): ?>
                                                <img class="img-fluid" src="data:image/<?= $imageType ?>;base64,<?= $imageData ?>" alt="<?= htmlspecialchars($post['post_title']) ?>">
                                            <?php else: ?>
                                                <img class="img-fluid" src="assets/images/default-post.jpg" alt="Default Image">
                                            <?php endif; ?>
                                        </div>
                                        <div class="post-description">
                                            <p><?= substr(htmlspecialchars($post['post_description']), 0, 100) ?>...</p>
                                            <div class="post-meta mt-3 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="date"><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                                                    <span class="priority"><?= htmlspecialchars($post['post_priority']) ?></span>
                                                </div>
                                                <a href="javascript:void(0)" onclick="showLoginWarning()" class="btn btn-primary">Register Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-12 text-center">
                                <h3>No events available at the moment.</h3>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
      </section>
      <!-- application-section-end-->
      <!-- features-section-start-->
      <section class="section-py-space features-section" id="core-feature">
        <div class="container-fluid fluid-space">
          <div class="row"> 
            <div class="col-sm-12 wow pulse">
              <div class="title-style wow pulse">
                <h5 class="main-title">Latest Announcements<span class="description-title">Important Updates and Information</span></h5>
              </div>
            </div>
          </div>
          <div class="row g-4 g-md-5 feature-content"> 
            <?php
            // Query to get posts with category "Announcements"
            $query = "SELECT * FROM posts WHERE post_category = 'Announcements' ORDER BY created_at DESC";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0) {
                while($post = mysqli_fetch_assoc($result)) {
                    // Convert image to base64
                    $imagePath = $post['post_image'];
                    $imageData = '';
                    if(!empty($post['post_image']) && file_exists($imagePath)) {
                        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                        $imageData = base64_encode(file_get_contents($imagePath));
                    }
                    ?>
                    <div class="col-xl-3 col-lg-4 col-sm-6 wow fadeInUp animated" data-wow-duration="0.1s">
                        <div class="feature-box common-card bg-feature">
                            <div class="feature-icon bg-white">
                                <?php if(!empty($imageData)): ?>
                                    <div>
                                        <img class="img-fluid" src="data:image/<?= $imageType ?>;base64,<?= $imageData ?>" alt="<?= htmlspecialchars($post['post_title']) ?>">
                                    </div>
                                <?php else: ?>
                                    <div>
                                        <img class="img-fluid" src="assets/images/default-post.jpg" alt="Default Image">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h5><?= htmlspecialchars($post['post_title']) ?></h5>
                            <p class="mb-0"><?= substr(htmlspecialchars($post['post_description']), 0, 100) ?>...</p>
                            <div class="post-meta mt-3">
                                <span class="date"><?= date('M d, Y', strtotime($post['created_at'])) ?></span>
                                <span class="priority"><?= htmlspecialchars($post['post_priority']) ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-12 text-center">
                    <h3>No announcements available at the moment.</h3>
                </div>
                <?php
            }
            ?>
          </div>
        </div>
      </section>
      <!-- features-section-end-->
      
      <!-- footer-section-start-->
      <div class="footer landing-footer section-py-space" id="footer">  
        <div class="container-fluid fluid-space">
          <div class="sub-footer row g-md-2 g-3">
            <div class="col-md-6">
              <div class="left-subfooter"><img class="img-fluid" src="assets/images/bansalan.png" alt="logo">
                <p class="mb-0">Copyright 2024 &copy; Bansalan Davao del Sur</p>
              </div>
            </div>
          </div>
        </div>
        <ul class="shape">
          <li class="shape1"><img class="img-fluid" src="assets/images/landing/footer/shape1.png" alt=""></li>
          <li class="shape2"><img class="img-fluid" src="assets/images/landing/footer/shape2.png" alt=""></li>
          <li class="shape3"><img class="img-fluid" src="assets/images/landing/footer/shape3.png" alt=""></li>
          <li class="shape4"><img class="img-fluid" src="assets/images/landing/footer/shape4.png" alt=""></li>
          <li class="shape5"><img class="img-fluid" src="assets/images/landing/footer/shape5.png" alt=""></li>
          <li class="shape7"><img class="img-fluid" src="assets/images/landing/footer/shape1.png" alt=""></li>
          <li class="shape8"><img class="img-fluid" src="assets/images/landing/footer/shape1.png" alt=""></li>
          <li class="shape9"><img class="img-fluid" src="assets/images/landing/footer/shape7.png" alt=""></li>
          <li class="shape10"><img class="img-fluid" src="assets/images/landing/footer/shape7.png" alt=""></li>
        </ul>
      </div>
      <!-- footer-section-end-->
    </div>
    <!-- jquery-->
    <script src="assets/js/vendors/jquery/jquery.min.js"></script>
    <!-- bootstrap js-->
    <script src="assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- fontawesome js-->
    <script src="assets/js/vendors/font-awesome/fontawesome-min.js"></script>
    <!-- Plugins JS start-->
    <script src="assets/js/tooltip-init.js"></script>
    <script src="assets/js/animation/wow/wow.min.js"></script>
    <script src="assets/js/landing/landing.js"></script>
    <script src="assets/js/slick/slick.min.js"></script>
    <script src="assets/js/slick/slick.js"></script>
    <script>
    function showLoginWarning() {
        Swal.fire({
            title: 'Login Required',
            text: 'You need to login first before registering for this event.',
            icon: 'warning',
            confirmButtonText: 'Login',
            confirmButtonColor: '#3085d6',
            showCancelButton: true,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'login.php';
            }
        });
    }
    </script>
    <?php
    // Add this where you want to show error messages
    if (isset($error)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '$error'
            });
        </script>";
    }

    // For success messages
    if (isset($_SESSION['password_reset_success'])) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Password has been successfully reset. Please login with your new password.',
                confirmButtonColor: '#3085d6'
            });
        </script>";
        unset($_SESSION['password_reset_success']);
    }
    ?>
  </body>
</html>