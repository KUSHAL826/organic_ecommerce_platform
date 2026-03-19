<?php
session_start();
if(!isset($_SESSION['user_email'])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .thankyou-container {
            max-width: 500px;
            margin: 100px auto;
            text-align: center;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .thankyou-container h2 {
            color: #2c7a7b;
            margin-bottom: 20px;
        }
        .thankyou-container p {
            font-size: 16px;
            margin-bottom: 25px;
        }
        .back-dashboard-btn {
            display: inline-block;
            background: #2c7a7b;
            color: #fff;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .back-dashboard-btn:hover {
            background: #15606c;
        }
    </style>
</head>
<body>
    <div class="thankyou-container">
        <h2>Thank You for Your Order!</h2>
        <p>We will deliver your items within the next 10 minutes.</p>
        <a href="dashboard.php" class="back-dashboard-btn">Go to Dashboard</a>
    </div>
</body>
</html>