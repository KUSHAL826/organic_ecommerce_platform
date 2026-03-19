<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "config.php";


require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';
require __DIR__ . '/PHPMailer/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(!isset($_POST['email'])){
    echo "Invalid access";
    exit();
}

$email = $_POST['email'];

$otp = rand(100000,999999);
$expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

$result = $conn->query("SELECT * FROM users WHERE email='$email'");

if($result->num_rows > 0){

    $conn->query("UPDATE users SET otp_code='$otp', otp_expiry='$expiry' WHERE email='$email'");
    $_SESSION['reset_email'] = $email;

   
    $mail = new PHPMailer(true);

    try {
        /* SMTP SETTINGS */
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        $mail->Username = 'kushalyngowda@gmail.com';
        $mail->Password = 'wigcigmnpougopgw'; 

        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

       
        $mail->setFrom('kushalyngowda@gmail.com', 'OTP RESET - ORGANIC FOODS');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "OTP for Password Reset";
        $mail->Body = "<h3>Your OTP is: <b>$otp</b></h3>";

        $mail->send();

        echo "<script>
        alert('OTP sent to your email');
        window.location='verify-otp.php';
        </script>";

    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }

} else {
    echo "<script>
    alert('Email not found');
    window.location='forgot-password.php';
    </script>";
}
?>