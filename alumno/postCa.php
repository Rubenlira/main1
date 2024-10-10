<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Post</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../css/img/ESCUDO 263.png" type="image/x-icon">
</head>
<body>
    

    <?php 
    include('../php/menu.php');
    ?>

    <div class="content clearfix">

            <div class="main-content single">
                <div class="post-container">
                <?php
                function makeLinksClickable($text) {
                    $pattern = '/\b(https?:\/\/[^\s()<>]+)/i';
                    
                    $replacement = '<a style="color:blue; text-decoration:underline;" href="$1" target="_blank">$1</a> ';
                    
                    return preg_replace($pattern, $replacement, $text);
                }
                

                include '../php/cone.php';
                
                $ID = isset($_GET['ID']) ? intval($_GET['ID']) : 0;
                
                if ($ID > 0) {
                    $sql = "SELECT Titulo, Imagen, Texto, Autor, Fecha FROM $tablas5 WHERE ID = ?";
                    $stmt = $link->prepare($sql);
                    $stmt->bind_param("i", $ID);
                    $stmt->execute();
                    $stmt->bind_result($titulo, $imagen,  $contenido, $autor, $fecha);
                    $stmt->fetch();
                    $stmt->close();
                
                    $contenidoConLinks = makeLinksClickable($contenido);
                    if ($titulo) {
                        echo '<h1 class="post-title">' . htmlspecialchars($titulo) . '</h1>';
                            echo '<i class="far fa-user ">' .htmlspecialchars($autor) .'</i>';
                            echo '<i class="far fa-calendar postfa">' .htmlspecialchars($fecha) .'</i>';
                            echo '<br>';
                            echo '<div class="post-content"> <pre class="textopost">'. $contenidoConLinks . '</pre></div>';

                        if ($imagen) {
                            $imagePath = htmlspecialchars($imagen); 
                            echo '<img src="' . $imagePath . '" alt="Imagen del post" class="center" style="height:auto; width=100%">';
                        } else {
                            echo '<p>No hay imagen disponible para este post.</p>'; 
                        }

                    } else {
                        echo '<h1 class="post-title">Post no encontrado</h1>';
                    }
                } else {
                    echo '<h1 class="post-title">ID de post inválido</h1>';
                }
                ?>
                
                </div>
            </div>
        

            <div class="sidebar">
                
                <div class="section fc">
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D100068470590489%26sk%3Dabout&tabs&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="130" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>

                <div class="section recents">
                    <h2 class="section-title">Publicaciones Recientes</h2>
                    <?php
                        $sql3 = "SELECT id, titulo, imagen FROM posts ORDER BY ID ASC LIMIT 5";
                        $result = $link->query($sql3);

                        $posts = [];
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $posts[] = $row;
                            }
                            $posts = array_reverse($posts);

                            foreach ($posts as $row) {
                                $titulo = htmlspecialchars($row['titulo']);
                                $imagen = htmlspecialchars($row['imagen']);
                                $id = $row['id'];
                                ?>
                                <div class="post clearfix">
                                    <img src="<?php echo $imagen; ?>" alt="Imagen de <?php echo $titulo; ?>">
                                    <a href="post.php?ID=<?php echo $id; ?>" class="title">
                                        <h4><?php echo $titulo; ?></h4>
                                    </a>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No hay publicaciones recientes.</p>";
                        }
                    ?>

            </div>
                    
                    <div class="input-box section search">
                        <span class="icon"><ion-icon name="search-outline"></ion-icon></span>
                        <form action="buscar.php" method="GET">
                            <input type="text" placeholder="" name="query" required>
                            <label>Buscar</label>
                        </form>
                    </div>

                    <div class="section topics">
                        <h2 class="section-title">Categoría</h2>
                        <ul>
                            <?php
                            $sql3 = "SELECT ID, Nombre FROM $tablas2";
                            $result = $link->query($sql3);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $id = $row['ID'];
                                    $nombre = htmlspecialchars($row['Nombre']);
                                echo '<li><a href="category.php?tag=' . urlencode($nombre) . '">' . htmlspecialchars($nombre) . '</a></li>';
                                }
                            } else {
                                echo '<li>No hay categorías disponibles</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
    </div>
    

    <script src="../../js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/5f82f2b700.js" crossorigin="anonymous"></script>
</body>
</html>