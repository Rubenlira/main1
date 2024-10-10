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
            header("refresh:3; url=../login.php");
            exit();
        }

        if ($_POST) {
            $titulo = $_POST['TitleInput'];
            $curp = $_POST['curpInput'];
            $autor = $_SESSION['username'];
            $fecha = date('Y-m-d H:i:s');
            $Cuerpo = $_POST['tup'];
            
            $imgPath = null;
            $img1Up = null;
            $targetDir = '../../uploads/';
            $targetUp = '../uploads/';

            echo htmlspecialchars($img1Up);
            echo htmlspecialchars($imgPath);

            $queryCURP = "SELECT CURP FROM $tablas3 WHERE CURP = ?";
            $stmtCURP = $link->prepare($queryCURP);
            $stmtCURP->bind_param("s", $curp);
            $stmtCURP->execute();
            $stmtCURP->store_result();

            if ($stmtCURP->num_rows === 0) {
                echo "<h1>La CURP ingresada no existe en la base de datos de alumnos. No se puede subir el citatorio.</h1>";
                $stmtCURP->close();
                exit();
            }
            $stmtCURP->close();

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

            $queryInsert = "INSERT INTO $tablas4 ( CURP, Titulo, Texto, Imagen, Fecha, Autor) VALUES ( ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($queryInsert);
            $stmt->bind_param("ssssss", $curp, $titulo, $Cuerpo, $img1Up, $fecha, $autor);

            if ($stmt->execute()) {
                echo "<h1>Registro completado exitosamente</h1>";
            } else {
                echo "<h1>El registro ha fallado: " . $stmt->error . "</h1>";
            }
            $stmt->close();
        }

        header("refresh:3; url=index.php");
        ?>
    </div>
</body>
</html>
