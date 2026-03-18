<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="navbar">
    <div class="logo-area">
        <img src="logo.jpg" class="logo">
        <h2>VISIONARY MINDS</h2>
    </div>

    <div class="nav-links">
        <a href="index.html">Home</a>
        <a href="login.php">User Login</a>
        <a href="admin-login.php">Admin Login</a>
        <a href="about.html">About Us</a>
    </div>
</div>

<div class="login-box">
<h2>Admin Login</h2>

<?php
session_start();
include "config.php"; // Your database connection

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check admin table
    $sql = "SELECT * FROM admins WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        // ✅ Plain text password check
        if($password === $row['password']){
            $_SESSION['admin_email'] = $email;
            header("Location: admin-dashboard.php");
            exit();
        } else {
            echo "<h3 style='color:red; text-align:center;'>Wrong password.</h3>";
        }

    } else {
        echo "<h3 style='color:red; text-align:center;'>Admin not found.</h3>";
    }
}
?>

<form method="POST">
<input type="email" name="email" placeholder="Enter Admin Email" required>
<input type="password" name="password" placeholder="Enter Password" required>
<button type="submit">Login</button>
</form>

</div>

</body>
</html>