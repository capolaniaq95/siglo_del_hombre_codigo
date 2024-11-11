<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Devolucion</title>
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


        <div class="container mt-5">
            <h2>Formulario de Devolucion</h2>
            <?php
            require '../conexion.php';

            $id_pedido = intval($_REQUEST['id_pedido']);
            $orderDate = $_REQUEST['orderDate'];
            $motivo = $_REQUEST['motivo'];
            $descripcion = $_REQUEST['descripcion'];

            $libros_ids = array($_REQUEST['libros_ids']);
            $cantidades = array($_REQUEST['cantidades']);

            $referencia = 'Pedido' . $id_pedido;

            $sql = "SELECT * FROM `devolucion` WHERE devolucion.referencia='$referencia'";

            $result = $mysqli->query($sql);

            $num = $result->num_rows;

            if ($num != 0){
                echo "<script> alert('Esta pedido ya tiene una devolucion ralacionada. No puede generar otro');window.location='/pedidos/pedido.php' </script>";
                exit();
            }

            $sql = "INSERT INTO `devolucion`(`id_pedido`, `motivo`, `descripcion`, `fecha`, `estado`, `referencia`)
                    VALUES ($id_pedido,'$motivo','$descripcion','$orderDate', 'Proceso', '$referencia')";

            if ($mysqli->query($sql) === TRUE) {

                $query_id_devolucion = "SELECT `id_devolucion` FROM `devolucion`
                                        WHERE devolucion.id_pedido=$id_pedido
                                        AND devolucion.fecha='$orderDate'
                                        AND devolucion.motivo='$motivo'
                                        AND devolucion.descripcion='$descripcion'
                                        LIMIT 1";

                $result = $mysqli->query($query_id_devolucion);
                $devolcuion = $result->fetch_assoc();

                $id_devolucion = $devolcuion['id_devolucion'];

                if ($result->num_rows > 0) {
                    for ($i = 0; $i < count($libros_ids[0]); $i++) {

                        $id_libro = intval($libros_ids[0][$i]);
                        $cantidad = intval($cantidades[0][$i]);

                        $insert_linea_devolucion = "INSERT INTO `lineas_devolucion`(`id_devolucion`, `cantidad`, `id_libro`) 
                                                VALUES ($id_devolucion, $cantidad, $id_libro)";

                        $result = $mysqli->query($insert_linea_devolucion);
                    }
                    echo "<div class='alert alert-success'>Devolucion agregada correctamente.</div>";
                    echo "<a href='/pedidos/pedido.php' class='btn btn-primary'>Volver al menu principal</a>";
                    $mysqli->close();
                    exit;
                } else {

                    echo "error al generar devolucion";
                }
            } else {
                echo '<div class="error">Error: ' . $sql . '<br>' . $mysqli->error . '</div>';
            }

            ?>
</body>

</html>