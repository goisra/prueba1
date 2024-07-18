<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <h1>Productos Disponibles</h1>
    <div class="products">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <p>$<?php echo $row['price']; ?></p>
                <a href="add_to_cart.php?id=<?php echo $row['id']; ?>">Añadir al Carrito</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
