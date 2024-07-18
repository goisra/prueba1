<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT SUM(products.price * cart.quantity) AS total FROM cart 
          JOIN products ON cart.product_id = products.id 
          WHERE cart.user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$total = $row['total'];

$query = "INSERT INTO orders (user_id, total) VALUES ('$user_id', '$total')";
mysqli_query($conn, $query);

$order_id = mysqli_insert_id($conn);

$query = "SELECT cart.product_id, cart.quantity, products.price FROM cart 
          JOIN products ON cart.product_id = products.id 
          WHERE cart.user_id = '$user_id'";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];
    $price = $row['price'];
    $query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
              VALUES ('$order_id', '$product_id', '$quantity', '$price')";
    mysqli_query($conn, $query);
}

$query = "DELETE FROM cart WHERE user_id = '$user_id'";
mysqli_query($conn, $query);

header("Location: confirmation.php?order_id=$order_id");
?>
