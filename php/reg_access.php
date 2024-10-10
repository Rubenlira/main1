<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include('cone.php');

date_default_timezone_set('America/Mexico_City');

$registroID = isset($_GET['id']) ? intval($_GET['id']) : 0;
$registroCURP = isset($_GET['curp']) ? strval($_GET['curp']) : 0;
$timestamp_actual = date("Y-m-d H:i:s");

if ($registroID > 0) {
    $check_query = "SELECT COUNT(*) FROM accesos WHERE ID = ?";
    $stmt_check = $link->prepare($check_query);
    $stmt_check->bind_param("i", $registroID);
    $stmt_check->execute();
    $stmt_check->bind_result($existeRegistro);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($existeRegistro > 0) {
        $estado_query = "SELECT estado FROM accesos WHERE ID = ? ORDER BY timestamp DESC LIMIT 1";
        $stmt_estado = $link->prepare($estado_query);
        $stmt_estado->bind_param("i", $registroID);
        $stmt_estado->execute();
        $stmt_estado->bind_result($estado);
        $stmt_estado->fetch();
        $stmt_estado->close();

        if ($estado === "Salida") {
            $estado = "Entrada";
            $query = "INSERT INTO accesos (ID, CURP , timestamp, estado) VALUES (?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("isss", $registroID, $registroCURP, $timestamp_actual, $estado);
            $stmt->execute();
            $stmt->close();

            $mensaje = "Hora de Entrada registrada exitosamente.";
        } elseif ($estado === "Entrada") {
            $estado = "Salida";
            $query = "INSERT INTO accesos (ID, CURP , timestamp, estado) VALUES (?, ?, ?, ?)";
            $stmt = $link->prepare($query);
            $stmt->bind_param("isss", $registroID,$registroCURP, $timestamp_actual, $estado);
            $stmt->execute();
            $stmt->close();

            $mensaje = "Hora de Salida registrada exitosamente.";
        }
    } else {
        $estado = "Entrada";
        $query = "INSERT INTO accesos (ID, CURP , timestamp, estado) VALUES (?, ?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param("isss", $registroID, $registroCURP, $timestamp_actual, $estado);
        $stmt->execute();
        $stmt->close();

        $mensaje = "Hora de entrada registrada exitosamente.";
    }

    $link->close();
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="shortcut icon" href="css/img/ESCUDO 263.png" type="image/x-icon">       
        <title>Registro Exitoso</title>
        <script>
            setTimeout(function() {
                window.close(); 
            }); 
        </script>
    </head>
    <body>
        <div class="contentAl">
            <h1><?php echo htmlspecialchars($mensaje); ?></h1>
        </div>
    </body>
    </html>
    <?php
    exit();
} else {
    echo "ID inválido.";
    $link->close();
    exit();
}
?>
