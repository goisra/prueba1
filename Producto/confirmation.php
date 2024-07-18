<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['order_id'];

$query = "SELECT * FROM orders WHERE id='$order_id'";
$result = mysqli_query($conn, $query);
$order = mysqli_fetch_assoc($result);

$query = "SELECT products.name, order_items.quantity, order_items.price FROM order_items 
          JOIN products ON order_items.product_id = products.id 
          WHERE order_items.order_id = '$order_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Pedido</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <h1>Confirmación de Pedido</h1>
    <h2>Pedido #<?php echo $order['id']; ?></h2>
    <p>Total: $<?php echo $order['total']; ?></p>
    <h3>Productos:</h3>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <li><?php echo $row['name']; ?> (<?php echo $row['quantity']; ?>) - $<?php echo $row['price']; ?></li>
        <?php endwhile; ?>
    </ul>
    <a href="products.php">Volver a la tienda</a>
</body>
</html>
