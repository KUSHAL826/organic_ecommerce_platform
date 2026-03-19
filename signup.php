<?php
session_start();
include "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    
    $check = "SELECT * FROM users WHERE email='$email'";
    $res = $conn->query($check);

    if($res->num_rows > 0){
        $error_msg = "Email already registered.";
    } else {
        
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$password_hashed')";
        if($conn->query($sql) === TRUE){
            $success_msg = "Signup successful! You can login now.";
        } else {
            $error_msg = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Signup</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="login-box">
<h2>User Signup</h2>

<?php 
if(isset($error_msg)) echo "<p style='color:red;text-align:center;'>$error_msg</p>";
if(isset($success_msg)) echo "<p style='color:green;text-align:center;'>$success_msg</p>";
?>

<form method="POST" action="">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Signup</button>
</form>

<p>Already have account? <a href="login.php">Login</a></p>
</div>
</body>
</html>