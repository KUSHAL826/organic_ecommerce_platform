<?php
session_start();
include "config.php";

if(!isset($_SESSION['user_email']) || !isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
    header("Location: dashboard.php");
    exit();
}

$user_email = $_SESSION['user_email'];

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['confirm_booking'])){
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $street = $conn->real_escape_string($_POST['street']);
    $area = $conn->real_escape_string($_POST['area']);
    $city = $conn->real_escape_string($_POST['city']);
    $pincode = $conn->real_escape_string($_POST['pincode']);

    $total_amount = 0;
    foreach($_SESSION['cart'] as $item) $total_amount += $item['total'];

    // Insert order
    $conn->query("INSERT INTO orders 
        (user_email, full_name, phone, street, area, city, pincode, total_amount, status) 
        VALUES 
        ('$user_email', '$full_name', '$phone', '$street', '$area', '$city', '$pincode', $total_amount, 'Pending')"
    );

    $order_id = $conn->insert_id;

    // Insert products
    foreach($_SESSION['cart'] as $item){
        $product_name = $conn->real_escape_string($item['name']);
        $price = $item['price'];
        $weight = $item['weight'];
        $total = $item['total'];

        $conn->query("INSERT INTO order_items
            (order_id, product_name, price, weight, total)
            VALUES
            ($order_id, '$product_name', $price, $weight, $total)"
        );
    }

    $_SESSION['cart'] = [];
    header("Location: thankyou.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .checkout-form{ max-width:400px; margin:20px auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 6px rgba(0,0,0,0.1);}
    .checkout-form .form-group{ margin-bottom:15px; }
    .checkout-form input, .checkout-form textarea{ width:100%; padding:10px; border-radius:5px; border:1px solid #ccc; }
    .checkout-btn{ display:inline-block; background:#2c7a7b; color:#fff; padding:12px 20px; border-radius:8px; border:none; cursor:pointer; text-align:center; font-weight:bold;}
    .checkout-btn:hover{ background:#15606c; }

    .cart-summary{ max-width:600px; margin:20px auto; padding:20px; background:#f9f9f9; border-radius:10px; box-shadow:0 3px 5px rgba(0,0,0,0.1);}
    .cart-summary h3{ margin-bottom:15px; text-align:center; }
    .cart-summary table{ width:100%; border-collapse:collapse; }
    .cart-summary th, .cart-summary td{ border:1px solid #ccc; padding:8px; text-align:center; }
    .cart-summary th{ background:#2c7a7b; color:#fff; }
    </style>
</head>
<body>
<div class="navbar">
    <div class="logo-area">
        <img src="logo.jpg" class="logo">
        <h2>VISIONARY MINDS</h2>
    </div>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <!-- Cart Summary -->
    <div class="cart-summary">
        <h3>Your Cart</h3>
        <?php if(count($_SESSION['cart']) > 0){ ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Price/kg</th>
                <th>Weight (kg)</th>
                <th>Total</th>
            </tr>
            <?php 
            $total_amount = 0;
            foreach($_SESSION['cart'] as $item){
                echo "<tr>
                        <td>{$item['name']}</td>
                        <td>₹{$item['price']}</td>
                        <td>{$item['weight']}</td>
                        <td>₹{$item['total']}</td>
                      </tr>";
                $total_amount += $item['total'];
            }
            ?>
            <tr>
                <th colspan="3">Total Amount</th>
                <th>₹<?php echo $total_amount; ?></th>
            </tr>
        </table>
        <?php } else { echo "<p>Your cart is empty.</p>"; } ?>
    </div>

    <!-- Shipping Form -->
    <div class="checkout-form">
        <h2>Shipping Details</h2>
        <?php if(isset($success_msg)) echo "<p class='success-msg'>$success_msg</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" required>
            </div>
            <div class="form-group">
                <label>Street</label>
                <input type="text" name="street" required>
            </div>
            <div class="form-group">
                <label>Area</label>
                <input type="text" name="area" required>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" required>
            </div>
            <div class="form-group">
                <label>Pincode</label>
                <input type="text" name="pincode" required>
            </div>
            <button type="submit" name="confirm_booking" class="checkout-btn">Confirm Booking</button>
        </form>
    </div>

</div>
</body>
</html>