<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Admin Categorías</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="shortcut icon" href="../../css/img/ESCUDO 263.png" type="image/x-icon">
    <script>
        window.addEventListener("beforeunload", function (e) {
            navigator.sendBeacon('logout.php');
            });
        </script>
</head>
<body>
    
    <header>
        <h3 class="logo">ESCUELA SECUNDARIA PÚBLICA NO. 263 “DEPORTE PARA TODOS” J.A.</h3>
        <button class="btnLogOut-popup">Cerrar Sesión</button>
    </header>

    <main class="Admin-wrapper">

        <div class="left-sidebar">
            <ul>
                <li><a href="../posts/index.php">Administrar Posts</a></li>
                <li><a href="../users/index.php">Administrar Usuarios</a></li>
                <li><a href="../topics/index.php">Administrar Categorías</a></li>
                <li><a href="../cita/index.php">Administrar Citatorios</a></li>
                <li><a href="../cali/index.php">Administrar Calificaciones</a></li>
                <li><a href="../curp/index.php">Buscar por CURP</a></li>
            </ul>
        </div>

        <div class="admin-content">

            <div class="btn-group">
                <a href="create.html" class="btn btn-big">Crear Categorías</a>
                <a href="index.php" class="btn btn-big">Administrar Categorías</a>
            </div>

            <div class="content">

                <h2 class="page-title">Editar Categoría</h2>

                <?php
                    include('../../php/cone.php');   
                    include ('verify.php');

                    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                    if ($id > 0) {
                        $sql = "SELECT Id, Nombre FROM $tablas2 WHERE ID = ?";
                        $stmt = $link->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $stmt->bind_result($id, $Nombre);
                        $stmt->fetch();
                        $stmt->close();
                    } else {
                        echo "ID inválido.";
                        exit;
                    }
                    ?>

                    <form action="update.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="input-box-admin">
                            <span class="icon"><ion-icon name="pencil"></ion-icon></span>
                            <input type="text" id="TopicInput" placeholder="" name="TopicInput" value="<?php echo htmlspecialchars($Nombre); ?>" required>
                            <label>Nombre de la categoría</label>
                        </div>
                        <div class="send">
                            <input type="submit" value="Actualizar">
                        </div>                    
                    <h6>Una vez seleccionado Actualizar por favor espere a ser redirigido automaticamente</h6>
                    </div>
                    </form>


            </div>

        </div>

    </main>


    <script src="../../js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</body>
</html> 