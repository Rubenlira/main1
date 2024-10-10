<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Publicaciones Recientes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="css/img/ESCUDO 263.png" type="image/x-icon">
</head>
<body>

    <?php 
    include('php/menu.php');
    ?>

    <main>
        <div class="content clearfix">
            <div class="main-content" id="post">
                <h1 class="recent-post-title">Publicaciones Recientes</h1>
                
                <?php
                include ('php/cone.php');

                $posts_per_page = 5;

                $total_sql = "SELECT COUNT(*) FROM $tablas";
                $total_result = $link->query($total_sql);
                $total_posts = $total_result->fetch_row()[0];

                $total_pages = ceil($total_posts / $posts_per_page);

                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                if ($current_page < 1) {
                    $current_page = 1;
                } elseif ($current_page > $total_pages) {
                    $current_page = $total_pages;
                }

                $offset = ($current_page - 1) * $posts_per_page;

                $sql = "SELECT ID, titulo, autor, fecha, descripcion, preview FROM $tablas ORDER BY ID ASC LIMIT $posts_per_page OFFSET $offset";
                $result = $link->query($sql);

                if ($result && $result->num_rows > 0) {
                    $posts = [];

                    while ($row = $result->fetch_assoc()) {
                        $posts[] = $row;
                    }

                    $posts = array_reverse($posts);

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
                    <?php if ($current_page > 1): ?>
                        <a href="?page=<?php echo $current_page - 1; ?>">&laquo; Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i == $current_page): ?>
                            <span><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <a href="?page=<?php echo $current_page + 1; ?>">Siguiente &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="sidebar">
                <div class="section fc">
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D100068470590489%26sk%3Dabout&tabs&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="130" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>

                <div class="section recents">
                    <h2 class="section-title">Publicaciones Recientes</h2>
                    <?php
                        $sql3 = "SELECT id, titulo, preview FROM posts ORDER BY ID ASC LIMIT 5";
                        $result = $link->query($sql3);

                        $posts = [];
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $posts[] = $row;
                            }
                            $posts = array_reverse($posts);

                            foreach ($posts as $row) {
                                $titulo = htmlspecialchars($row['titulo']);
                                $preview = htmlspecialchars($row['preview']);
                                $id = $row['id'];
                                ?>
                                <div class="post clearfix">
                                    <img src="<?php echo $preview; ?>" alt="Imagen de <?php echo $titulo; ?>">
                                    <a href="php/post.php?ID=<?php echo $id; ?>" class="title">
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
        </div>
    </main>

    <script src="../js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/5f82f2b700.js" crossorigin="anonymous"></script>
</body>
</html>
