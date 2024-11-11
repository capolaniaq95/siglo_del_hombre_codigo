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
      <a class="navbar-brand px-2 text-white" href="../index.php">Siglo del Hombre</a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-white" href="libros.php">Libros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="autores.php">Autores</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="categorias.php">Categorías</a>
          </li>

          <?php
          session_start();
          if (isset($_SESSION["id_usuario"])): ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="mis.pedidos.php">Mis Pedidos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="devolucion.php">Mis Devoluciones</a>
            </li>
            <?php
            if ($_SESSION["id_tipo"] == 1): ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="index.administrador.php">Administrador</a>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="logout.php">Logout</a>
            </li>
            <?php if (isset($_SESSION['carrito'])): ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="carrito.php">
                  <i class="fas fa-shopping-cart"></i>
                </a>
              </li>
            <?php endif; ?>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="login.php">Ingresar</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

        <div class="container mt-4">
            <h2>Carrito agregado</h2>
            <?php
            require '../conexion.php';

            $orderDate = $_REQUEST['orderDate'];
            $customer = intval($_REQUEST['customer']);
			$payment = intval($_REQUEST['payment']);
            $libros = array($_REQUEST['libros_ids']);
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

                $referencia = "Pedido" . $id_pedido;

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

                        if (isset($_SESSION['carrito'])) {
                            unset($_SESSION['carrito']);
                        }

                    }
                    echo "<div class='alert alert-success'>Carrito de compras agregado correctamente.</div>";
                    echo "<a href='../index.php' class='btn btn-primary'>Volver a la pagina principal</a>";
                    $mysqli->close();
                    exit;
                } else {

                    echo "error al generar compra";
                }
            } else {
                echo '<div class="error">Error: ' . $sql . '<br>' . $mysqli->error . '</div>';
            }
            ?>
</body>

</html>