<?php
session_start();

// Optional: redirect if the user is not logged in
if (!isset($_SESSION['normal_user'])) {
    // Replace 'login.php' with your login page
    header("Location: login.php");
    exit();
}
?>