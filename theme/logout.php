<?php
// Initialize the session
session_start();
unset($_SESSION['user']);
session_destroy();  // closes the session
header('location: index.php'); // redirects to home page 
?>