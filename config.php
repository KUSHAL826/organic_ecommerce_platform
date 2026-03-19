<?php
$servername = "sql306.infinityfree.com"; 
$username = "if0_41424420";              
$password = "KUShal12yn";                
$database = "if0_41424420_organic_platform";   

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
