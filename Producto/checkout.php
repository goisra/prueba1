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

$query = "SELECT c.id, p.name, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $query);

$total = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $total += $row['price'] * $row['quantity'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "INSERT INTO orders (user_id, total) VALUES ($user_id, $total)";
    mysqli_query($conn, $query);
    $order_id = mysqli_insert_id($conn);

    $query = "SELECT c.id, p.id as product_id, p.price, c.quantity FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = $user_id";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)";
        mysqli_query($conn, $query);
    }

    $query = "DELETE FROM cart WHERE user_id = $user_id";
    mysqli_query($conn, $query);

    echo "Compra realizada con éxito. Gracias por su compra.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pago</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <h1>Proceder al Pago</h1>
    <h2>Total: $<?php echo $total; ?></h2>
    <form method="post" action="checkout.php">
        <button type="submit">Pagar</button>
    </form>
    <a href="cart.php">Regresar al Carrito</a>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
