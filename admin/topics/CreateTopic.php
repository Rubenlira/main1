<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro exitoso</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<body>
    <div class="content">
    <?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<h1>Debe iniciar sesión para acceder a esta página.</h1>";
    header("refresh:3; url=https://sec263.rf.gd/login.html");
    exit();
}

include( '../../php/cone.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoria = $_POST['TopicInput'];
    $usuario = $_SESSION['username'];
    $fecha = date('Y-m-d H:i:s');

    $sql = "INSERT INTO $tablas2 (Autor, Nombre, FechaCre) VALUES (?, ?, ?)";
    $stmt = $link->prepare($sql);
    $stmt->bind_param("sss", $usuario, $categoria, $fecha);

    if ($stmt->execute() === TRUE) {
        echo "Nueva categoría creada exitosamente";
        header("refresh:3; url=index.php");
    } else {
        echo "Error: " . $stmt->error;
        header("refresh:3; url=index.php");
    }

    $stmt->close();
}
?>


    </div>
</body>
</html>