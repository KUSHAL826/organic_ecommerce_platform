<?php
include "config.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$email=$_POST['email'];

$otp=rand(100000,999999);
$expiry=date("Y-m-d H:i:s",strtotime("+5 minutes"));

$sql="UPDATE users SET otp_code='$otp',otp_expiry='$expiry' WHERE email='$email'";

$conn->query($sql);

echo "<script>alert('OTP: $otp');window.location='verify-otp.php?email=$email';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="login-box">

<h2>Forgot Password</h2>

<form method="POST">

<input type="email" name="email" placeholder="Enter Email" required>

<button type="submit">Send OTP</button>

</form>

</div>

</body>
</html>