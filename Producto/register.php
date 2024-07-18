<?php
include 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = 'user'; // Por defecto es usuario

    $query = "INSERT INTO users (username, password, user_type) VALUES ('$username', MD5('$password'), '$user_type')";
    mysqli_query($conn, $query);
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="assets/styles2.css">
</head>
<body>
    <form method="post" action="register.php">
        <h2>Register</h2>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
