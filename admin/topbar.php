<?php
// Add cache control headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// session_start();
include '../sql/sql.php';

// Stronger session validation
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: ../login.php");
    exit();
}

// Validate user type for admin section
if($_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<header class="page-header row">
        <div class="logo-wrapper d-flex align-items-center col-auto"><a href="index.html"><img class="light-logo img-fluid"  alt="logo"/><img class="dark-logo img-fluid" src="../assets/images/logo/logo1.png" alt="logo"/></a><a class="close-btn toggle-sidebar" href="javascript:void(0)">
            <svg class="svg-color">
              <use href="../assets/svg/iconly-sprite.svg#Category"></use>
            </svg></a></div>
        <div class="page-main-header col">
          <div class="header-left">
            <form class="form-inline search-full col" action="#" method="get">
              <div class="form-group w-100">
                <div class="Typeahead Typeahead--twitterUsers">
                  <div class="u-posRelative">
                    <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Admiro .." name="q" title="" autofocus="autofocus"/>
                    <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                  </div>
                  <div class="Typeahead-menu"></div>
                </div>
              </div>
            </form>
          </div>
          <div class="nav-right">
            <ul class="header-right"> 
              
              <li class="search d-lg-none d-flex"> <a href="javascript:void(0)">
                  <svg>
                    <use href="../assets/svg/iconly-sprite.svg#Search"></use>
                  </svg></a></li>
              
              <li><a class="full-screen" href="javascript:void(0)"> 
                  <svg>
                    <use href="../assets/svg/iconly-sprite.svg#scanfull"></use>
                  </svg></a></li>
              <li class="profile-nav custom-dropdown">
                <div class="user-wrap">
                  <div class="user-img"><img src="../assets/images/profile.png" alt="user"/></div>
                  <div class="user-content">
                    <h6><?php echo ucfirst($_SESSION['username']); ?></h6>
                    <p class="mb-0"><?php 
                      if($_SESSION['user_type'] == 'admin') {
                        echo "Administrator";
                      } else {
                        echo "Regular User";
                      }
                    ?><i class="fa-solid fa-chevron-down"></i></p>
                  </div>
                </div>
                <div class="custom-menu overflow-hidden">
                  <ul class="profile-body">
                    <!-- <li class="d-flex"> 
                      <svg class="svg-color">
                        <use href="../assets/svg/iconly-sprite.svg#Profile"></use>
                      </svg><a class="ms-2" href="user-profile.html">Account</a>
                    </li> -->
                    
                    <li class="d-flex"> 
                      <svg class="svg-color">
                        <use href="../assets/svg/iconly-sprite.svg#Login"></use>
                      </svg><a class="ms-2" href="../logout.php">Log Out</a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
</header>