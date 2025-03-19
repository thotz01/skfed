<?php
ob_start(); // Start output buffering
session_start();

// Add cache control headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include 'sql/sql.php';


// Redirect if no reset email in session or OTP not verified
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot-password.php");
    exit();
}

// Store the form submission result to show after scripts are loaded
$showAlert = false;
$alertType = '';
$alertTitle = '';
$alertText = '';

if (isset($_POST['reset_password'])) {
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $email = $_SESSION['reset_email'];

    if ($new_password !== $confirm_password) {
        $showAlert = true;
        $alertType = 'error';
        $alertTitle = 'Error!';
        $alertText = 'Passwords do not match!';
    } else {
        // Update password in database
        $update_query = "UPDATE residents SET password = '$new_password' WHERE email = '$email'";
        if (mysqli_query($conn, $update_query)) {
            // Clear all reset-related session variables
            unset($_SESSION['reset_email']);
            unset($_SESSION['reset_otp']);
            unset($_SESSION['otp_expiry']);
            
            $showAlert = true;
            $alertType = 'success';
            $alertTitle = 'Success!';
            $alertText = 'Password has been successfully reset';
            $redirectToLogin = true;
        } else {
            $showAlert = true;
            $alertType = 'error';
            $alertTitle = 'Error!';
            $alertText = 'Error updating password. Please try again.';
        }
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
  <title>Reset Password</title>
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
  <!-- Add SweetAlert2 CSS and JS in the head section -->
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

    /* Add these loader styles */
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

    .show-hide {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .show-hide .show {
        width: 20px;
        height: 20px;
        display: block;
        background-image: url('assets/images/eye.png'); /* Make sure to have this icon */
        background-size: contain;
        background-repeat: no-repeat;
    }

    .show-hide .show.hide {
        background-image: url('assets/images/eye-slash.png'); /* Make sure to have this icon */
    }

    .password-strength {
        margin-top: 5px;
        font-size: 12px;
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
              <form class="theme-form" method="POST" action="" onsubmit="return validateForm()">
                <h2 class="text-center">Reset Password</h2>
                <p class="text-center">Enter your new password</p>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="form-group">
                  <label class="col-form-label">New Password</label>
                  <div class="form-input position-relative">
                    <input class="form-control" type="password" name="new_password" id="new_password" 
                           required="" placeholder="Enter new password">
                    <div class="show-hide" onclick="togglePassword('new_password')">
                      <span class="show"></span>
                    </div>
                  </div>
                  <div class="password-strength" id="password-strength"></div>
                </div>

                <div class="form-group">
                  <label class="col-form-label">Confirm Password</label>
                  <div class="form-input position-relative">
                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" 
                           required="" placeholder="Confirm new password">
                    <div class="show-hide" onclick="togglePassword('confirm_password')">
                      <span class="show"></span>
                    </div>
                  </div>
                </div>

                <div class="text-end mt-3">
                  <button class="btn btn-primary btn-block w-100" name="reset_password" type="submit">
                    Reset Password
                  </button>
                </div>
              </form>
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
    <!-- password_show-->
    <script src="assets/js/password.js"></script>
    <!-- custom script -->
    <script src="assets/js/script.js"></script>
    
    <!-- Replace the existing loader script with this one -->
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

    <script>
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const showHideSpan = passwordInput.nextElementSibling.querySelector('.show');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showHideSpan.classList.add('hide');
        } else {
            passwordInput.type = 'password';
            showHideSpan.classList.remove('hide');
        }
    }

    function validateForm() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (newPassword !== confirmPassword) {
            alert('Passwords do not match!');
            return false;
        }

        // Add password strength validation if needed
        if (newPassword.length < 8) {
            alert('Password must be at least 8 characters long!');
            return false;
        }

        return true;
    }

    // Optional: Add password strength indicator
    document.getElementById('new_password').addEventListener('input', function() {
        const password = this.value;
        const strengthDiv = document.getElementById('password-strength');
        let strength = 0;
        let message = '';

        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[$@#&!]+/)) strength++;

        switch (strength) {
            case 0:
            case 1:
                message = '<span style="color: red">Very Weak</span>';
                break;
            case 2:
                message = '<span style="color: orange">Weak</span>';
                break;
            case 3:
                message = '<span style="color: yellow">Medium</span>';
                break;
            case 4:
                message = '<span style="color: green">Strong</span>';
                break;
            case 5:
                message = '<span style="color: darkgreen">Very Strong</span>';
                break;
        }

        strengthDiv.innerHTML = 'Password Strength: ' + message;
    });
    </script>

    <!-- Add this before closing body tag -->
    <?php if ($showAlert): ?>
    <script>
        Swal.fire({
            icon: '<?php echo $alertType; ?>',
            title: '<?php echo $alertTitle; ?>',
            text: '<?php echo $alertText; ?>',
            confirmButtonColor: '#3085d6',
            confirmButtonText: '<?php echo isset($redirectToLogin) ? "Login" : "OK"; ?>'
        }).then((result) => {
            <?php if (isset($redirectToLogin)): ?>
            if (result.isConfirmed) {
                window.location.href = 'login.php';
            }
            <?php endif; ?>
        });
    </script>
    <?php endif; ?>
  </div>
</body>

</html>

<?php ob_end_flush(); // End output buffering ?>