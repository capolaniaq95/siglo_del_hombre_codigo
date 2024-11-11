<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                                    <a class="dropdown-item" href="#">Entradas</a>
                                    <a class="dropdown-item" href="#">Salidas</a>
                                    <a class="dropdown-item" href="#">En proceso</a>
                                    <a class="dropdown-item" href="#">Completadas</a>
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
            <h2>Movimiento agregado</h2>
            <?php

            require '../conexion.php';

            $orderDate = $_REQUEST["orderDate"];
            $origen = intval($_REQUEST["origen"]);
            $destino = intval($_REQUEST["destino"]);
            $libros = array($_REQUEST["libros"]);
            $cantidades = array($_REQUEST["cantidades"]);


            if ($origen == 2 && $destino == 1) {
                $tipo_movimiento = "entrada";
            } else if ($origen == 1 && $destino == 3) {
                $tipo_movimiento = "salida";
            } else {
                die("<script> alert('Movimiento no permitido');window.location='agregar.movimiento.inventario.php' </script>");
            }

            session_start();

            $referencia = "AdministradorID" . (string)$_SESSION["id_usuario"];

            $sql = "INSERT INTO `movimiento_inventario`( `fecha`, `ubicacion_destino`, `ubicacion_origen`, `tipo_movimiento`, `estado`, `referencia`)
					VALUES ('$orderDate',$destino, $origen, '$tipo_movimiento', 'Completado', '$referencia')";

            if ($mysqli->query($sql) === TRUE) {

                $query_id_inventario = "SELECT `id_movimiento`
                                        FROM `movimiento_inventario`
                                        WHERE movimiento_inventario.fecha='$orderDate' AND movimiento_inventario.ubicacion_destino=$destino
										AND movimiento_inventario.ubicacion_origen=$origen AND movimiento_inventario.tipo_movimiento='$tipo_movimiento'";

                $result = $mysqli->query($query_id_inventario);
                $movimiento = $result->fetch_assoc();
                $id_inventario = $movimiento['id_movimiento'];
                if ($result->num_rows > 0) {
                    for ($i = 0; $i < count($libros[0]); $i++) {
                        $id_libro = intval($libros[0][$i]);
                        $cantidad = intval($cantidades[0][$i]);
                        $insertar_linea_movimiento_inventario = "INSERT INTO `linea_movimiento_inventario`(`id_movimiento`, `id_libro`, `cantidad`)
                        VALUES ($id_inventario, $id_libro, $cantidad)";
                        $mysqli->query($insertar_linea_movimiento_inventario);

                        $query_stock = "SELECT libro.stock, libro.estado FROM libro WHERE libro.id_libro=$id_libro";
                        $result_stock = $mysqli->query($query_stock);
                        $stock_query = $result_stock->fetch_assoc();

                        if ($tipo_movimiento == "entrada") {
                            $stock = intval(intval($stock_query['stock']) + $cantidad);
                        } else {
                            $stock = intval(intval($stock_query['stock']) - $cantidad);
                        }

                        if ($stock > 0) {
                            $estado = 'Disponible';
                        } else {

                            $estado = 'No Disponible';
                        }
                        $update_stock = "UPDATE `libro` SET `stock`=$stock,`estado`='$estado' WHERE `id_libro`=$id_libro";
                        $result_update = $mysqli->query($update_stock);
                    }
                    echo "<div class='alert alert-success'>movimiento agregado correctamente</div>";
                    echo "<a href='inventario.php' class='btn btn-primary'>Volver a la lista de inventario</a>";
                }
            }



            ?>
</body>

</html>