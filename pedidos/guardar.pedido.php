<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container mt-4">
            <h2>Pedido agregado</h2>
            <?php
            require '../conexion.php';

            $orderDate = $_REQUEST['orderDate'];
            $customer = intval($_REQUEST['customer']);
			$payment = intval($_REQUEST['payment']);
            $libros = array($_REQUEST['libros']);
            $cantidades = array($_REQUEST['cantidades']);
            $precios = array($_REQUEST['precios']);
            $subtotales = array($_REQUEST['subtotales']);
            $totalAmount = floatval($_REQUEST['totalAmount']);


            $sql = "INSERT INTO `pedido`(`id_usuario`,`id_metodo_de_pago`, `fecha`, `total`)
                    VALUES ($customer, $payment, '$orderDate', $totalAmount)";

            if ($mysqli->query($sql) === TRUE) {

                $query_id_pedido = "SELECT `id_pedido` FROM `pedido`
                                    WHERE pedido.id_usuario=$customer
									AND pedido.id_metodo_de_pago=$payment
                                    AND pedido.fecha='$orderDate'
                                    AND pedido.total=$totalAmount";

                $result = $mysqli->query($query_id_pedido);
                $pedido = $result->fetch_assoc();

                $id_pedido = $pedido['id_pedido'];

                $referencia = 'Pedido' . intval($id_pedido);

                $query_insert_movimiento_salida = "INSERT INTO `movimiento_inventario`(`fecha`, `ubicacion_origen`, `ubicacion_destino`, `tipo_movimiento`, `estado`, `referencia`)
                                                   VALUES ('$orderDate', 1, 3,'salida','Proceso', '$referencia')";

                $insert_movimiento = $mysqli->query($query_insert_movimiento_salida);

                $query_id_inventario = "SELECT MAX(`id_movimiento`) AS 'id_movimiento'
                                        FROM `movimiento_inventario`
                                        WHERE movimiento_inventario.fecha='$orderDate'
                                        AND movimiento_inventario.ubicacion_origen=1
                                        AND movimiento_inventario.ubicacion_destino=3
                                        AND movimiento_inventario.tipo_movimiento='salida'
                                        AND movimiento_inventario.estado='Proceso'";

                $result = $mysqli->query($query_id_inventario);

                $movimiento = $result->fetch_assoc();

                $id_inventario = $movimiento['id_movimiento'];

                if ($result->num_rows > 0) {
                    for ($i = 0; $i < count($libros[0]); $i++) {

                        $id_libro = intval($libros[0][$i]);
                        $cantidad = intval($cantidades[0][$i]);
                        $sub_total = intval($subtotales[0][$i]);

                        $insert_linea_pedido = "INSERT INTO `linea_de_pedido`(`id_pedido`, `id_libro`, `cantidad`, `total_linea`)
                                                VALUES ($id_pedido, $id_libro, $cantidad, $sub_total)";

                        $result = $mysqli->query($insert_linea_pedido);

                        $insertar_linea_movimiento_inventario = "INSERT INTO `linea_movimiento_inventario`(`id_movimiento`, `id_libro`, `cantidad`)
                                                                 VALUES ($id_inventario, $id_libro, $cantidad)";

                       $mysqli->query($insertar_linea_movimiento_inventario);


                    }
                    echo "<div class='alert alert-success'>Pedido agregado correctamente.</div>";
                    echo "<a href='pedido.php' class='btn btn-primary'>Volver a la lista de pedidos</a>";
                    $mysqli->close();
                    exit;
                } else {

                    echo "error al generar pedido";
                }
            } else {
                echo '<div class="error">Error: ' . $sql . '<br>' . $mysqli->error . '</div>';
            }
            ?>
</body>

</html>