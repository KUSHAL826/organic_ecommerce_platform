<?php
include "config.php";

$email=$_GET['email'];

if($_SERVER["REQUEST_METHOD"]=="POST"){

$otp=$_POST['otp'];

$sql="SELECT * FROM users 
WHERE email='$email'
AND otp_code='$otp'
AND otp_expiry>NOW()";

$result=$conn->query($sql);

if($result->num_rows>0){

header("Location: reset-password.php?email=$email");

}
else{
echo "<script>alert('Invalid OTP');</script>";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify OTP</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="login-box">

<h2>Verify OTP</h2>

<form method="POST">

<input type="text" name="otp" placeholder="Enter OTP" required>

<button type="submit">Verify OTP</button>

</form>

</div>

</body>
</html>