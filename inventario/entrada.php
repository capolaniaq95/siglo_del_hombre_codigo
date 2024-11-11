<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entradas</title>
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
        


        .table td, .table th {
            white-space: nowrap; 
        }

        .table-container {
            width: 1000px;
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
                                <a class="nav-link text-white dropdown-toggle" href="inventario.php" id="navbarDropdown" role="button">
                                    Inventario
                                </a>
                                <div class="dropdown-menu-custom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="">Entradas</a>
                                    <a class="dropdown-item" href="/inventario/salida.php">Salidas</a>
                                    <a class="dropdown-item" href="/inventario/proceso.php">En proceso</a>
                                    <a class="dropdown-item" href="/inventario/completado.php">Completadas</a>
                                    <a class="dropdown-item" href="/inventario/existencias.php">Existencias</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="ubicacion.php">Ubicacion</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main class="flex-fill">
            <div class="container mt-4">
                <h2>Inventario</h2>
                <a href="agregar.movimiento.inventario.php" class="btn btn-info mb-3">Agregar Nuevo Inventario</a>
                <a onclick="window.print()" class="btn btn-info mb-3">Imprimir Informe</a>
                <div class="table-container">
                    <?php

                    require('../conexion.php');

                    $sql = "SELECT
                                movimiento_inventario.id_movimiento,
                                movimiento_inventario.fecha,
                                ubicacion_destino.ubicacion AS destino,
                                ubicacion_origen.ubicacion AS origen,
                                movimiento_inventario.tipo_movimiento,
                                movimiento_inventario.estado,
                                movimiento_inventario.referencia
                            FROM
                                movimiento_inventario
                            INNER JOIN
                                ubicacion AS ubicacion_destino ON movimiento_inventario.ubicacion_destino = ubicacion_destino.id_ubicacion
                            INNER JOIN
                                ubicacion AS ubicacion_origen ON movimiento_inventario.ubicacion_origen = ubicacion_origen.id_ubicacion
                            WHERE
                            movimiento_inventario.tipo_movimiento = 'entrada'";

                    $result = $mysqli->query($sql);

                    if (!$result) {
                        echo "<div class='alert alert-danger'>Error en la consulta: " . $mysqli->error . "</div>";
                    } else {
                        if ($result->num_rows > 0) {
                            echo '<table class="table table-bordered table-striped table-hover text-center">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID Movimiento Inv.</th>
                                            <th>Fecha</th>
                                            <th>Ubicacion Origen</th>
                                            <th>Ubicacion Destino</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                            <th>Referencia</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>
                                        <td>' . htmlspecialchars($row["id_movimiento"]) . '</td>
                                        <td>' . htmlspecialchars($row["fecha"]) . '</td>
                                        <td>' . htmlspecialchars($row["origen"]) . '</td>
                                        <td>' . htmlspecialchars($row["destino"]) . '</td>
                                        <td>' . htmlspecialchars($row["tipo_movimiento"]) . '</td>
                                        <td>' . htmlspecialchars($row["estado"]) . '</td>
                                        <td>' . htmlspecialchars($row["referencia"]) . '</td>
                                        <td>
                                            <a href="consultar.movimiento.php?id_movimiento=' . urlencode($row["id_movimiento"]) . '" class="btn btn-success btn-sm">Consultar</a>
                                        </td>
                                    </tr>';
                            }
                            echo '</tbody></table>';
                        } else {
                            echo "<div class='alert alert-info'>No hay registros de movimientos.</div>";
                        }

                        $result->free();
                    }

                    $mysqli->close();
                    ?>
                </div>
            </div>
        </main>

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
