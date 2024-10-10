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
        include('../../php/cone.php');

        session_start();

        if (!isset($_SESSION['username'])) {
            echo "<h1>Debe iniciar sesión para acceder a esta página.</h1>";
            header("refresh:3; url=https://sec.rf.gd/login.html");
            exit();
        }

        if ($_POST) {
            $Usuario = $_POST['NameInput'];
            $Correo = $_POST['emailInput'];
            $curp = $_POST['curpInput'];
            $Autor = $_SESSION['username'];
            $password = $_POST['RegPass'];
            $Nivel = $_POST['option']; 
            $datatime = date("Y-m-d H:i:s");

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $queryInsert = "INSERT INTO $tablas3 (ID, CURP, Correo, Nombre, Contrasena, Autor, Nivel, Fecha) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($queryInsert);
            $stmt->bind_param("sssssss", $curp, $Correo, $Usuario, $hashedPassword, $Autor, $Nivel, $datatime);
            
            if ($stmt->execute()) {
                echo "<h1>Registro completado exitosamente</h1>";
            } else {
                echo "<h1>El registro ha fallado</h1>";
            }
            
            $stmt->close();
        }

        header("refresh:3; url=index.php");
        ?>
    </div>
</body>
</html>
