<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar movimiento inventario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                                <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button">
                                    Inventario
                                </a>
                                <div class="dropdown-menu-custom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="entrada.php">Entradas</a>
                                    <a class="dropdown-item" href="salida.php">Salidas</a>
                                    <a class="dropdown-item" href="proceso.php">En proceso</a>
                                    <a class="dropdown-item" href="completado.php">Completadas</a>
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
        <div class="container mt-4">
            <h2>Movimiento Completado</h2>
            <?php

            require '../conexion.php';

            if (isset($_GET['id'])) {

                $id_movimiento = intval($_GET['id']);

                $sql = "UPDATE `movimiento_inventario` SET `estado`='Completado' WHERE id_movimiento=$id_movimiento";

                $result = $mysqli->query($sql);
                $sql = "SELECT libro.id_libro, libro.estado, linea_movimiento_inventario.cantidad
						FROM linea_movimiento_inventario
						INNER JOIN libro
						ON linea_movimiento_inventario.id_libro = libro.id_libro
						WHERE linea_movimiento_inventario.id_movimiento = $id_movimiento";

                $result = $mysqli->query($sql);

                $sql_tipo_movimiento = "SELECT tipo_movimiento 
                                        FROM movimiento_inventario 
                                        WHERE id_movimiento=$id_movimiento";

                $tipo_movimiento = $mysqli->query($sql_tipo_movimiento);

                $tipo_movimiento = $tipo_movimiento->fetch_assoc();

                if ($result->num_rows > 0) {
                    while ($linea_movimiento = $result->fetch_assoc()) {

                        $cantidad = intval($linea_movimiento['cantidad']);
                        $id_libro = intval($linea_movimiento['id_libro']);

                        $sql = "SELECT libro.titulo, libro.stock
								FROM libro
								WHERE id_libro=$id_libro";

                        $result_libro = $mysqli->query($sql);
                        $libro = $result_libro->fetch_assoc();

                        if ($tipo_movimiento['tipo_movimiento'] == 'salida') {
                            $stock = intval($libro['stock']) - $cantidad;
                        } else {
                            $stock = intval($libro['stock']) + $cantidad;
                        }


                        $titulo = $libro['titulo'];
                        if ($stock > 0) {
                            $estado = 'Disponible';
                        } else {
                            $estado = 'No Disponible';
                            echo "<div class='alert alert-danger'>Cantidad del libro $titulo(id=$id_libro) menor o igual a 0. (cantidad=$cantidad) (stock=$stock)</div>";
                        }

                        $update_stock = "UPDATE `libro` SET `stock`=$stock,`estado`='$estado' WHERE `id_libro`=$id_libro";
                        $result_update = $mysqli->query($update_stock);
                    }
                    echo "<div class='alert alert-success'>Movimiento completado correctamente.</div>";
                    echo "<a href='inventario.php' class='btn btn-primary'>Volver a la lista de Inventario</a>";
                }
            }

            ?>
</body>

</html>