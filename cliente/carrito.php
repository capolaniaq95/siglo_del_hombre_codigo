<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
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
              <a class="nav-link text-white" href="mis.devolucion.php">Mis Devoluciones</a>
            </li>
            <?php
            if ($_SESSION["id_tipo"] == 1): ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="../index.administrador.php">Administrador</a>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="../logout.php">Logout</a>
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
              <a class="nav-link text-white" href="../login.php">Ingresar</a>
            </li>
          <?php endif; ?>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="POST" action="libros.php">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" name="search">
          <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>
</header>
        <main class="flex-fill">
            <div class="container mt-4">
                <h2>Carrito Compras</h2>
                <?php
                require "../conexion.php";
                if (isset($_SESSION["carrito"])) {

                    $id_usuario = intval($_SESSION['id_usuario']);
                    $sql = "SELECT nombre FROM usuario WHERE `id_usuario`=$id_usuario";
                    $resultado = $mysqli->query($sql);
                    $options_usuario = "";
                    if ($resultado->num_rows > 0) {
                        $usuario = $resultado->fetch_assoc();
                        $options_usuario .= "<option value='" . htmlspecialchars($id_usuario) . "'>" . $usuario['nombre'] . "</option>";
                    }
                    $fecha_y_hora = date("Y-m-d H:i:s");

                    $linea_pedido = $_SESSION['carrito'];

                    $sql = "SELECT `id_metodo_de_pago`, `metodo` FROM `metodo_de_pago`";
                    $payment_method = $mysqli->query($sql);
                    $options_payment = "<option value=''>Selecciona un metodo de pago</option>";
                    if ($payment_method->num_rows > 0) {
                        while ($fila = $payment_method->fetch_assoc()) {
                            $options_payment .= "<option value='" . htmlspecialchars($fila['id_metodo_de_pago']) . "'>" . htmlspecialchars($fila['metodo']) . "</option>";
                        }
                    }
                ?>
                    <form action="guardar.carrito.pedido.php" method="POST">
                        <div class="form-group">
                            <label for="orderDate">Fecha</label>
                            <input type="text" class="form-control" id="orderDate" name="orderDate" value="<?php echo $fecha_y_hora; ?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="customerName">Nombre del Cliente</label>
                            <select name="customer" id="customer" class="form-control" readonly required>
                                <?php echo $options_usuario; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="paymentmethod">Metodo de Pago</label>
                            <select name="payment" id="payment" class="form-control" required>
                                <?php echo $options_payment; ?>
                            </select>
                        </div>

                        <h4>Líneas de Pedido</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="orderLinesTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Libro</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($linea_pedido as $libro => $cantidad) :
                                        $sql = "SELECT titulo, precio FROM libro WHERE id_libro=$libro";
                                        $resultado_libros = $mysqli->query($sql);
                                        $libro_query = $resultado_libros->fetch_assoc();
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" class="form-control" name="libros_ids[]" value="<?php echo $libro; ?>" readonly required>
                                                <input type="text" class="form-control" name="libros[]" value="<?php echo $libro_query['titulo']; ?>" readonly required>
                                            </td>
                                            <td><input type="number" class="form-control cantidad-input" name="cantidades[]" value="<?php echo intval($cantidad); ?>" required></td>
                                            <td><input type="number" class="form-control precio-input" name="precios[]" value="<?php echo $libro_query['precio']; ?>" readonly required></td>
                                            <td><input type="number" class="form-control subtotal" name="subtotales[]" readonly required></td>
                                            <td><button type="button" class="btn btn-danger removeRow">Eliminar</button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group mt-3">
                            <label for="totalAmount">Total</label>
                            <input type="number" class="form-control" id="totalAmount" name="totalAmount" readonly>
                        </div>

                        <button type="submit" class="btn btn-success">Guardar Pedido</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </form>
                <?php
                } else {
                    echo "<div class='alert alert-info'>No hay registros en carrito de compras</div>";
                }
                ?>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            updateAll();

            // Reasignar eventos después de asegurarse de que jQuery está completamente cargado
            $('.cantidad-input').on('input', function () {
                updateSubtotal(this.closest('tr'));
                updateTotal();
            });

            $('#orderLinesTable').on('click', '.removeRow', function () {
                $(this).closest('tr').remove();
                updateTotal();
            });

            function updateSubtotal(row) {
                const cantidad = parseFloat($(row).find('.cantidad-input').val()) || 0;
                const precio = parseFloat($(row).find('.precio-input').val()) || 0;
                const subtotal = cantidad * precio;
                $(row).find('.subtotal').val(subtotal.toFixed(2));
            }

            function updateTotal() {
                let total = 0;
                $('.subtotal').each(function () {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#totalAmount').val(total.toFixed(2));
            }

            function updateAll() {
                $('#orderLinesTable tbody tr').each(function () {
                    updateSubtotal(this);
                });
                updateTotal();
            }
        });
    </script>
</body>

</html>