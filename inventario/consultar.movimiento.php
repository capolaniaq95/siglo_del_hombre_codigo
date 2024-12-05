<?php
require "../conexion.php";

$sql = "SELECT id_libro, titulo, precio FROM libro";
$resultado_libros = $mysqli->query($sql);
$options_libro = "<option value=''>Selecciona un libro</option>";
if ($resultado_libros->num_rows > 0) {
    while ($fila = $resultado_libros->fetch_assoc()) {
        $options_libro .= "<option value='" . htmlspecialchars($fila['id_libro']) . "' data-precio='" . htmlspecialchars($fila['precio']) . "'>" . htmlspecialchars($fila['titulo']) . "</option>";
    }
}


$sql = "SELECT `id_ubicacion`, `ubicacion` FROM `ubicacion`";
$resultado_ubicacion = $mysqli->query($sql);
$options_ubicacion = "<option value=''>Selecciona un ubicacion</option>";
if ($resultado_ubicacion->num_rows > 0) {
    while ($fila = $resultado_ubicacion->fetch_assoc()) {
        $options_ubicacion .= "<option value='" . htmlspecialchars($fila['id_ubicacion']) . "'>" . htmlspecialchars($fila['ubicacion']) . "</option>";
    }
}



if (isset($_GET['id_movimiento'])) {
    $id_movimiento = intval($_GET['id_movimiento']);

    $sql = "SELECT movimiento_inventario.fecha, 
					ubicacion_destino.ubicacion AS destino, 
					ubicacion_origen.ubicacion AS origen,
					movimiento_inventario.referencia,
					movimiento_inventario.estado
					FROM
					movimiento_inventario
					INNER JOIN
					ubicacion AS ubicacion_destino ON movimiento_inventario.ubicacion_destino = ubicacion_destino.id_ubicacion
					INNER JOIN
					ubicacion AS ubicacion_origen ON movimiento_inventario.ubicacion_origen = ubicacion_origen.id_ubicacion
					WHERE
					movimiento_inventario.id_movimiento = $id_movimiento";

    $result = $mysqli->query($sql);

    $movimiento = $result->fetch_assoc();

    $fecha = $movimiento['fecha'];
    $destino = $movimiento['destino'];
    $origen = $movimiento['origen'];
    $referencia = $movimiento['referencia'];
    $movimiento_estado = $movimiento['estado'];

    $sql = "SELECT linea_movimiento_inventario.cantidad, libro.titulo
			FROM
			linea_movimiento_inventario
			INNER JOIN
			libro
			ON linea_movimiento_inventario.id_libro=libro.id_libro
			WHERE
			linea_movimiento_inventario.id_movimiento=$id_movimiento";

    $result = $mysqli->query($sql);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar movimiento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
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
                                <a class="nav-link text-white dropdown-toggle" href="" id="navbarDropdown" role="button">
                                    Inventario
                                </a>
                                <div class="dropdown-menu-custom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/inventario/entrada.php">Entradas</a>
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
            <div class="d-flex align-items-center mb-1">
                <div class="pr-2">
                    <h2>Formulario de movimiento inventario</h2>
                </div>
                <div class="ml-auto">
                    <?php

                    require "../conexion.php";

                    if (isset($_GET['id_movimiento'])){

                        $id_movimiento = intval($_GET['id_movimiento']);

                        $sql = "SELECT referencia FROM movimiento_inventario WHERE id_movimiento=$id_movimiento";

                        $result = $mysqli->query($sql);

                        $referencia = $result->fetch_assoc();
						$referencia = $referencia['referencia'];

						if (str_contains($referencia, 'Devolucion')){

							preg_match_all('/\d+(\.\d+)?/', $referencia, $id_devolucion);

							echo '
                           <div class="img-container d-flex flex-row-reverse">
                            <a href="../devolucion/consultar.devolucion.php?id_devolucion=' . urlencode(intval($id_devolucion[0][0])) . '">
                                <div class="img-container px-1" style="width:70px;height:60px;">
                                    <img class="img-fluid" src="/images/devolucion.png" alt="devolucion">
                                </div>
                            </a>';
						}else if (str_contains($referencia, 'Pedido')){

                            preg_match_all('/\d+(\.\d+)?/', $referencia, $id_pedido);

                            echo '
                            <div class="img-container d-flex flex-row-reverse">
                            <a href="../pedidos/consultar.pedido.administrador.php?id=' . urlencode(intval($id_pedido[0][0])) . '">
                                <div class="img-container px-1" style="width:70px;height:60px;">
                                    <img class="img-fluid" src="/images/pedido.jpg" alt="entrada">
                                </div>
                            </a>';
                        }else {
                            echo '<div class="img-container d-flex flex-row-reverse">';
                        }

                    }
                    ?>
                    </div>
                </div> 
            </div>
                <?php

                    $query = "SELECT movimiento_inventario.fecha, 
                                ubicacion_destino.ubicacion AS destino, 
                                ubicacion_origen.ubicacion AS origen,
                                movimiento_inventario.referencia,
                                movimiento_inventario.estado
                                FROM
                                movimiento_inventario
                                INNER JOIN
                                ubicacion AS ubicacion_destino ON movimiento_inventario.ubicacion_destino = ubicacion_destino.id_ubicacion
                                INNER JOIN
                                ubicacion AS ubicacion_origen ON movimiento_inventario.ubicacion_origen = ubicacion_origen.id_ubicacion
                                WHERE
                                movimiento_inventario.id_movimiento = $id_movimiento";
                    
                    $result = $mysqli->query($query);

                    $movimiento = $result->fetch_assoc();
                
                    $fecha = $movimiento['fecha'];
                    $destino = $movimiento['destino'];
                    $origen = $movimiento['origen'];
                    $referencia = $movimiento['referencia'];
                    $movimiento_estado = $movimiento['estado'];
                    
                    $sql = "SELECT linea_movimiento_inventario.cantidad, libro.titulo
                            FROM
                            linea_movimiento_inventario
                            INNER JOIN
                            libro
                            ON linea_movimiento_inventario.id_libro=libro.id_libro
                            WHERE
                            linea_movimiento_inventario.id_movimiento=$id_movimiento";

                    $result_linea = $mysqli->query($sql);
            
                ?>
            
            <form action="guardar.movimiento.inventario.php" method="POST">
                <div class="form-group">
                    <label for="orderDate">Fecha</label>
                    <input type="text" class="form-control" id="orderDate" name="orderDate" value="<?php echo $fecha ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="customerName">ubicacion origen</label>
                    <input type="text" class="form-control" id="origen" name="origen" value="<?php echo $origen ?>" readonly required>
                </div>

                <div class="form-group">
                    <label for="customerName">Ubicacion Destino</label>
                    <input type="text" class="form-control" id="destino" name="destino" value="<?php echo $destino ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="orderDate">Referencia</label>
                    <input type="text" class="form-control" id="referencia" name="referencia" value="<?php echo $referencia ?>" readonly required>
                </div>
                <h4>Líneas de Pedido</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="orderLinesTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>libro</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($linea = $result_linea->fetch_assoc()):
                                $cantidad = intval($linea['cantidad']);
                                $libro = $linea['titulo'];
                            ?>
                                <tr>
                                    <td><input type="text" class="form-control quantity" name="libro" value="<?php echo $libro; ?>" readonly required></td>
                                    <td><input type="number" class="form-control quantity" name="cantidad" value="<?php echo $cantidad; ?>" readonly required></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <a href="inventario.php" class="btn btn-secondary">Atras</a>
                    <?php if ($movimiento_estado == 'Proceso'):
                        echo '<a href="completar.movimiento.php?id=' . urlencode($id_movimiento) . '" class="btn btn-success">Completar</a>';
                    endif; ?>
                </div>
            </form>
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

        <script>
            document.getElementById('addLineBtn').addEventListener('click', function() {
                const tableBody = document.getElementById('orderLinesTable').getElementsByTagName('tbody')[0];
                const newRow = tableBody.insertRow();
                newRow.innerHTML = `
                <tr>
                    <td>
                        <select name="libros[]" class="form-control productSelect" onchange="updatePrice(this)">
                            <?php echo $options_libro; ?>
                        </select>
                    </td>
                    <td><input type="number" class="form-control quantity" name="cantidades[]" onchange="calculateSubtotal(this)" required></td>
                    <td><button type="button" class="btn btn-danger removeRow">Eliminar</button></td>
                </tr>
            `;
                newRow.querySelector('.removeRow').addEventListener('click', function() {
                    tableBody.deleteRow(newRow.rowIndex - 1);
                    updateTotal();
                });
            });

            document.getElementById('orderLinesTable').addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('removeRow')) {
                    event.target.closest('tr').remove();
                    updateTotal();
                }
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
