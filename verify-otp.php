<?php
session_start();

// Redirect if no reset email in session
if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_otp'])) {
    header("Location: forgot-password.php");
    exit();
}

include 'sql/sql.php';

if (isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    $stored_otp = $_SESSION['reset_otp'];
    $expiry = $_SESSION['otp_expiry'];

    if (time() > strtotime($expiry)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'OTP Expired',
                text: 'Please request a new OTP',
                confirmButtonColor: '#3085d6'
            });
        </script>";
    } elseif ($entered_otp == $stored_otp) {
        // OTP is valid, redirect to reset password page
        header("Location: reset-password.php");
        exit();
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid OTP',
                text: 'Please try again',
                confirmButtonColor: '#3085d6'
            });
        </script>";
    }
}
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
  <title>Verify OTP</title>
  <!-- Favicon icon-->
  <link rel="icon" href="assets/images/bansalan.png" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/bansalan.png" type="image/x-icon">
  <!-- Google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet">
  <!-- Flag icon css -->
  <link rel="stylesheet" href="assets/css/vendors/flag-icon.css">
  <!-- iconly-icon-->
  <link rel="stylesheet" href="assets/css/iconly-icon.css">
  <link rel="stylesheet" href="assets/css/bulk-style.css">
  <!-- iconly-icon-->
  <link rel="stylesheet" href="assets/css/themify.css">
  <!--fontawesome-->
  <link rel="stylesheet" href="assets/css/fontawesome-min.css">
  <!-- Whether Icon css-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/weather-icons/weather-icons.min.css">
  <!-- App css -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
  <!-- Add SweetAlert2 CSS and JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .login_one_image {
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f8f9fa;
      min-height: 100vh;
      padding: 30px;
    }

    .logo img {
      width: 200px;
      height: auto;
      display: block;
      margin: 0 auto;
      padding: 15px 0;
    }

    .login_one_image img {
      width: 15%;
      height: auto;
      object-fit: contain;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .login_one_image img:hover {
      transform: scale(1.02);
    }

    .login-card {
      background: rgba(255, 255, 255, 0.9) !important;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      border-radius: 15px;
    }

    .login-main {
      padding: 30px;
    }

    @media (max-width: 1200px) {
      .login_one_image img {
        width: 20%;
      }
    }

    @media (max-width: 768px) {
      .login_one_image {
        min-height: 50vh;
      }

      .login_one_image img {
        width: 25%;
      }
    }

    /* Loader styles */
    .loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.3s ease-out, visibility 0.3s ease-out;
    }
    
    .loader-wrapper.hidden {
        opacity: 0;
        visibility: hidden;
    }
  </style>
</head>

<body>
  <!-- tap on top starts-->
  <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
  <!-- tap on tap ends-->
  <!-- loader-->
  <div class="loader-wrapper">
    <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
  </div>
  <!-- login page start-->
  <div class="container-fluid p-0">
    <div class="row m-0">
      <div class="col-12 p-0">
        <div class="login-card login-dark">
          <div>
            <div><a class="logo" href="index.php">
                <img class="img-fluid for-light m-auto" src="assets/images/bansalan.png" alt="loginpage" style="width: 200px; height: auto;">
                <img class="img-fluid for-dark" src="assets/images/bansalan.png" alt="logo" style="width: 200px; height: auto;">
              </a></div>
            <div class="login-main">
              <form class="theme-form" method="POST" action="">
                <h2 class="text-center">Verify OTP</h2>
                <p class="text-center">Enter the OTP sent to your email</p>
                <div class="form-group">
                  <label class="col-form-label">OTP</label>
                  <input class="form-control" type="text" name="otp" required="" placeholder="Enter OTP">
                </div>
                <div class="text-end mt-3">
                  <button class="btn btn-primary btn-block w-100" name="verify_otp" type="submit">Verify OTP</button>
                </div>
                <div class="mt-3 text-center">
                  <a href="forgot-password.php">Request New OTP</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- jquery-->
  <script src="assets/js/vendors/jquery/jquery.min.js"></script>
  <!-- bootstrap js-->
  <script src="assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js" defer=""></script>
  <script src="assets/js/vendors/bootstrap/dist/js/popper.min.js" defer=""></script>
  <!--fontawesome-->
  <script src="assets/js/vendors/font-awesome/fontawesome-min.js"></script>
  <!-- custom script -->
  <script src="assets/js/script.js"></script>
  
  <!-- Loader script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Hide loader when page is fully loaded
      window.addEventListener('load', function() {
        const loaderWrapper = document.querySelector('.loader-wrapper');
        if (loaderWrapper) {
          loaderWrapper.classList.add('hidden');
          // Remove loader from DOM after transition
          setTimeout(() => {
            loaderWrapper.remove();
          }, 300);
        }
      });

      // Show loader again when form is submitted
      const loginForm = document.querySelector('.theme-form');
      if (loginForm) {
        loginForm.addEventListener('submit', function() {
          const loaderWrapper = document.querySelector('.loader-wrapper');
          if (loaderWrapper) {
            loaderWrapper.classList.remove('hidden');
          }
        });
      }
    });
  </script>
</body>

</html> 