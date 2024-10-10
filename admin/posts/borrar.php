
    <?php
        include('../../php/cone.php');                        
        session_start();

        if (!isset($_SESSION['username'])) {
            echo "<h1>Debe iniciar sesión para acceder a esta página.</h1>";
            header("refresh:3; url=https://sec263.rf.gd/login.html");
            exit();
        }
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
        

        
            $sql = "DELETE FROM posts WHERE id = ?";
            if ($stmt = $link->prepare($sql)) {
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    echo "Post eliminado correctamente.";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error al eliminar el post.";
                }
            } else {
                echo "Error en la preparación de la consulta.";
            }
        } else {
            echo "ID de post no especificado.";
        }
        
        $link->close();
        ?>
    ?>

