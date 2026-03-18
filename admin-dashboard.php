<?php
session_start();
include "config.php";

if(!isset($_SESSION['admin_email'])){
    header("Location: admin-login.php");
    exit();
}

// Handle status update
if(isset($_POST['update_status'])){
    $order_id = intval($_POST['order_id']);
    $new_status = $_POST['status'];
    $conn->query("UPDATE orders SET status='$new_status' WHERE id=$order_id");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link rel="stylesheet" href="style.css">
<style>
.admin-container{width:90%; margin:20px auto;}
.admin-table{width:100%; border-collapse: collapse;}
.admin-table th, .admin-table td{border:1px solid #ccc; padding:10px; text-align:center;}
.admin-table th{background:yellow; color:#000;}
.status-pending{color:red;font-weight:bold;}
.status-confirmed{color:orange;font-weight:bold;}
.status-delivered{color:green;font-weight:bold;}
.update-btn{padding:5px 10px; border:none; border-radius:5px; cursor:pointer; background:#2c7a7b; color:#fff;}
.update-btn:hover{background:#1565c0;}
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

<div class="admin-container">
<h2>Admin Dashboard - All Orders</h2>
<table class="admin-table">
<tr>
    <th>Order ID</th>
    <th>User Email</th>
    <th>Full Name</th>
    <th>Phone</th>
    <th>Address</th>
    <th>Products</th>
    <th>Total Amount</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
$orders = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
if($orders->num_rows > 0){
    while($order = $orders->fetch_assoc()){
        // Fetch products for this order
        $items = $conn->query("SELECT * FROM order_items WHERE order_id={$order['id']}");
        $products_html = "<ul>";
        while($item = $items->fetch_assoc()){
            $products_html .= "<li>{$item['product_name']} ({$item['weight']}kg)</li>";
        }
        $products_html .= "</ul>";

        $status_class = "status-" . strtolower($order['status']);
        echo "<tr>
                <td>{$order['id']}</td>
                <td>{$order['user_email']}</td>
                <td>{$order['full_name']}</td>
                <td>{$order['phone']}</td>
                <td>{$order['street']}, {$order['area']}, {$order['city']}, {$order['pincode']}</td>
                <td>$products_html</td>
                <td>₹{$order['total_amount']}</td>
                <td class='$status_class'>{$order['status']}</td>
                <td>";
        if($order['status'] == "Pending"){
            echo "<form method='POST'>
                    <input type='hidden' name='order_id' value='{$order['id']}'>
                    <input type='hidden' name='status' value='Confirmed'>
                    <button type='submit' name='update_status' class='update-btn'>Mark Confirmed</button>
                  </form>";
        } elseif($order['status'] == "Confirmed"){
            echo "<form method='POST'>
                    <input type='hidden' name='order_id' value='{$order['id']}'>
                    <input type='hidden' name='status' value='Delivered'>
                    <button type='submit' name='update_status' class='update-btn'>Mark Delivered</button>
                  </form>";
        } else {
            echo "—";
        }
        echo "</td></tr>";
    }
} else {
    echo "<tr><td colspan='9'>No orders found.</td></tr>";
}
?>
</table>
</div>
</body>
</html>