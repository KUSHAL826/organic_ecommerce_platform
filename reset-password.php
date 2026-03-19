<?php
session_start();
include "config.php";

if(!isset($_SESSION['reset_email'])){
    echo "Session expired. Try again.";
    exit();
}

$email = $_SESSION['reset_email'];

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $pass = $_POST['password'];
    $cpass = $_POST['confirm_password'];

    if($pass !== $cpass){
        $error = "Passwords do not match!";
    } else {

        $newpass = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "UPDATE users 
        SET password='$newpass',
        otp_code=NULL,
        otp_expiry=NULL
        WHERE email='$email'";

        if($conn->query($sql)){
            session_destroy();

            echo "<script>
            alert('Password Updated Successfully');
            window.location='login.php';
            </script>";
        } else {
            $error = "Error updating password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>

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
    width:350px;
    text-align:center;
}

h2{
    margin-bottom:20px;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #aaa;
    border-radius:5px;
    font-size:16px;
}

button{
    width:100%;
    padding:12px;
    background:green;
    color:white;
    border:none;
    font-size:16px;
    cursor:pointer;
    margin-top:10px;
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

<h2>Reset Password</h2>

<?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

<form method="POST">

<input type="password" name="password" placeholder="New Password" required>

<input type="password" name="confirm_password" placeholder="Confirm Password" required>

<button type="submit">Update Password</button>

</form>

</div>

</body>
</html>