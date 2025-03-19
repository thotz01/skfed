<?php
session_start();
session_destroy();

// Clear all session cookies
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Set cache-control headers to prevent back button access
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header("Location: index.php");
exit();
?>
