<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include('../../php/cone.php');
    include('verify.php');

    $searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

    if ($searchQuery) {
        $searchPattern = "%" . $searchQuery . "%";
        $results_per_page = 8;

        $total_sql = "SELECT COUNT(*) FROM $tablas3 WHERE CURP LIKE ?";
        $stmt_total = $link->prepare($total_sql);
        $stmt_total->bind_param("s", $searchPattern);
        $stmt_total->execute();
        $stmt_total->bind_result($total_results);
        $stmt_total->fetch();
        $stmt_total->close();

        $total_pages = ceil($total_results / $results_per_page);

        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $current_page = max(1, min($current_page, $total_pages));

        $offset = ($current_page - 1) * $results_per_page;

        $sql = "SELECT ID, Nombre, Autor, Fecha, CURP, Correo, Nivel 
                FROM $tablas3 
                WHERE CURP LIKE ? 
                ORDER BY ID DESC 
                LIMIT ? OFFSET ?";

        $stmt = $link->prepare($sql);
        $stmt->bind_param("sii", $searchPattern, $results_per_page, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="shortcut icon" href="../../css/img/ESCUDO 263.png" type="image/x-icon">
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
            <li><a href="../alumnos/index.php">Administrar Alumnos</a></li>
            <li><a href="../cita/index.php">Administrar Citatorios</a></li>
            <li><a href="../cali/index.php">Administrar Calificaciones</a></li>
            <li><a href="../curp/index.php">Buscar por CURP</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h2>Resultados de búsqueda para la CURP: <?php echo htmlspecialchars($searchQuery); ?></h2>
        <div class="content">
            <div class="identificacion-oficial">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id= "id=".$row['ID'];
                        $CURP= "curp=".$row['CURP'];
                        $nombre = $row['Nombre'];

                        $qrData = "https://sec263.rf.gd/php/reg_access.php?$id&$CURP";
                        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);

                        echo "<div class='id-card'>";
                        echo "<h3>Información del alumno</h3>";
                        echo "<p><strong>ID:</strong> " . $row['ID'] . "</p>";
                        echo "<p><strong>Nombre:</strong> " . $row['Nombre'] . "</p>";
                        echo "<p><strong>Autor:</strong> " . $row['Autor'] . "</p>";
                        echo "<p><strong>Fecha:</strong> " . $row['Fecha'] . "</p>";
                        echo "<p><strong>CURP:</strong> " . $row['CURP'] . "</p>";
                        echo "<p><strong>Correo:</strong> " . $row['Correo'] . "</p>";
                        echo "<p><strong>Nivel:</strong> " . $row['Nivel'] . "</p>";
                        echo "<a href='https://sec263.rf.gd/admin/alumnos/edit.php?id=" . $row['ID'] . "' class='editar'>Editar</a>   |";
                        echo "      <a href='https://sec263.rf.gd/admin/alumnos/borrar.php?id=" . $row['ID'] . "' class='borrar'>Borrar</a>";
                        echo "<br><h3>QR Información del alumno</h3><img src='" . htmlspecialchars($qrUrl) . "' alt='QR con Información del Registro' style='position: relative; left:40%'>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No se encontraron resultados.</p>";
                }

                $stmt->close();
                ?>
            </div>
        </div>

        <!-- Tabla de Citatorios -->
        <div class="content">
            <h2 class="page-title">Administrar Citatorios</h2>
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>CURP</th>
                        <th>Título</th>
                        <th>Creador</th>
                        <th colspan="3">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_sql = "SELECT COUNT(*) FROM $tablas4 WHERE CURP LIKE ?";
                    $stmt_total = $link->prepare($total_sql);
                    $stmt_total->bind_param("s", $searchPattern);
                    $stmt_total->execute();
                    $stmt_total->bind_result($total_results);
                    $stmt_total->fetch();
                    $stmt_total->close();

                    $total_pages = ceil($total_results / $results_per_page);
                    $current_page = isset($_GET['page_cita']) ? (int)$_GET['page_cita'] : 1;
                    $current_page = max(1, min($current_page, $total_pages));
                    $offset = ($current_page - 1) * $results_per_page;


                    $stmt = $link->prepare("SELECT ID, CURP, Titulo, Autor FROM $tablas4 WHERE CURP LIKE ? LIMIT ? OFFSET ?");
                    $stmt->bind_param("sii", $searchPattern, $results_per_page, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['ID'] . "</td>";
                            echo "<td>" . $row['CURP'] . "</td>";
                            echo "<td>" . $row['Titulo'] . "</td>";
                            echo "<td>" . $row['Autor'] . "</td>";
                            echo "<td><a href='https://sec263.rf.gd/admin/cita/edit.php?id=" . $row['ID'] . "' class='editar'>Editar</a></td>";
                            echo "<td><a href='https://sec263.rf.gd/admin/cita/borrar.php?id=" . $row['ID'] . "' class='borrar'>Borrar</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay citatorios</td></tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
            <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = $i == $current_page ? 'active' : '';
                echo "<a class='$active' href='?query=" . urlencode($searchQuery) . "&page_cita=$i'>$i</a>";
            }
            ?>
        </div>
        </div>

        <!-- Tabla de Calificaciones -->
        <div class="content">
            <h2 class="page-title">Administrar Calificaciones</h2>
            <table>
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>CURP</th>
                        <th>Alumno</th>
                        <th>Creador</th>
                        <th colspan="3">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_sql = "SELECT COUNT(*) FROM $tablas5 WHERE CURP LIKE ?";
                    $stmt_total = $link->prepare($total_sql);
                    $stmt_total->bind_param("s", $searchPattern);
                    $stmt_total->execute();
                    $stmt_total->bind_result($total_results);
                    $stmt_total->fetch();
                    $stmt_total->close();

                    $total_pages = ceil($total_results / $results_per_page);
                    $current_page = isset($_GET['page_cali']) ? (int)$_GET['page_cali'] : 1;
                    $current_page = max(1, min($current_page, $total_pages));
                    $offset = ($current_page - 1) * $results_per_page;

                    $stmt = $link->prepare("SELECT ID, CURP, Titulo, Autor FROM $tablas5 WHERE CURP LIKE ? LIMIT ? OFFSET ?");
                    $stmt->bind_param("sii", $searchPattern, $results_per_page, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['ID'] . "</td>";
                            echo "<td>" . $row['CURP'] . "</td>";
                            echo "<td>" . $row['Titulo'] . "</td>";
                            echo "<td>" . $row['Autor'] . "</td>";
                            echo "<td><a href='https://sec263.rf.gd/admin/cali/edit.php?id=" . $row['ID'] . "' class='editar'>Editar</a></td>";
                            echo "<td><a href='https://sec263.rf.gd/admin/cali/borrar.php?id=" . $row['ID'] . "' class='borrar'>Borrar</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay calificaciones</td></tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
            <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = $i == $current_page ? 'active' : '';
                echo "<a class='$active' href='?query=" . urlencode($searchQuery) . "&page_cali=$i'>$i</a>";
            }
            ?>
        </div>
        </div>

         <!-- Tabla de Accesos -->
        <div class="content">
            <h2 class="page-title">Administrar Accesos</h2>
            <table>
                <thead>
                    <tr>
                        <th>CURP</th>
                        <th>Alumno</th>
                        <th>Entrada/Salida</th>
                        <th colspan="3">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                    $total_sql = "SELECT COUNT(*) FROM accesos WHERE CURP LIKE ?";
                    $stmt_total = $link->prepare($total_sql);
                    $stmt_total->bind_param("s", $searchPattern);
                    $stmt_total->execute();
                    $stmt_total->bind_result($total_results);
                    $stmt_total->fetch();
                    $stmt_total->close();

                    $total_pages = ceil($total_results / $results_per_page);
                    $current_page = isset($_GET['page_acc']) ? (int)$_GET['page_acc'] : 1;
                    $current_page = max(1, min($current_page, $total_pages));
                    $offset = ($current_page - 1) * $results_per_page;

                    $stmt = $link->prepare("SELECT ID, CURP, timestamp, Estado FROM accesos WHERE CURP LIKE ? ORDER BY timestamp DESC LIMIT ? OFFSET ?");
                    $stmt->bind_param("sii", $searchPattern, $results_per_page, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['CURP'] . "</td>";
                            echo "<td>" . $nombre. "</td>";
                            echo "<td>" . $row['Estado'] . "</td>";
                            echo "<td>" . $row['timestamp'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay accesos</td></tr>";
                    }
                    $stmt->close();
                    $link->close();
                    ?>
                </tbody>
            </table> 
        <!-- Paginación -->
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = $i == $current_page ? 'active' : '';
                echo "<a class='$active' href='?query=" . urlencode($searchQuery) . "&page_acc=$i'>$i</a>";
            }
            ?>
        </div>
        </div>


       
    </div>
</main>
<script src="../../js/script.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule="" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</body>
</html>
<?php
    } else {
        echo "<h1>Por favor, ingresa un término de búsqueda.</h1>";
    }
?>
