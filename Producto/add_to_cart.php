<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'user') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT id FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$user_id = $user['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id";
    } else {
        $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
    }
    mysqli_query($conn, $query);
}

header("Location: user.php");
?>
