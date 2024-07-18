<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'user') {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';
$username = $_SESSION['username'];
$query = "SELECT id FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$user_id = $user['id'];

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Productos Disponibles</h2>
    <div class="products">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='product'>
                    <h2>{$row['name']}</h2>
                    <p>{$row['description']}</p>
                    <p>\${$row['price']}</p>
                    <form method='post' action='add_to_cart.php'>
                        <input type='hidden' name='product_id' value='{$row['id']}'>
                        <input type='number' name='quantity' value='1' min='1'>
                        <button type='submit'>Agregar al Carrito</button>
                    </form>
                  </div>";
        }
        ?>
    </div>
    <a href="cart.php">Ver Carrito</a>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
