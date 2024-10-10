<?php
include('../php/cone.php');
session_start();
    include('verify.php');

if (!isset($_SESSION['CURP'])) {
    header("Location: login.php");
    exit();
}

$curp = isset($_SESSION['CURP']) ? $_SESSION['CURP'] : '';

if ($curp) {
    $curp = htmlspecialchars($curp);

    $posts_per_page = 5;

    $total_sql = "SELECT COUNT(*) FROM $tablas4 WHERE CURP = ?";
    $stmt_total = $link->prepare($total_sql);
    $stmt_total->bind_param("s", $curp);
    $stmt_total->execute();
    $stmt_total->bind_result($total_posts);
    $stmt_total->fetch();
    $stmt_total->close();

    $total_pages = ceil($total_posts / $posts_per_page);

    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($current_page < 1) {
        $current_page = 1;
    } elseif ($current_page > $total_pages) {
        $current_page = $total_pages;
    }

    $offset = ($current_page - 1) * $posts_per_page;

    $sql = "SELECT ID, Titulo, Fecha, Texto, Imagen 
            FROM $tablas4 
            WHERE CURP = ? 
            ORDER BY Fecha DESC 
            LIMIT ? OFFSET ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("sii", $curp, $posts_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <title>Citatorios para CURP: <?php echo htmlspecialchars($curp); ?></title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="shortcut icon" href="../css/img/ESCUDO 263.png" type="image/x-icon">
        </script>
    </head>
    <body>
        
    <?php 
    include('../php/menu.php');
    ?>
        <main>
            <div class="content clearfix">
                <div class="main-content" id="post">
                    <h1 class="recent-post-title">Citatorios para CURP: <?php echo htmlspecialchars($curp); ?></h1>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $postID = $row['ID'];
                            $titulo = $row['Titulo'];
                            $fecha = date("d F Y", strtotime($row['fecha']));
                            $descripcion = $row['Texto'];
                            $imagen = $row['Imagen'];

                            echo '<div class="post">';
                            if ($imagen) {
                                echo '<img src="' . htmlspecialchars($imagen) . '" alt="' . htmlspecialchars($titulo) . '" class="post-image">';
                            } else {
                                echo '<img src="css/img/stock-1.jpg" alt="Imagen por defecto" class="post-image">';
                            }
                            echo '<div class="post-preview">';
                            echo '<h2><a href="post.php?ID=' . $postID . '">' . htmlspecialchars($titulo) . '</a></h2>';
                            echo '<i class="far fa-calendar">' . htmlspecialchars($fecha) . '</i>';
                            echo '<p class="preview-text">' . htmlspecialchars($descripcion) . '</p>';
                            echo '<a href="postCi.php?ID=' . $postID . '" class="btn">Leer Más...</a>';
                            echo '</div></div>';
                        }

                        echo '<div class="pagination">';
                        if ($current_page > 1) {
                            echo '<a href="?page=' . ($current_page - 1) . '">&laquo; Anterior</a>';
                        }

                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $current_page) {
                                echo '<span>' . $i . '</span>';
                            } else {
                                echo '<a href="?page=' . $i . '">' . $i . '</a>';
                            }
                        }

                        if ($current_page < $total_pages) {
                            echo '<a href="?page=' . ($current_page + 1) . '">Siguiente &raquo;</a>';
                        }
                        echo '</div>';
                    } else {
                        echo '<p>No se encontraron citatorios para esta CURP.</p>';
                    }
                    ?>

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
        </main>

    <script src="../../js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/5f82f2b700.js" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php

    $stmt->close();
} else {
    echo '<p>No se encontró la CURP en la sesión.</p>';
}

$link->close();
?>
