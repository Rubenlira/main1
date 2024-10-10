
    <header>
        <h3 class="logo">ESCUELA SECUNDARIA PÚBLICA NO. 263 “DEPORTE PARA TODOS” J.A.</h3>
        <button class="btnLogOut-popup">Cerrar Sesion</button>
    </header>

    <?php
        include('../../php/cone.php');                        

        session_start();

        if (!isset($_SESSION['username'])) {
            echo "<h1>Debe iniciar sesión para acceder a esta página.</h1>";
            header("refresh:3; url=https://sec.rf.gd/login.php");
            exit();
        }

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);

            $sql = "DELETE FROM $tablas4 WHERE id = ?";
            if ($stmt = $link->prepare($sql)) {
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    echo "Citatorio eliminado correctamente.";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error al eliminar el Citatorio.";
                }
            } else {
                echo "Error en la preparación de la consulta.";
            }
        } else {
            echo "ID de Citatorio no especificado.";
        }
        
        $link->close();
        ?>
    ?>
