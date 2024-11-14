<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
                    <!-- Alinea el título a la izquierda -->
                    <a class="navbar-brand px-2 text-white" href="../index.administrador.php">Siglo del Hombre</a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Alinea los elementos del menú a la izquierda utilizando "mr-auto" -->
                        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../pedidos/pedido.php">Pedidos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../pedidos/metodo.pago.php">Metodo de Pago</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="devolucion.php" id="navbarDropdown" role="button">
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

        <div class="container mt-5">
            <div class="pr-2">
                <h2>Consultar pedido</h2>
            </div>
            <div class="ml-auto">
                <?php
                require "../conexion.php";
                
                if (isset($_GET['id_devolucion'])) {

                    $id_devolucion = intval($_GET['id_devolucion']);

                    $sql = "SELECT referencia FROM devolucion WHERE id_devolucion=$id_devolucion";

                    $result = $mysqli->query($sql);

                    $referencia = $result->fetch_assoc();

                    $referencia = $referencia['referencia'];

                    $id_pedido = intval(preg_replace('/[^0-9]+/', '', $referencia));

                    var_dump($id_pedido);
                ?>
            </div>
            <?php

            

            if (isset($_GET['id_devolucion'])) {

                $id_devolucion = intval($_GET['id_devolucion']);


                $sql = "SELECT `motivo`, `descripcion`, `fecha`, `estado`, referencia
                        FROM `devolucion`
                        WHERE id_devolucion = $id_devolucion";

                $result = $mysqli->query($sql);

                $devolucion = $result->fetch_assoc();

                $sql = "SELECT lineas_devolucion.cantidad, libro.titulo, lineas_devolucion.id_libro
                        FROM lineas_devolucion
                        INNER JOIN libro
                        ON lineas_devolucion.id_libro = libro.id_libro
                        WHERE lineas_devolucion.id_devolucion = $id_devolucion";

                $result_linea = $mysqli->query($sql);
            }
            ?>
            <?php if (isset($mensaje)) : ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
            <?php endif; ?>
            <form action="guardar.devolucion.php" method="POST">
                <div class="form-group">
                    <label for="orderDate">Fecha</label>
                    <input type="hidden" class="form-control" name="id_devolucion" value="<?php echo $id_devolucion; ?>" readonly required>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="<?php echo $devolucion['fecha']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="customerName">Motivo</label>
                    <input type="text" class="form-control" name="motivo" value="<?php echo $devolucion['motivo']; ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="paymentmethod">Descripcion del motivo</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" readonly required><?php echo $devolucion['descripcion']; ?></textarea>
                </div>

                <h4>Líneas de Pedido</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="orderLinesTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Libro</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($linea = $result_linea->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <input type="hidden" class="form-control" name="libros_ids[]" value="<?php echo $linea['id_libro']; ?>" readonly required>
                                        <input type="text" class="form-control" name="libros[]" value="<?php echo $linea['titulo']; ?>" readonly required>
                                    </td>
                                    <td><input type="number" class="form-control cantidad-input" name="cantidades[]" value="<?php echo intval($linea['cantidad']); ?>" readonly required></td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>

                <a href="devolucion.php" class="btn btn-secondary">Atras</a>
                <?php if ($devolucion['estado'] == 'Proceso') {  ?>
                    <a href="aceptar.devolucion.php?id_devolucion=<?php echo $id_devolucion; ?>" class="btn btn-success">Aceptar</a>
                    <a href="rechazar.devolucion.php?id_devolucion=<?php echo $id_devolucion; ?>" class="btn btn-danger">Rechazar</a>
                <?php }else if($devolucion['estado'] == 'Aceptada') { ?>
                    <a href="generar.movimiento.php?id_devolucion=<?php echo $id_devolucion; ?>" class="btn btn-success">Generar movimiento</a>
                <?php  } ?>
            </form>
        </div>

        <script>
            document.getElementById('orderLinesTable').addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('removeRow')) {
                    event.target.closest('tr').remove();
                }
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </div>
</body>

</html>