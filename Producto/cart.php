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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <h1>Carrito de Compras</h1>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $total += $row['price'] * $row['quantity'];
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>\${$row['price']}</td>
                        <td>{$row['quantity']}</td>
                        <td>\$".($row['price'] * $row['quantity'])."</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <h2>Total: $<?php echo $total; ?></h2>
    <a href="checkout.php">Proceder al Pago</a>
    <a href="user.php">Continuar Comprando</a>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
