<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumno</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../css/img/ESCUDO 263.png" type="image/x-icon">
</head>
<body>

<?php 
include('../php/menu.php');
include('../php/cone.php');
include('verify.php');

session_start();

if (!isset($_SESSION['CURP'])) {
    header("Location: https://sec263.rf.gd/alumno/login.php");
    exit();
}

$CURP = $_SESSION['CURP'];

$query = "SELECT ID, Nombre, Correo FROM $tablas3 WHERE CURP = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("s", $CURP);
$stmt->execute();
$stmt->bind_result($id, $nombre, $Correo);
$stmt->fetch();
$stmt->close();

$qrData = "https://sec263.rf.gd/php/reg_access.php?id=$id&curp=$CURP";
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);
?>

<div class="contentAl">
    <div class="col">
        <div class="Content-Alum">
            <h1>¡Bienvenido <?php echo htmlspecialchars($nombre); ?>!</h1>
        </div>
        <div class="Content-Alum">
            <button class="Citatorios">Citatorios</button>
            <button class="Calificaciones">Calificaciones</button>
        </div>
        <div class="Content-Alum">
            <img src="<?php echo htmlspecialchars($qrUrl); ?>" alt="QR con Información del Registro">
        </div>
        <div class="Content-Alum">
            <button class="btnLogOut-popupAl">Cerrar Sesión</button>
        </div>
    </div>        
</div>

<script src="../js/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/5f82f2b700.js" crossorigin="anonymous"></script>
</body>
</html>
