<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Admin Index</title>
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
                <a href="create.html" class="btn btn-big">Crear Citatorio</a>
                <a href="index.php" class="btn btn-big">Administrar Citatorios</a>
            </div>

            <div class="content">

                <h2 class="page-title">Administrar Citatorios</h2>

                <table>
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>CURP</th>
                            <th>Título</th>
                            <th>Creador</th>
                            <th colspan="2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    include('../../php/cone.php');
                    include('verify.php');

                    $results_per_page = 10; 
                    
                    $total_sql = "SELECT COUNT(*) FROM $tablas4";
                    $stmt_total = $link->prepare($total_sql);
                    $stmt_total->execute();
                    $stmt_total->bind_result($total_results);
                    $stmt_total->fetch();
                    $stmt_total->close();

                    $total_pages = ceil($total_results / $results_per_page);

                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $current_page = max(1, min($current_page, $total_pages));
                    $offset = ($current_page - 1) * $results_per_page;

                    $sql = "SELECT ID, CURP, Titulo, Autor FROM $tablas4 LIMIT ? OFFSET ?";
                    $stmt = $link->prepare($sql);
                    $stmt->bind_param("ii", $results_per_page, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['ID'] . "</td>";
                            echo "<td>" . $row['CURP'] . "</td>";
                            echo "<td>" . $row['Titulo'] . "</td>";
                            echo "<td>" . $row['Autor'] . "</td>";
                            echo "<td><a href='edit.php?id=".$row['ID']."' class='editar'>Editar</a></td>";
                            echo "<td><a href='borrar.php?id=" . $row['ID'] . "' class='borrar'>Borrar</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No hay citatorios</td></tr>";
                    }

                    $stmt->close();
                    $link->close();
                    ?>
                    </tbody>
                </table>

                <div class="pagination">
                    <?php
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active = $i == $current_page ? 'active' : '';
                        echo "<a class='$active' href='index.php?page=$i'>$i</a>";
                    }
                    ?>
                </div>

            </div>

        </div>

    </main>

    <script src="../../js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</body>
</html>
