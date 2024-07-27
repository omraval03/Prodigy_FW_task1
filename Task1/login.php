<?php
session_start();
require 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password, $role);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        // Password is correct, start a session
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: protected.php");
    } else {
        echo "Invalid username or password!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- HTML form for login -->
<form method="POST" action="login.php">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
