<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuarios</title>
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

        .nav-item:hover .dropdown-menu-custom {
            display: block;
        }
    </style>
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
    <header>
            <nav class="navbar navbar-expand-lg navbar-primary bg-info">
                <div class="container-fluid">
                    <a class="navbar-brand px-2 text-white" href="../index.administrador.php">Siglo del Hombre</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="usuario.php" id="navbarDropdown" role="button">
                                    Usuarios
                                </a>
                                <div class="dropdown-menu-custom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/usuarios/cliente.php">Clientes</a>
                                    <a class="dropdown-item" href="/usuarios/administrador.php">Administradores</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main class="flex-fill">
            <div class="container mt-4">
                <h2>Administradores</h2>
                <div class="d-flex bd-highlight mb-1">
                    <div class="pr-2 bd-highlight">
                    <a href="agregar.usuario.php" class="btn btn-info mb-3">Agregar Nuevo Usuario</a>
                    <a onclick="window.print()" class="btn btn-info mb-3">Imprimir Informe</a>
                    </div>
                    <div class="ml-auto pr-2 bd-highlight">
                        <form class="form-inline my-2 my-lg-0" method="POST" action="administrador.php">
                                <select class="form-control mr-1" id="filtro" name="filtro">
                                    <option value="id_usuario">ID</option>
                                    <option value="correo">Correo</option>
                                    <option value="direccion">Direccion</option>
                                    <option value="nombre">Nombre</option>
                                    <option value="celular">Celular</option>
                                </select>
                            <input class="form-control mr-sm-1" type="search" placeholder="Buscar" aria-label="Search" name="search">
                            <button class="btn btn-success my-1 my-sm-0" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
                <div>
                    <?php
                    require '../conexion.php';

                    if (isset($_GET['page'])){

                        $page = (int) $_GET['page'];

                        $page = (int) ($page - 1) * 10;


                        $sql = "SELECT usuario.id_usuario, usuario.correo, usuario.direccion, 
                                       usuario.nombre, usuario.celular, tipo_de_usuario.tipo
                                FROM usuario
                                INNER JOIN tipo_de_usuario ON usuario.id_tipo=tipo_de_usuario.id_tipo
                                WHERE usuario.id_tipo=1
                                ORDER BY id_usuario
                                DESC
                                LIMIT 10 OFFSET $page";

                    }else if (isset($_POST['search'])){

                        $by = $_POST['filtro'];
                        $search = $_POST['search'];

                        if ($by == 'id_tipo'){
                            $by = 'tipo_de_usuario.tipo';
                        }else {
                            $by = 'usuario.'. $by;
                        }


                        $sql = "SELECT usuario.id_usuario, usuario.correo, usuario.direccion, 
                                       usuario.nombre, usuario.celular, tipo_de_usuario.tipo
                                FROM usuario
                                INNER JOIN tipo_de_usuario ON usuario.id_tipo=tipo_de_usuario.id_tipo
                                WHERE usuario.id_tipo=1 AND
                                $by LIKE '%$search%'
                                ORDER BY id_usuario
                                DESC
                                LIMIT 10";

                    }else {
                        $sql = "SELECT usuario.id_usuario, usuario.correo, usuario.direccion,
                                usuario.nombre, tipo_de_usuario.tipo, usuario.celular
                                FROM usuario
                                INNER JOIN tipo_de_usuario ON usuario.id_tipo=tipo_de_usuario.id_tipo
                                WHERE usuario.id_tipo=1";
                    }
                    $result = $mysqli->query($sql);

                    if (!$result) {
                        echo "<div class='alert alert-danger'>Error en la consulta: " . $mysqli->error . "</div>";
                    } else {
                        if ($result->num_rows > 0) {
                            echo '<table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                          <th scope="col">ID usuario</th>
                                          <th scope="col">Correo</th>
                                          <th scope="col">Direccion</th>
                                          <th scope="col">Nombre</th>
                                          <th scope="col">Celular</th>
                                          <th scope="col">Tipo</th>
                                          <th scope="col" style="width: 200px">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>
                                        <td>' . htmlspecialchars($row["id_usuario"]) . '</td>
                                        <td>' . htmlspecialchars($row["correo"]) . '</td>
                                        <td>' . htmlspecialchars($row["direccion"]) . '</td>
                                        <td>' . htmlspecialchars($row["nombre"]) . '</td>
                                        <td>' . htmlspecialchars($row["celular"]) . '</td>
                                        <td>' . htmlspecialchars($row["tipo"]) . '</td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <a href="editar.usuario.php?id=' . urlencode($row["id_usuario"]) . '" class="btn btn-success btn-sm mr-2">Editar</a>
                                                <a href="eliminar.usuario.php?id=' . urlencode($row["id_usuario"]) . '" class="btn btn-danger btn-sm">Eliminar</a>
                                            </div>
                                        </td>
                                    </tr>';
                            }
                            echo '</tbody></table>';
                        } else {
                            echo "<div class='alert alert-info'>No hay registros de Usuarios.</div>";
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
                    $query_total = "SELECT COUNT(id_usuario) as administradores FROM usuario WHERE id_tipo=1";

                    if (isset($_GET['page'])){
                        $previous_page = (int) ($_GET['page'] - 1);
                        if ($previous_page == 0){
                            $previous_page= 1;
                        }
                    }else{
                        $previous_page= 1;
                    }
                    echo '<li class="page-item">
                    <a class="page-link" href="administrador.php?page=' . urlencode($previous_page) . '">Anterior</a>
                        </li>';
                    $result_total = $mysqli->query($query_total);

                    $total_results = $result_total->fetch_assoc();

                    $total_results = (int) $total_results["administradores"];

                    $pages = ($total_results / 10);

                    $pages = ceil($pages);

                    for ($i = 1; $i <=$pages; $i++){
                        echo '<li class="page-item">
                                <a class="page-link" href="administrador.php?page=' . urlencode($i) . '">' . htmlspecialchars($i). '</a>
                                </li>';
                    }
                    if (isset($_GET['page'])){
                        $next_page = (int) $_GET['page'] + 1;
                        if ($next_page > $pages){
                            $next_page = $pages;
                        }
                    }else if ($pages > 1) {
                        $next_page = 2;
                    }else{
                        $next_page = 1;
                    }

                    echo '<li class="page-item">
                        <a class="page-link" href="administrador.php?page=' . urlencode($next_page) . '">Siguiente</a>
                    </li>';


                    $mysqli->close();
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