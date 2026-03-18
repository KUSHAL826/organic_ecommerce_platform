<?php
session_start();
include "config.php";

// Only logged-in users
if(!isset($_SESSION['user_email'])){
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Initialize cart
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Add or update cart
if(isset($_POST['add_to_cart'])){
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $weight = floatval($_POST['weight']);

    $found = false;
    foreach($_SESSION['cart'] as &$item){
        if($item['name'] == $name){
            $item['weight'] = $weight;
            $item['total'] = $weight * $price;
            $found = true;
            break;
        }
    }
    if(!$found){
        $_SESSION['cart'][] = [
            'name'=>$name,
            'price'=>$price,
            'weight'=>$weight,
            'total'=>$price*$weight
        ];
    }

    $success_msg = "$name added/updated in cart!";
}

// Update cart weight
if(isset($_POST['update_cart'])){
    $index = $_POST['index'];
    $weight = floatval($_POST['weight']);
    $_SESSION['cart'][$index]['weight'] = $weight;
    $_SESSION['cart'][$index]['total'] = $weight*$_SESSION['cart'][$index]['price'];
}

// Remove item
if(isset($_POST['remove_cart'])){
    $index = $_POST['index'];
    array_splice($_SESSION['cart'],$index,1);
}

$products = $conn->query("SELECT * FROM products LIMIT 30");

// Fetch user orders
$orders = $conn->query("SELECT * FROM orders WHERE user_email='$user_email' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>User Dashboard</title>
<link rel="stylesheet" href="style.css">
<style>
/* Added Remove button class */
.remove-btn{
    padding:5px 8px;
    background:#d32f2f;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
.remove-btn:hover{
    background:#b71c1c;
}

/* Order table styles */
.user-orders { margin-top:40px; background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
.user-orders table{ width:100%; border-collapse: collapse; }
.user-orders th, .user-orders td { border:1px solid #ccc; padding:10px; text-align:center; }
.user-orders th { background:#ffeb3b; font-weight:bold; }
.status-pending { color:red; font-weight:bold; }
.status-confirmed { color:blue; font-weight:bold; }
.status-delivered { color:green; font-weight:bold; }

</style>
</head>
<body>
<div class="navbar">

<div class="logo-area">

<img src="logo.jpg" class="logo">

<h2>VISIONARY MINDS</h2>

</div>

<div class="nav-links">

<a href="index.html">Home</a>
<a href="login.php">User Login</a>
<a href="admin-login.php">Admin Login</a>
<a href="about.html">About Us</a>

</div>

</div>

<div class="container">
    <h2>Available Products</h2>
    <?php if(isset($success_msg)) echo "<p class='success-msg'>$success_msg</p>"; ?>
    <div class="product-grid">
        <?php while($row = $products->fetch_assoc()){
            $in_cart = false;
            $current_weight = 1;
            foreach($_SESSION['cart'] as $item){
                if($item['name'] == $row['name']){
                    $in_cart = true;
                    $current_weight = $item['weight'];
                    break;
                }
            }
        ?>
        <div class="product-card">
            <div class="product-image">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <?php if($in_cart) echo "<div class='added-badge'>Added ✅</div>"; ?>
            </div>
            <div class="product-info">
                <h4><?php echo $row['name']; ?></h4>
                <p>₹<?php echo $row['price']; ?> per kg</p>
                <form method="POST" class="add-cart-form">
                    <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                    <input type="number" name="weight" min="0.1" step="0.1" value="<?php echo $current_weight; ?>" required> kg
                    <button type="submit" name="add_to_cart" class="add-btn"><?php echo $in_cart?'Update':'Add to Cart'; ?></button>
                </form>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- Cart -->
    <div class="cart-box">
        <h2>Your Cart</h2>
        <?php if(count($_SESSION['cart'])>0){ ?>
        <table class="cart-table">
            <tr>
                <th>Product</th><th>Price</th><th>Weight</th><th>Total</th><th>Action</th>
            </tr>
            <?php $total_amount=0; foreach($_SESSION['cart'] as $index=>$item){
                $total_amount += $item['total'];
            ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td>₹<?php echo $item['price']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <input type="number" name="weight" min="0.1" step="0.1" value="<?php echo $item['weight']; ?>" style="width:60px">
                        <button type="submit" name="update_cart" class="add-btn">Update</button>
                    </form>
                </td>
                <td>₹<?php echo $item['total']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" name="remove_cart" class="remove-btn">Remove</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
            <tr><th colspan="3">Total</th><th>₹<?php echo $total_amount; ?></th><th></th></tr>
        </table>
        <div style="text-align:center; margin-top:20px;">
        <a href="checkout.php" class="checkout-btn" style="text-decoration:none; display:inline-block;">Proceed to Checkout</a>
        </div>
        <?php } else { echo "<p>Cart is empty</p>"; } ?>
    </div>

    <!-- User Orders -->
    <div class="user-orders">
        <h2>Your Orders</h2>
        <?php if($orders->num_rows>0){ ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
            <?php while($order = $orders->fetch_assoc()){
                $status_class = strtolower($order['status']);
            ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td>₹<?php echo $order['total_amount']; ?></td>
                <td class="status-<?php echo $status_class; ?>"><?php echo $order['status']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } else { echo "<p>No orders yet.</p>"; } ?>
    </div>
</div>
</body>
</html>