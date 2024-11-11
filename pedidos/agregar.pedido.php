<?php
require "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $orderDate = $_POST['orderDate'];
    $customerId = $_POST['customer'];
    $totalAmount = $_POST['totalAmount'];
    $libros = $_POST['productos'];
    $cantidades = $_POST['cantidades'];
    $precios = $_POST['precios'];
    $subtotales = $_POST['subtotales'];


    $mysqli->begin_transaction();

    try {

        $sql = "INSERT INTO pedido (id_usuario, fecha, total) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("isd", $customerId, $orderDate, $totalAmount);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        $stmt->close();


        $sql = "INSERT INTO linea_pedido (id_pedido, id_producto, cantidad, precio, subtotal) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);

        for ($i = 0; $i < count($productos); $i++) {
            $productoId = $productos[$i];
            $cantidad = $cantidades[$i];
            $precio = $precios[$i];
            $subtotal = $subtotales[$i];

            $stmt->bind_param("iiidd", $orderId, $productoId, $cantidad, $precio, $subtotal);
            $stmt->execute();
        }

        $stmt->close();


        $mysqli->commit();


        $mensaje = "Pedido guardado correctamente.";
    } catch (Exception $e) {

        $mysqli->rollback();
        $mensaje = "Error al guardar el pedido: " . $e->getMessage();
    }
}


$sql = "SELECT id_usuario, nombre FROM usuario";
$resultado = $mysqli->query($sql);
$options_costumer = "<option value=''>Selecciona un usuario</option>";
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $options_costumer .= "<option value='" . htmlspecialchars($fila['id_usuario']) . "'>" . htmlspecialchars($fila['nombre']) . "</option>";
    }
}

$sql = "SELECT id_libro, titulo, precio FROM libro";
$resultado_libro = $mysqli->query($sql);
$options_libro = "<option value=''>Selecciona un libro</option>";
if ($resultado_libro->num_rows > 0) {
    while ($fila = $resultado_libro->fetch_assoc()) {
        $options_libro .= "<option value='" . htmlspecialchars($fila['id_libro']) . "' data-precio='" . htmlspecialchars($fila['precio']) . "'>" . htmlspecialchars($fila['titulo']) . "</option>";
    }
}

$sql = "SELECT `id_metodo_de_pago`, `metodo` FROM `metodo_de_pago`";
$payment_method = $mysqli->query($sql);
$options_payment = "<option value=''>Selecciona un metodo de pago</option>";
if ($payment_method->num_rows > 0) {
    while ($fila = $payment_method->fetch_assoc()) {
        $options_payment .= "<option value='" . htmlspecialchars($fila['id_metodo_de_pago']) . "'>" . htmlspecialchars($fila['metodo']) . "</option>";
    }
}


$fecha_y_hora = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pedido</title>
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
            <h2>Formulario de Pedido</h2>
            <?php if (isset($mensaje)) : ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
            <?php endif; ?>
            <form action="guardar.pedido.php" method="POST">
                <div class="form-group">
                    <label for="orderDate">Fecha</label>
                    <input type="text" class="form-control" id="orderDate" name="orderDate" value="<?php echo $fecha_y_hora; ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="customerName">Nombre del Cliente</label>
                    <select name="customer" id="customer" class="form-control" required>
                        <?php echo $options_costumer; ?>
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
                            <tr>
                                <td>
                                    <select name="libros[]" class="form-control productSelect" onchange="updatePrice(this)">
                                        <?php echo $options_libro; ?>
                                    </select>
                                </td>
                                <td><input type="number" class="form-control quantity" name="cantidades[]" onchange="calculateSubtotal(this)" required></td>
                                <td><input type="number" class="form-control price" name="precios[]" readonly required></td>
                                <td><input type="number" class="form-control subtotal" name="subtotales[]" readonly required></td>
                                <td><button type="button" class="btn btn-danger removeRow">Eliminar</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-secondary" id="addLineBtn">Agregar Línea</button>

                <div class="form-group mt-3">
                    <label for="totalAmount">Total</label>
                    <input type="number" class="form-control" id="totalAmount" name="totalAmount" readonly>
                </div>

                <button type="submit" class="btn btn-success">Guardar Pedido</button>
                <button type="reset" class="btn btn-secondary">Cancelar</button>
            </form>
        </div>

        <script>
            function updatePrice(select) {
                const row = select.closest('tr');
                const priceInput = row.querySelector('.price');
                const selectedOption = select.options[select.selectedIndex];
                priceInput.value = selectedOption.getAttribute('data-precio') || '';
                calculateSubtotal(row.querySelector('.quantity'));
                updateTotal();
            }

            function calculateSubtotal(input) {
                const row = input.closest('tr');
                const quantity = row.querySelector('.quantity').value;
                const price = row.querySelector('.price').value;
                const subtotalInput = row.querySelector('.subtotal');
                subtotalInput.value = (quantity * price).toFixed(2) || '';
                updateTotal();
            }

            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.subtotal').forEach(function(subtotal) {
                    total += parseFloat(subtotal.value) || 0;
                });
                document.getElementById('totalAmount').value = total.toFixed(2);
            }

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
                    <td><input type="number" class="form-control price" name="precios[]" readonly required></td>
                    <td><input type="number" class="form-control subtotal" name="subtotales[]" readonly required></td>
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