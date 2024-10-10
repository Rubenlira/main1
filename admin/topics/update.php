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
    $Nombre = $_POST['TopicInput'];

    if ($id > 0) {
        $link->begin_transaction();

        $queryGetOldName = "SELECT Nombre FROM categoria WHERE ID = ?";
        $stmtOldName = $link->prepare($queryGetOldName);
        $stmtOldName->bind_param("i", $id);
        $stmtOldName->execute();
        $stmtOldName->bind_result($oldName);
        $stmtOldName->fetch();
        $stmtOldName->close();
        
        try {
            $queryUpdateCategory = "UPDATE categoria SET Nombre = ? WHERE ID = ?";
            $stmt = $link->prepare($queryUpdateCategory);
            $stmt->bind_param("si", $Nombre, $id);
            if (!$stmt->execute()) {
                throw new Exception("<h1>Error al actualizar la categoría: " . $stmt->error."</h1>");
            }

            if ($oldName) {
                $queryUpdatePosts = "UPDATE posts SET tag = ? WHERE tag = ?";
                $stmtPosts = $link->prepare($queryUpdatePosts);
                $stmtPosts->bind_param("ss", $Nombre, $oldName);
                if (!$stmtPosts->execute()) {
                    throw new Exception("<h1>Error al actualizar los posts: " . $stmtPosts->error."</h1>");
                }
                $stmtPosts->close();
            } else {
                throw new Exception("<h1>No se encontró el nombre antiguo de la categoría.</h1>");
            }

            $link->commit();
            echo "<h1>Actualización completada exitosamente</h1>";

        } catch (Exception $e) {
            $link->rollback();
            echo "<h1>Se produjo un error: </h1>" . $e->getMessage();
        }

        $stmt->close();
    } else {
        echo "<h1>ID de categoría inválido.</h1>";
    }
}

header("refresh:3; url=index.php");
?>
