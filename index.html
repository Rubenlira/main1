<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="css/img/ESCUDO 263.png" type="image/x-icon">
</head>
<body>
    
    <?php 
    include('php/menu.php');
    ?>

    <main>
        <div id="gallery">
            <div class="gallery-container">
            <?php
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                include('php/cone.php'); 

                $query = "SELECT preview FROM posts ORDER BY ID ASC LIMIT 5";
                $result = mysqli_query($link, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $images = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $images[] = $row['preview'];
                    }
                    $images = array_reverse($images);
                    foreach ($images as $imagePath) {
                        echo '<figure class="gallery-item">';
                        echo '<img src="' . htmlspecialchars($imagePath) . '" alt="Imagen">';
                        echo '</figure>';
                    }
                } else {
                    echo '<p>No hay imágenes disponibles.</p>';
                }
            ?>

            </div>
            <div class="gallery-navigation">
                <button class="nav-button prev-button"><</button>
                <button class="nav-button next-button">></button>
            </div>
        </div>

        <div class="content clearfix">

            <div class="main-content" id="post">
                <h1 class="recent-post-title">Publicaciones Recientes</h1>
                
                
                <?php
                    
                    $postsPerPage = 4;
                    
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $currentPage = ($currentPage > 0) ? $currentPage : 1;
                    
                    $offset = ($currentPage - 1) * $postsPerPage;

                    $totalSql = "SELECT COUNT(*) as total FROM $tablas";
                    $totalResult = $link->query($totalSql);
                    $totalRow = $totalResult->fetch_assoc();
                    $totalPosts = $totalRow['total'];
                    $totalPages = ceil($totalPosts / $postsPerPage);

                    $sql = "SELECT ID, titulo, autor, fecha, descripcion, preview FROM $tablas ORDER BY ID DESC LIMIT $offset, $postsPerPage";
                    $result = $link->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $posts = [];

                        while ($row = $result->fetch_assoc()) {
                            $posts[] = $row;
                        }

                        foreach ($posts as $row) {
                            $postID = $row['ID'];
                            $titulo = $row['titulo'];
                            $autor = $row['autor'];
                            $fecha = date("d F Y", strtotime($row['fecha']));
                            $descripcion = $row['descripcion'];
                            $preview = $row['preview'];

                            echo '<div class="post">';
                            if ($preview) {
                                echo '<img src="' . htmlspecialchars($preview) . '" alt="' . htmlspecialchars($titulo) . '" class="post-image">';
                            } else {
                                echo '<img src="css/img/stock-1.jpg" alt="Imagen por defecto" class="post-image">';
                            }
                            echo '<div class="post-preview">';
                            echo '<h2><a href="../php/post.php?ID=' . $postID . '">' . htmlspecialchars($titulo) . '</a></h2>';
                            echo '<i class="far fa-user">' . htmlspecialchars($autor) . '</i>&nbsp;';
                            echo '<i class="far fa-calendar">' . htmlspecialchars($fecha) . '</i>';
                            echo '<p class="preview-text">' . htmlspecialchars($descripcion) . '</p>';
                            echo '<a href="../php/post.php?ID=' . $postID . '" class="btn">Leer Más...</a>';
                            echo '</div></div>';
                        }
                    } else {
                        echo '<p>No hay publicaciones recientes disponibles.</p>';
                    }
                ?>

                <div class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <a href="?page=<?php echo ($currentPage - 1); ?>" class="">Anterior</a>
                    <?php endif; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?php echo ($currentPage + 1); ?>" class="">Siguiente</a>
                    <?php endif; ?>
                </div>

            </div>
            
            <div class="sidebar">
                
                <div class="input-box section search">
                    <span class="icon"><ion-icon name="search-outline"></ion-icon></span>
                    <form action="../php/buscar.php" method="GET">
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
                           echo '<li><a href="php/category.php?tag=' . urlencode($nombre) . '">' . htmlspecialchars($nombre) . '</a></li>';
                        }
                    } else {
                        echo '<li>No hay categorías disponibles</li>';
                    }
                    ?>
                </ul>
            </div>

        </div>
    </main>

    <script src="js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/5f82f2b700.js" crossorigin="anonymous"></script>
</body>
</html>