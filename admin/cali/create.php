<?php
    include ('../../php/cone.php');
    include('verify.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Admin Citatorios</title>
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
                <li><a href="../cita/index.php">Administrar Citatorio</a></li>
                <li><a href="../cali/index.php">Administrar Calificaciones</a></li>
                <li><a href="../curp/index.php">Buscar por CURP</a></li>
            </ul>
        </div>

        <div class="admin-content">

            <div class="btn-group">
                <a href="create.html" class="btn btn-big">Crear Calificaciones</a>
                <a href="index.php" class="btn btn-big">Administrar Calificaciones</a>
            </div>

            <div class="content">

                <h2 class="page-title">Crear Calificaciones</h2>

                <form action="CreateCali.php" method="post" enctype="multipart/form-data">
                    <div class="input-box-admin">
                        <span class="icon"><ion-icon name="document-text"></ion-icon></span>
                        <input type="text" id="curpInput" name="curpInput"  placeholder=" " required>
                        <label>CURP</label>
                    </div>
                    <div class="input-box-admin">
                        <span class="icon"><ion-icon name="pencil"></ion-icon></span>
                        <input type="text" id="TitleInput" name="TitleInput" placeholder="" required>
                        <label>Título</label>
                    </div>
                     <div class="text-upload-admin">
                        <h4>Contenido</h4>
                        <textarea name="tup" id="tup" placeholder="Este es el texto del post" rows="7" cols="125"></textarea>
                    </div>
                    <div class="upload-btn-admin">
                        <h4>Subir imagen</h4><br>
                        <input type="file" id="filename" name="filename">
                    </div>

                    <div class="send">
                        <input type="submit">
                    <h6>Una vez seleccionado enviar por favor espere a ser redirigido automaticamente</h6>
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