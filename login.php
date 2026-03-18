<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        // Check hashed password if stored using password_hash
        if(password_verify($password, $row['password'])){
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error_msg = "Wrong password";
        }

    } else {
        $error_msg = "User not found";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Login</title>
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
    <h2>User Login</h2>

    <?php 
    if(isset($error_msg)){
        echo "<p style='color:red; text-align:center;'>$error_msg</p>";
    }
    ?>

    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p><a href="forgot-password.php">Forgot Password?</a></p>
    <p>New user? <a href="signup.php">Signup</a></p>
</div>

</body>
</html>