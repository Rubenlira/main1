
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Admin Post</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="shortcut icon" href="../../css/img/ESCUDO 263.png" type="image/x-icon">
</head>
<body>
    
    <header>
        <h3 class="logo">ESCUELA SECUNDARIA PÚBLICA NO. 263 “DEPORTE PARA TODOS” J.A.</h3>
        <button class="btnLogOut-popup">Cerrar Sesion</button>
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
                <a href="create.php" class="btn btn-big">Crear Post</a>
                <a href="index.php" class="btn btn-big">Administrar Post</a>
            </div>

            <div class="content">

                <h2 class="page-title">Editar Post</h2>

                <?php
                    include('../../php/cone.php');       
                    include ('verify.php');                 

                    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                    if ($id > 0) {
                        $sql = "SELECT titulo, descripcion, contenido, imagen, imagen2 FROM $tablas WHERE ID = ?";
                        $stmt = $link->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $stmt->bind_result($titulo, $descripcion, $contenido, $imagen, $imagen2);
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
                            <input type="text" id="TitleInput" placeholder="" name="TitleInput" value="<?php echo htmlspecialchars($titulo); ?>" required>
                            <label>Título</label>
                        </div>
                        <div class="text-upload-admin">
                            <h4>Descripción del Post</h4>
                            <textarea name="descripcion" id="descripcion" placeholder="Esta es la Descripción del post" rows="7" cols="125"><?php echo htmlspecialchars($descripcion); ?></textarea>
                        </div>
                        <div class="text-upload-admin">
                            <h4>Contenido del Post</h4>
                            <textarea name="tup" id="tup" placeholder="Este es el texto del post" rows="7" cols="125"><?php echo htmlspecialchars($contenido); ?></textarea>
                        </div>
                        <div class="upload-btn-admin">
                            <h4>Editar imagen de portada</h4><br>
                            <input type="file" id="filename" name="filename">
                        </div>
                        <div class="upload-btn-admin">
                            <h4>Editar la segunda imagen</h4><br>
                            <input type="file" id="filename1" name="filename1">
                        </div>
                        <div class="text-upload-admin">
                        <h4>Categorías</h4>
                        <h5>Por favor selecciona nuevamente la categoría</h5>
                        <div class="custom-select">
                            <select name="optionTag" required>
                            <?php

                            $sql2 = "SELECT id, Nombre FROM $tablas2 ORDER BY id";
                            $result = $link->query($sql2);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $Nombre = htmlspecialchars($row['Nombre']);
                                    $id = $row['id'];
                                    echo "<option value=\"$Nombre\">$Nombre</option>";
                                }
                            } else {
                                echo "<option value=null>No hay categorías recientes.</option>";
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                        <div class="send">
                            <input type="submit" value="Actualizar">
                        </div>
                        <h6>Una vez seleccionado Actualizar por favor espere a ser redirigido automaticamente</h6>
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