<?php
// update_passwords.php

include("conexion.php");

// Seleccionar todas las contraseñas actuales
$sql = "SELECT id, username, password FROM usuarios";
$result = mysqli_query($conexion, $sql);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $id = $row['id'];
    $username = $row['username'];
    $password = $row['password'];

    // Hashear la contraseña actual
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    $update_sql = "UPDATE usuarios SET password='$hashed_password' WHERE id=$id";
    mysqli_query($conexion, $update_sql);
}

echo "Passwords updated successfully.";

mysqli_close($conexion);
?>
