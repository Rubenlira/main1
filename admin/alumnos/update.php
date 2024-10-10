<?php
include('../../php/cone.php');
session_start();

if (!isset($_SESSION['username'])) {
    echo "<h1>Debe iniciar sesión para acceder a esta página.</h1>";
    header("refresh:3; url=https://sec.rf.gd/login.php");
    exit();
}

if ($_POST) {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nombre = isset($_POST['NameInput']) ? $_POST['NameInput'] : null;
    $curp = isset($_POST['curpInput']) ? $_POST['curpInput'] : null;
    $correo = isset($_POST['emailInput']) ? $_POST['emailInput'] : null;
    $nivel = isset($_POST['option']) ? $_POST['option'] : null;
    $contrasena = isset($_POST['RegPass']) ? $_POST['RegPass'] : null;

    if ($id > 0) {
        $querySelect = "SELECT CURP, Nombre, Correo, Nivel, Contrasena FROM alumnos WHERE ID = ?";
        $stmtSelect = $link->prepare($querySelect);
        $stmtSelect->bind_param("i", $id);
        $stmtSelect->execute();
        $stmtSelect->bind_result($currentCURP, $currentNombre, $currentCorreo, $currentNivel, $currentContrasena);
        $stmtSelect->fetch();
        $stmtSelect->close();

        $curp = $curp === null ? $currentCURP : $curp;
        $nombre = $nombre === null ? $currentNombre : $nombre;
        $correo = $correo === null ? $currentCorreo : $correo;
        $nivel = $nivel === null ? $currentNivel : $nivel;

        if ($contrasena !== null && $contrasena !== '') {
            $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        } else {
            $contrasena = $currentContrasena;
        }

        $queryUpdateUser = "UPDATE $tablas3 SET CURP = ?, Nombre = ?, Correo = ?, Nivel = ?, Contrasena = ? WHERE ID = ?";
        $stmtUpdateUser = $link->prepare($queryUpdateUser);
        $stmtUpdateUser->bind_param("sssssi", $curp, $nombre, $correo, $nivel, $contrasena, $id);

        $link->begin_transaction();

        try {
            if (!$stmtUpdateUser->execute()) {
                throw new Exception("Error al actualizar el usuario: " . $stmtUpdateUser->error);
            }

            $queryUpdateCitatorios = "UPDATE $tablas4 SET CURP = ? WHERE CURP = ?";
            $stmtUpdateCitatorios = $link->prepare($queryUpdateCitatorios);
            $stmtUpdateCitatorios->bind_param("ss", $curp, $currentCURP);

            $queryUpdateCali = "UPDATE $tablas5 SET CURP = ? WHERE CURP = ?";
            $stmtUpdateCali = $link->prepare($queryUpdateCali);
            $stmtUpdateCali->bind_param("ss", $curp, $currentCURP);

            if (!$stmtUpdateCitatorios->execute()) {
                throw new Exception("Error al actualizar los citatorios: " . $stmtUpdateCitatorios->error);
            }

            $link->commit();
            echo "<h1>Actualización completada exitosamente</h1>";

        } catch (Exception $e) {
            $link->rollback();
            echo "Se produjo un error: " . $e->getMessage();
        }

        $stmtUpdateUser->close();
        $stmtUpdateCitatorios->close();
    } else {
        echo "ID de usuario inválido.";
    }
}

header("refresh:3; url=index.php");
?>
