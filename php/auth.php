<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="content">
<?php
session_start();

include('cone.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['emailInput'];
    $password = $_POST['password'];

    $stmt = $link->prepare("SELECT * FROM $tablas1 WHERE Correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Asigna el hash de la contraseña a una variable
        $hashedPassword = $row['Contrasena'];

        // Verifica la contraseña
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $row['Nombre']; 
            $_SESSION['nivel'] = $row['Nivel']; 
            $_SESSION['ID'] = $row ['ID'];

            echo "<h1><center>Inicio de Sesión Exitoso</center></h1>";
            header("refresh:3; url=../admin/posts/index.php");
            exit();
        } else {
            echo "<h1>Inicio de Sesión incorrecto, email o contraseña inválidos.</h1>";
        }
    } else {
        echo "<h1>Inicio de Sesión incorrecto, email o contraseña inválidos.</h1>";
    }

    $stmt->close();
}
?>
    </div>
</body>
</html>
