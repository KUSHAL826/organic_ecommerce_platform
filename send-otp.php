<?php
session_start();
include "config.php";
include "navbar.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';


if(!isset($_POST['email'])){
    echo "<h3 class='message-error' style='text-align:center;'>Invalid access. Please use the form.</h3>";
    exit();
}


$email = mysqli_real_escape_string($conn, $_POST['email']);


$otp = rand(100000, 999999);
$expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));


$sql = "SELECT * FROM farmers WHERE email='$email'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<title>Send OTP</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<?php
if($result->num_rows > 0){

 
    $conn->query("UPDATE farmers SET otp_code='$otp', otp_expiry='$expiry' WHERE email='$email'");
    $_SESSION['reset_email'] = $email;

    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kushalyngowda136@gmail.com';
        $mail->Password = 'rhhoysyvdmqbpzzw'; // ⚠️ keep private
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

   
        $mail->setFrom('kushalyngowda136@gmail.com', 'Smart Farming OTP System');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'OTP for Password Reset';
        $mail->Body = "<h3>Your OTP is: <b>$otp</b></h3>";

        $mail->send();

        echo "<div class='auth-container'>
                <div class='auth-box'>
                    <h2 class='message-success'>OTP sent to your email</h2>
                    <a href='verify-otp.php'>Enter OTP</a>
                </div>
              </div>";

    } catch (Exception $e) {
        echo "<div class='auth-container'>
                <div class='auth-box'>
                    <h2 class='message-error'>Mailer Error: {$mail->ErrorInfo}</h2>
                </div>
              </div>";
    }

} else {

    // ❌ EMAIL NOT FOUND
    echo "<div class='auth-container'>
            <div class='auth-box'>
                <h2 class='message-error'>Email not found</h2>
                <a href='forgot-password.html'>Try Again</a>
            </div>
          </div>";
}

$conn->close();
?>

</body>
</html>