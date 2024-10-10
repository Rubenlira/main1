<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../css/img/ESCUDO 263.png" type="image/x-icon">
</head>
<body>


    <?php 
    include('../php/menu.php');
    ?>

<main>
    <button class="btnLogin-popup2">Iniciar Sesion</button>

    <div class="wrapper">
        
        <span class="icon-close2">
            <ion-icon name="close-outline"></ion-icon>
        </span>

        <div class="form-box login">
            <h2>Iniciar Sesión</h2>
            <form action="../php/auth2.php" method="POST">
                <div class="input-box">
                    <span class="icon"><ion-icon name="document-text"></ion-icon></span>
                    <input type="text" id="curpInput" name="curpInput"  placeholder=" " required>
                    <label>CURP</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" placeholder=" " required id="password" name="password">
                    <label>Contraseña</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox" class="checkbox" id="showPassword">Mostrar</label>
                    <a href="#">Olvide mi Contraseña</a>
                </div>
                <button type="submit" class="btn"> Iniciar Sesion</button>
                <div class="login-register">
                    <p>Tengo problemas con mi cuenta<a href="#" class="help-link"><br>Solicitar Ayuda</a></p>
                </div>
            </form>
        </div>
    </div>    
</main>


    <script src="../js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/5f82f2b700.js" crossorigin="anonymous"></script>
</body>
</html>