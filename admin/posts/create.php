
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
                <li><a href="../alumnos/index.php">Administrar Alumnos</a></li>
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

                <h2 class="page-title">Crear Post</h2>                

                <form action="CreatePost.php" method="post" enctype="multipart/form-data">
                    <div class="input-box-admin">
                        <span class="icon"><ion-icon name="pencil"></ion-icon></span>
                        <input type="text" id="TitleInput" placeholder="" name="TitleInput" required>
                        <label>TÍtulo</label>
                    </div>
                    <div class="text-upload-admin">
                        <h4>Descripción del Post</h4>
                        <textarea name="descripcion" id="descripcion" placeholder="Esta es la Descripción del post" rows="7" cols="125"></textarea>
                    </div>
                    <div class="text-upload-admin">
                        <h4>Contenido del Post</h4>
                        <textarea name="tup" id="tup" placeholder="Este es el texto del post" rows="7" cols="125"></textarea>
                    </div>
                    <div class="upload-btn-admin">
                        <h4>Subir imagen de portada</h4><br>
                        <input type="file" id="filename" name="filename">
                    </div>
                    <div class="upload-btn-admin">
                        <h4>Subir otra imagen</h4><br>
                        <input type="file" id="filename1" name="filename1">
                    </div>
                    <div class="text-upload-admin">
                        <h4>Categorías</h4>
                        <div class="custom-select">
                            <select name="optionTag" required>
                            <?php
                            include('../../php/cone.php');
                             include ('verify.php');

                            $sql = "SELECT id, Nombre FROM $tablas2 ORDER BY id";
                            $result = $link->query($sql);

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
                        <input type="submit">
                    </div>
                    <h6>Una vez seleccionado enviar por favor espere a ser redirigido automaticamente</h6>
                </form>

            </div>

        </div>

    </main>
<?php
    include('verify.php');
?>

    <script src="../../js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</body>
</html> 