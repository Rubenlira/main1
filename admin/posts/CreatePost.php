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
            header("refresh:3; url=../login.html");
            exit();
        }

        if ($_POST) {
            $titulo = $_POST['TitleInput'];
            $autor = $_SESSION['username'];
            $fecha = date('Y-m-d H:i:s');
            $desc = $_POST['descripcion'];
            $Cuerpo = $_POST['tup'];
            $tag = $_POST['optionTag'];

            $imgPath = null;
            $img1Up = null;

            $img2Path = null;
            $img2Up=null;

            $targetDir = '../../uploads/';
            $targetUp = '../uploads/';
            $targetPre ='../uploads/';

            if (isset($_FILES['filename']) && $_FILES['filename']['error'] == UPLOAD_ERR_OK) {
                $imgName = basename($_FILES['filename']['name']);
                $imgPath = $targetDir . $imgName;
                $img1Up = $targetUp .$imgName;
                $targetPre = $targetPre .$imgName;
                $imageFileType = strtolower(pathinfo($imgPath, PATHINFO_EXTENSION));

                $check = getimagesize($_FILES['filename']['tmp_name']);
                if ($check !== false) {
                    if (move_uploaded_file($_FILES['filename']['tmp_name'], $imgPath)) {
                        echo "La imagen ". htmlspecialchars($imgName) . " se ha subido correctamente.";
                        echo "<BR>";
                    } else {
                        echo "Error al subir la imagen.";
                        echo "<BR>";
                        $imgPath = null;
                        $img1Up=null;
                    }
                } else {
                    echo "El archivo no es una imagen.";
                    echo "<BR>";
                    $imgPath = null;
                    $img1Up=null;
                }
            }

            if (isset($_FILES['filename1']) && $_FILES['filename1']['error'] == UPLOAD_ERR_OK) {
                $img2Name = basename($_FILES['filename1']['name']);
                $img2Path = $targetDir . $img2Name;
                $img2Up = $targetUp .$img2Name;
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
                        $img2Up=null;
                    }
                } else {
                    echo "El archivo no es una imagen.";
                    echo "<BR>";
                    $img2Path = null;
                    $img2Up=null;
                }
            }

            $queryInsert = "INSERT INTO $tablas (Titulo, Autor, Fecha, Descripcion, Contenido, Imagen, Imagen2, Preview, Tag) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($queryInsert);
            $stmt->bind_param("sssssssss", $titulo, $autor, $fecha, $desc, $Cuerpo, $img1Up, $img2Up, $targetPre, $tag);

            if ($stmt->execute()) {
                echo "<h1>Registro completado exitosamente</h1>";
            } else {
                echo "<h1>El registro ha fallado: " . $stmt->error."</h1>";
            }
            $stmt->close();
        }

        header("refresh:3; url=index.php");
        ?>
    </div>
</body>
</html>
