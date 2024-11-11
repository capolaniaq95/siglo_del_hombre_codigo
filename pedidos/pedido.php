<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de pedidos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        .dropdown-menu-custom {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-menu-custom a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-menu-custom a:hover {
            background-color: #17a2b8;
            color: white;
        }

        .page-item a:hover {
            background-color: #17a2b8;
            color: white;
        }

        .nav-item:hover .dropdown-menu-custom {
            display: block;
        }
        


        .table td, .table th {
            white-space: nowrap; 
        }

        .table-container {
            width: 1000px;
        }

        #filtro a:hover {
            background-color: #17a2b8;
            color: white;
        }
    </style>
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
    <header>
            <nav class="navbar navbar-expand-lg navbar-primary bg-info">
                <div class="container-fluid">
                    <!-- Alinea el título a la izquierda -->
                    <a class="navbar-brand px-2 text-white" href="../index.administrador.php">Siglo del Hombre</a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Alinea los elementos del menú a la izquierda utilizando "mr-auto" -->
                        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="pedido.php">Pedidos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="Metodo.pago.php">Metodo de Pago</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="../devolucion/devolucion.php" id="navbarDropdown" role="button">
                                    Devoluciones
                                </a>
                                <div class="dropdown-menu-custom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="../devolucion/proceso.php">Proceso</a>
                                    <a class="dropdown-item" href="../devolucion/aceptada.php">Aceptada</a>
                                    <a class="dropdown-item" href="../devolucion/rechazada.php">Rechazada</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>


        <main class="flex-fill">
            <div class="container mt-4">
                <h2>Pedidos</h2>
                <div class="d-flex bd-highlight mb-1">
                    <div class="pr-2 bd-highlight">
                        <a href="/pedidos/agregar.pedido.php" class="btn btn-info mb-3">Agregar Nuevo Pedido</a>
                        <a onclick="window.print()" class="btn btn-info mb-3">Imprimir Informe</a>
                    </div>
                    <div class="ml-auto pr-2 bd-highlight">
                        <form class="form-inline my-2 my-lg-0" method="POST" action="pedido.php">
                                <select class="form-control mr-1" id="filtro" name="filtro">
                                    <option value="id_pedido">ID</option>
                                    <option value="usuario">Usuario</option>
                                    <option value="fecha">Fecha</option>
                                    <option value="metodopago">Tipo de Pago</option>
                                </select>
                            <input class="form-control mr-sm-1" type="search" placeholder="Buscar" aria-label="Search" name="search">
                            <button class="btn btn-success my-1 my-sm-0" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>

                <div>
                    <?php

                    require "../conexion.php";

                    if (isset($_GET['page'])){
                        $page = (int) $_GET['page'];

                        $page = (int) ($page - 1) * 10;


                        $sql = "SELECT pedido.id_pedido, usuario.nombre, pedido.fecha, pedido.total, metodo_de_pago.metodo
                                FROM pedido
                                INNER JOIN usuario ON pedido.id_usuario=usuario.id_usuario
                                INNER JOIN metodo_de_pago ON pedido.id_metodo_de_pago=metodo_de_pago.id_metodo_de_pago
                                ORDER BY pedido.id_pedido
                                DESC
                                LIMIT 10 OFFSET $page";

                    } else if (isset($_POST['search'])){

                        $by = $_POST['filtro'];
                        $search = $_POST['search'];

                        if ($by == 'usuario'){
                            $by = 'usuario.nombre';
                        }else if ($by == 'metodopago'){
                            $by = 'metodo_de_pago.metodo';
                        }
                        else {
                            $by = 'pedido.' . $by;
                        }

                        $sql = "SELECT pedido.id_pedido, usuario.nombre, pedido.fecha, pedido.total, metodo_de_pago.metodo
                                FROM pedido
                                INNER JOIN usuario ON pedido.id_usuario=usuario.id_usuario
                                INNER JOIN metodo_de_pago ON pedido.id_metodo_de_pago=metodo_de_pago.id_metodo_de_pago
                                WHERE $by LIKE '%$search%'
                                ORDER BY pedido.id_pedido
                                DESC
                                LIMIT 10";
                    }else{

                        $sql = "SELECT pedido.id_pedido, usuario.nombre, pedido.fecha, pedido.total, metodo_de_pago.metodo
                                FROM pedido
                                INNER JOIN usuario ON pedido.id_usuario=usuario.id_usuario
                                INNER JOIN metodo_de_pago ON pedido.id_metodo_de_pago=metodo_de_pago.id_metodo_de_pago
                                ORDER BY pedido.id_pedido
                                DESC
                                LIMIT 10";

                    }

                    $result = $mysqli->query($sql);

                    if (!$result) {
                        echo "<div class='alert alert-danger'>Error en la consulta: " . $mysqli->error . "</div>";
                    } else {
                        if ($result->num_rows > 0) {
                            echo '<table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID Pedido</th>
                                            <th>Usuario</th>
                                            <th>Fecha</th>
                                            <th>Pago</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>
                                        <td>' . htmlspecialchars($row["id_pedido"]) . '</td>
                                        <td>' . htmlspecialchars($row["nombre"]) . '</td>
                                        <td>' . htmlspecialchars($row["fecha"]) . '</td>
                                        <td>' . htmlspecialchars($row["metodo"]) . '</td>
                                        <td>' . htmlspecialchars($row["total"]) . '</td>
                                        <td>
                                            <a href="consultar.pedido.administrador.php?id=' . urlencode($row["id_pedido"]) . '" class="btn btn-success btn-sm">Consultar</a>
                                            <a href="generar.devolucion.administrador.php?id_pedido=' . urlencode($row["id_pedido"]) . '" class="btn btn-danger btn-sm">Devolución</a>
                                        </td>
                                    </tr>';
                            }
                            echo '</tbody></table>';
                        } else {
                            echo "<div class='alert alert-info'>No hay registros de pedidos.</div>";
                        }

                        $result->free();
                    }
                    ?>
                </div>
            </div>
        </main>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                    $query_total = "SELECT COUNT(id_pedido) as pedidos FROM pedido";

                    if (isset($_GET['page'])){
                        $previous_page = (int) ($_GET['page'] - 1);
                        if ($previous_page == 0){
                            $previous_page= 1;
                        }
                    }else{
                        $previous_page= 1;
                    }
                    echo '<li class="page-item">
                    <a class="page-link" href="pedido.php?page=' . urlencode($previous_page) . '">Anterior</a>
                        </li>';
                    $result_total = $mysqli->query($query_total);

                    $total_results = $result_total->fetch_assoc();

                    $total_results = (int) $total_results["pedidos"];

                    $pages = ($total_results / 10);

                    $pages = ceil($pages);

                    for ($i = 1; $i <=$pages; $i++){
                        echo '<li class="page-item">
                                <a class="page-link" href="pedido.php?page=' . urlencode($i) . '">' . htmlspecialchars($i). '</a>
                                </li>';
                    }
                    if (isset($_GET['page'])){
                        $next_page = (int) $_GET['page'] + 1;
                        if ($next_page > $pages){
                            $next_page = $pages;
                        }
                    }else {
                        $next_page = 2;
                    }
                    echo '<li class="page-item">
                        <a class="page-link" href="pedido.php?page=' . urlencode($next_page) . '">Siguiente</a>
                    </li>';
                    ?>
            </ul>
        </nav>

        <footer class="bg-dark text-white py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; 2024 Ferretería Vagales. Todos los derechos reservados.</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="contacto.html" class="text-white">Contacto</a> |
                        <a href="privacidad.html" class="text-white">Política de Privacidad</a> |
                        <a href="terminos.html" class="text-white">Términos de Servicio</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy5Yk4pKjmb6/8tJTxXKoO4YHh5tFO4kD2Jg2w2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-rbsA7j6Fn5vK6e1jlg00uYFnbAM4A2E3xOSKq6xE7cqp9SZO+L/5Q/XfAkG4P1tn" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jG7s3e3SddU6zLZnCTunZ2a6D4iwHeL6vU2f9mB79mKwwm4eD" crossorigin="anonymous"></script>
</body>

</html>