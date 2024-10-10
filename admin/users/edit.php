<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Admin Usuario</title>
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
                <li><a href="../cita/index.php">Administrar Alumnos</a></li>
                <li><a href="../cita/index.php">Administrar Citatorios</a></li>
                <li><a href="../cali/index.php">Administrar Calificaciones</a></li>
                <li><a href="../curp/index.php">Buscar por CURP</a></li>
            </ul>
        </div>

        <div class="admin-content">

            <div class="btn-group">
                <a href="create.php" class="btn btn-big">Crear Usuario</a>
                <a href="index.php" class="btn btn-big">Administrar Usuarios</a>
            </div>

            <div class="content">

                <h2 class="page-title">Editar Usuario</h2>

                <?php
                    include('../../php/cone.php');
                    include ('verify.php');
                    session_start();

                    if (!isset($_SESSION['username'])) {
                        echo "<h1>Debe iniciar sesión para acceder a esta página.</h1>";
                        header("refresh:3; url=http://sec263.rf.gd/login.html");
                        exit();
                    }

                    $id = isset($_GET['ID']) ? intval($_GET['ID']) : 0;

                    if ($id > 0) {
                        $query = "SELECT Nombre, Correo, Contrasena, Nivel FROM usuario WHERE ID = ?";
                        $stmt = $link->prepare($query);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $stmt->bind_result($nombre, $correo, $contraseña, $nivel);
                        $stmt->fetch();
                        $stmt->close();
                    } else {
                        echo "ID de usuario inválido.";
                        exit();
                    }
                ?>

            <form action="update.php" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="input-box-admin">
                        <span class="icon"><ion-icon name="pencil"></ion-icon></span>
                        <input type="text" id="NameInput" name="NameInput" value="<?php echo htmlspecialchars($nombre); ?>" required>
                        <label>Nombre del Usuario</label>
                    </div><br>
                    <div class="input-box-admin">
                        <span class="icon"><ion-icon name="mail"></ion-icon></span>
                        <input type="email" id="emailInput" name="emailInput" value="<?php echo htmlspecialchars($correo); ?>" required>
                        <label>Email</label>
                    </div>
                    <div class="text-upload-admin">
                        <h4>Permisos de Usuario</h4>
                        <div class="custom-select">
                            <select name="option" required>
                                <option value="Administrador" <?php echo ($nivel == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="Editor" <?php echo ($nivel == 'Editor') ? 'selected' : ''; ?>>Editor</option>
                                <option value="Programador" <?php echo ($nivel == 'Programador') ? 'selected' : ''; ?>>Programador</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-box-admin">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input type="password" id="RegPass" name="RegPass" placeholder="" ">
                        <label>Ingrese nueva contraseña del Usuario(opcional)</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox" class="checkbox" id="showPassword2">Mostrar</label>
                    </div>
                    <div class="send">
                        <input type="submit" value="Actualizar">
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