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
    $desc = $_POST['descripcion'];
    $Cuerpo = $_POST['tup'];
    $tag = $_POST['optionTag'];

    $imgPath = null;
    $img1Up = null;
    $img2Path = null;
    $img2Up = null;

    $targetDir = '../../uploads/';
    $targetUp = '../uploads/';

    if ($id > 0) {
        $query = "SELECT Imagen, Imagen2, Preview FROM $tablas WHERE ID = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($currentImg1, $currentImg2, $targetPre);
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

    if (isset($_FILES['filename1']) && $_FILES['filename1']['error'] == UPLOAD_ERR_OK) {
        $img2Name = basename($_FILES['filename1']['name']);
        $img2Path = $targetDir . $img2Name;
        $img2Up = $targetUp . $img2Name;
        $imageFileType2 = strtolower(pathinfo($img2Path, PATHINFO_EXTENSION));

        $check2 = getimagesize($_FILES['filename1']['tmp_name']);
        if ($check2 !== false) {
            if (move_uploaded_file($_FILES['filename1']['tmp_name'], $img2Path)) {
                echo "La imagen ". htmlspecialchars($img2Name) . " se ha subido correctamente.";
                echo "<BR>";
            } else {
                echo "Error al subir la imagen.";
                echo "<BR>";
                $img2Path = null;
                $img2Up = null;
            }
        } else {
            echo "El archivo no es una imagen.";
            echo "<BR>";
            $img2Path = null;
            $img2Up = null;
        }
    } else {
        $img2Up = $currentImg2; 
        }

    if ($id > 0) {
        $queryUpdate = "UPDATE $tablas SET Titulo = ?, Autor = ?, Fecha = ?, Descripcion = ?, Contenido = ?, Imagen = ?, Imagen2 = ?, Preview = ?, Tag = ? WHERE ID = ?";
        $stmt = $link->prepare($queryUpdate);
        $stmt->bind_param("sssssssssi", $titulo, $autor, $fecha, $desc, $Cuerpo, $img1Up, $img2Up, $targetPre, $tag, $id);

        if ($stmt->execute()) {
            echo "<h1>Actualización completada exitosamente</h1>";
        } else {
            echo "<h1>La actualización ha fallado: " . $stmt->error."</h1>";
        }
        $stmt->close();
    } else {
        echo "<h1>ID de post inválido.</h1>";
    }
}

header("refresh:3; url=index.php");
?>
