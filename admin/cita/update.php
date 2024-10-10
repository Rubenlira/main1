<?php
include('../../php/cone.php');
session_start();

if (!isset($_SESSION['username'])) {
    echo "<h1>Debe iniciar sesión para acceder a esta página.</h1>";
    header("refresh:3; url=https://sec263.rf.gd/login.html");
    exit();
}

if ($_POST) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $titulo = $_POST['TitleInput'];
    $autor = $_SESSION['username'];
    $fecha = date('Y-m-d H:i:s');
    $texto = $_POST['tup'];

    $imgPath = null;
    $img1Up = null;


    $targetDir = '../../uploads/';
    $targetUp = '../uploads/';

    if ($id > 0) {
        $query = "SELECT Imagen FROM $tablas4 WHERE ID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($currentImg1);
        $stmt->fetch();
        $stmt->close();
    }

    if (isset($_FILES['filename']) && $_FILES['filename']['error'] == UPLOAD_ERR_OK) {
        $imgName = basename($_FILES['filename']['name']);
        $imgPath = $targetDir . $imgName;
        $img1Up = $targetUp . $imgName;
        $imageFileType = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['filename']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['filename']['tmp_name'], $imgPath)) {
                $targetPre ='../uploads/';
                $targetPre = $targetPre . $imgName;
                echo "La imagen ". htmlspecialchars($imgName) . " se ha subido correctamente.";
                echo "<BR>";
            } else {
                echo "Error al subir la imagen.";
                echo "<BR>";
                $imgPath = null;
                $img1Up = null;
            }
        } else {
            echo "El archivo no es una imagen.";
            echo "<BR>";
            $imgPath = null;
            $img1Up = null;
        }
    } else {
        $img1Up = $currentImg1;
   }

    if ($id > 0) {
        $queryUpdate = "UPDATE $tablas4 SET Titulo = ?, Autor = ?, Fecha = ?, Texto = ?, Imagen = ? WHERE ID = ?";
        $stmt = $link->prepare($queryUpdate);
        $stmt->bind_param("sssssi", $titulo, $autor, $fecha, $texto, $img1Up, $id);

        if ($stmt->execute()) {
            echo "<h1>Actualización completada exitosamente</h1>";
        } else {
            echo "<h1>La actualización ha fallado: " . $stmt->error."</h1>";
        }
        $stmt->close();
    } else {
        echo "<h1>ID de citatorio inválido.</h1>";
    }
}

header("refresh:3; url=index.php");
?>
