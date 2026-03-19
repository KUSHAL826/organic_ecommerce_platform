<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<style>
body {
    font-family: Arial;
    background: #f4f7f9;
}
.box {
    background: white;
    padding: 30px;
    width: 300px;
    margin: 100px auto;
    border-radius: 10px;
    box-shadow: 0 0 10px #ccc;
    text-align: center;
}
input, button {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
}
button {
    background: green;
    color: white;
    border: none;
}
</style>

</head>
<body>

<div class="box">
<h2>Forgot Password</h2>

<form action="send-otp.php" method="POST">
<input type="email" name="email" placeholder="Enter Email" required>
<button type="submit">Send OTP</button>
</form>

<br>
<a href="farmer-login.html">Back to Login</a>

</div>

</body>
</html>