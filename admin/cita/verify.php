<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: https://sec263.rf.gd/login.php");
    exit();
}

$user_id = $_SESSION['ID'];
$sql2 = "SELECT Nivel FROM usuario WHERE ID = ?";
$stmt = $link->prepare($sql2);
$stmt->bind_param('i', $user_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_level = $row['Nivel'];
} else {
    session_unset();
    session_destroy();
    header("Location: https://sec263.rf.gd/login.php");
    exit();
}

$niveles_permitidos = ['Administrador','Programador', 'Editor']; 
if (!in_array($user_level, $niveles_permitidos)) {
    echo "No tienes permisos para acceder a esta página.";
    exit();
}
?>
