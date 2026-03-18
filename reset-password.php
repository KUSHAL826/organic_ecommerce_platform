<?php
include "config.php";

$email=$_GET['email'];

if($_SERVER["REQUEST_METHOD"]=="POST"){

$newpass=password_hash($_POST['password'],PASSWORD_DEFAULT);

$sql="UPDATE users 
SET password='$newpass',
otp_code=NULL,
otp_expiry=NULL
WHERE email='$email'";

$conn->query($sql);

echo "<script>alert('Password Updated');window.location='login.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="login-box">

<h2>Reset Password</h2>

<form method="POST">

<input type="password" name="password" placeholder="New Password" required>

<button type="submit">Update Password</button>

</form>

</div>

</body>
</html>