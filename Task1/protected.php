<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Only admins can access this page
if ($_SESSION['role'] != 'admin') {
    echo "Access denied! Admins only.";
    exit();
}

echo "Welcome, " . $_SESSION['username'];
?>

<a href="logout.php">Logout</a>
