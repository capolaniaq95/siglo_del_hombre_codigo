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

$fecha_y_hora = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de movimiento inventario</title>
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
                                <a class="nav-link text-white dropdown-toggle" href="inventario.php" id="navbarDropdown" role="button">
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
        <div class="container mt-5">
            <h2>Formulario de movimiento de inventario</h2>
            <?php if (isset($mensaje)) : ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
            <?php endif; ?>
            <form action="guardar.movimiento.inventario.php" method="POST">
                <div class="form-group">
                    <label for="orderDate">Fecha</label>
                    <input type="text" class="form-control" id="orderDate" name="orderDate" value="<?php echo $fecha_y_hora; ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="customerName">ubicacion origen</label>
                    <select name="origen" id="origen" class="form-control" required>
                        <?php echo $options_ubicacion; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="customerName">Ubicacion Destino</label>
                    <select name="destino" id="destino" class="form-control" required>
                        <?php echo $options_ubicacion; ?>
                    </select>
                </div>
                <h4>Líneas de Pedido</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="orderLinesTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>libro</th>
                                <th>Cantidad</th>
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
                                <td><button type="button" class="btn btn-danger removeRow">Eliminar</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" id="addLineBtn">Agregar Línea</button>
                </div>
                <div class="form-group">
                    <button type="reset" class="btn btn-secondary">Cancelar</button>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Guardar movimiento</button>
                </div>

            </form>
        </div>

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