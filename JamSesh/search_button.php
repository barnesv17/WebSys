<?php
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION["search_studios"] = array();

// Redirect to login page
header("location: search.php");
exit;
?>
