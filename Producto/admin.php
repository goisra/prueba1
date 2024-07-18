<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: login.php");
}

include 'includes/db.php';

// Ejemplos de operaciones CRUD para productos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear nuevo producto
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $query = "INSERT INTO products (name, description, price) VALUES ('$name', '$description', '$price')";
        mysqli_query($conn, $query);
    }

    // Actualizar producto
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $query = "UPDATE products SET name='$name', description='$description', price='$price' WHERE id='$id'";
        mysqli_query($conn, $query);
    }

    // Eliminar producto
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $query = "DELETE FROM products WHERE id='$id'";
        mysqli_query($conn, $query);
    }
}

// Obtener lista de productos
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="assets/styles2.css">
    <script src="assets/jquery.min.js"></script>
    <script src="assets/scripts.js"></script>
</head>
<body>
    <h1>Welcome, Admin</h1>
    <form method="post" action="admin.php">
        <h2>Create Product</h2>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
        <label for="description">Description</label>
        <textarea id="description" name="description" required></textarea>
        <label for="price">Price</label>
        <input type="text" id="price" name="price" required>
        <button type="submit" name="create">Create</button>
    </form>

    <h2>Product List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td>
                <form method="post" action="admin.php" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                    <input type="hidden" name="description" value="<?php echo $row['description']; ?>">
                    <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
                <form method="post" action="admin.php" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
                    <input type="text" name="description" value="<?php echo $row['description']; ?>" required>
                    <input type="text" name="price" value="<?php echo $row['price']; ?>" required>
                    <button type="submit" name="update">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
