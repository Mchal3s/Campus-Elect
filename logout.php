<?php
session_start();
session_unset();  // remove all session variables
session_destroy(); // destroy the session

// Optional: prevent cached dashboard from showing
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Redirect to landing page
header("Location: landing.php");
exit();
?>
    