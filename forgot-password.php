<?php
ob_start(); // Start output buffering
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Add cache control headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include 'sql/sql.php';

// Check if already logged in
if(isset($_SESSION['user_id'])) {
    if($_SESSION['user_type'] == 'admin') {
        header("Location: admin/dashboard.php");
        exit();
    } else {
        header("Location: user/dashboard.php");
        exit();
    }
}

// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999);
}

if (isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists
    $query = "SELECT * FROM residents WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Generate OTP first
        $otp = generateOTP();
        $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Store OTP in session
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['otp_expiry'] = $expiry;

        // Create email HTML template
        $emailTemplate = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    line-height: 1.6;
                    color: #333333;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    text-align: center;
                }
                .logo {
                    margin-bottom: 30px;
                }
                .logo img {
                    width: 200px;
                    height: auto;
                }
                .title {
                    font-size: 32px;
                    font-weight: bold;
                    margin-bottom: 20px;
                    color: #333;
                }
                .message {
                    font-size: 16px;
                    margin-bottom: 30px;
                    color: #666;
                    padding: 0 20px;
                }
                .otp-container {
                    background-color: #e8f5f3;
                    padding: 20px;
                    margin: 20px auto;
                    border-radius: 5px;
                    max-width: 300px;
                }
                .otp-code {
                    font-size: 36px;
                    font-weight: bold;
                    letter-spacing: 5px;
                    color: #000;
                    font-family: monospace;
                }
                .validity {
                    font-size: 14px;
                    color: #666;
                    margin-top: 15px;
                }
                .footer {
                    margin-top: 40px;
                    font-size: 14px;
                    color: #666;
                }
                .contact {
                    margin-top: 20px;
                }
                .contact a {
                    color: #0066cc;
                    text-decoration: none;
                }
                .address {
                    margin-top: 20px;
                    color: #999;
                    font-size: 12px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="logo">
                    <img src="https://bansalangeomap/assets/images/bansalan.png" alt="Logo">
                </div>
                <h1 class="title">Confirm your email address</h1>
                <p class="message">Your confirmation code is below - enter it in your open browser window and we\'ll help you reset your password.</p>
                
                <div class="otp-container">
                    <div class="otp-code">' . $otp . '</div>
                </div>
                
                <p class="validity">This code is valid for the next 15 minutes.</p>
                
                <p class="security-note">If you didn\'t request this email, there\'s nothing to worry about, you can safely ignore it.</p>
                
                <div class="footer">
                    <div class="address">
                        Municipality of Bansalan<br>
                        Contact us - Your Phone Number
                    </div>
                </div>
            </div>
        </body>
        </html>
        ';

        try {
            $mail = new PHPMailer(true);
            
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thotchietanggaan123@gmail.com';
            $mail->Password = 'iuvt uvws rokf dive';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('bansalanofficial@gmail.com', 'System Developer');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Verification Code';
            $mail->Body = $emailTemplate;
            $mail->AltBody = "Your OTP for password reset is: $otp\nThis OTP will expire in 15 minutes.";

            $mail->send();
            
            // Redirect to OTP verification page
            header("Location: verify-otp.php");
            exit();

        } catch (Exception $e) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}'
                });
            </script>";
        }
    } else {
        // Show same message even if email doesn't exist (security best practice)
        echo "<div class='alert alert-info mt-3'>If an account exists with this email address, you will receive an OTP shortly.</div>";
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
  <title>Login</title>
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
                <h2 class="text-center">Forgot Password</h2>
                <p class="text-center">Enter your email address to reset password</p>
                <div class="form-group">
                  <label class="col-form-label">Email Address</label>
                  <input class="form-control" type="email" name="email" required="" placeholder="Enter your email">
                </div>
                <div class="text-end mt-3">
                  <button class="btn btn-primary btn-block w-100" name="reset" type="submit">Reset Password</button>
                </div>
                <div class="mt-3 text-center">
                  <a href="index.php">Back to Login</a>
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
    function togglePassword() {
        const passwordInput = document.querySelector('input[name="password"]');
        const showHideSpan = document.querySelector('.show-hide .show');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showHideSpan.classList.add('hide');
        } else {
            passwordInput.type = 'password';
            showHideSpan.classList.remove('hide');
        }
    }

    // Add cursor pointer to show it's clickable
    document.querySelector('.show-hide').style.cursor = 'pointer';
    </script>
  </div>
</body>

</html>

<?php ob_end_flush(); // End output buffering ?>