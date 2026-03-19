<?php
session_start();
include "config.php";

if(!isset($_SESSION['reset_email'])){
    echo "Session expired. Try again.";
    exit();
}

$email = $_SESSION['reset_email'];

if(isset($_POST['otp'])){

    $otp = $_POST['otp'];

    $result = $conn->query("SELECT * FROM users 
    WHERE email='$email' AND otp_code='$otp'");

    if($result->num_rows > 0){

        $row = $result->fetch_assoc();

        if(strtotime($row['otp_expiry']) > time()){

            // Clear OTP
            $conn->query("UPDATE users SET otp_code=NULL, otp_expiry=NULL WHERE email='$email'");

            header("Location: reset-password.php");
            exit();

        } else {
            $error = "OTP Expired";
        }

    } else {
        $error = "Invalid OTP";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify OTP</title>

<style>
body{
    font-family: Arial;
    background: #d3d3d3; 
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.container{
    background:#eee;
    padding:40px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.2);
    text-align:center;
    width:350px;
}

h2{
    margin-bottom:20px;
    font-size:26px;
    font-weight:bold;
}

input{
    width:100%;
    padding:12px;
    margin:12px 0;
    border-radius:5px;
    border:1px solid #aaa;
    font-size:16px;
}

button{
    width:100%;
    padding:12px;
    background:green;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:16px;
}

button:hover{
    background:darkgreen;
}

.error{
    color:red;
    margin-bottom:10px;
}
</style>

</head>
<body>

<div class="container">

<h2>Enter OTP</h2>

<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

<form method="POST">
<input type="number" name="otp" placeholder="Enter OTP" required>
<button type="submit">Verify</button>
</form>

</div>

</body>
</html>