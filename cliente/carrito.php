<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .product-card {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }

        .product-image {
            max-width: 100px;
            max-height: 150px;
            object-fit: cover;
            border: 1px solid #ccc;
            margin-right: 15px;
        }

        .product-details {
            flex-grow: 1;
        }

        .remove-product {
            cursor: pointer;
            color: red;
			height: 50px;
        }

        .total-container {
            font-size: 1.25rem;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>

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

    <div class="container mt-4">
        <h1 class="text-center mb-4">Carrito de Compras</h1>
        <div class="row">
            <div class="col-lg-8">
                <?php
				require "../conexion.php";
				
                if (isset($_SESSION['carrito'])) {
					$linea_pedido = $_SESSION['carrito'];

                    foreach ($linea_pedido as $libro => $cantidad) :
                        $sql = "SELECT titulo, precio, imagen FROM libro WHERE id_libro=$libro";
                        $resultado_libros = $mysqli->query($sql);
                        $libro_query = $resultado_libros->fetch_assoc();

                ?>
                        <div class="product-card">
                            <img src="<?php echo htmlspecialchars('../libros/'. $libro_query['imagen']); ?>" alt="<?php echo htmlspecialchars($libro_query['titulo']); ?>" class="product-image">
                            <div class="product-details">
                                <h5><?php echo htmlspecialchars($libro_query['titulo']); ?></h5>
                                <p>Precio Unitario: $<?php echo number_format($libro_query['precio'], 2); ?></p>
                                <div class="form-group">
                                    <label for="cantidad_<?php echo $libro; ?>">Cantidad</label>
                                    <input type="number" id="cantidad_<?php echo $libro; ?>" class="form-control cantidad-input" name="cantidades[]" value="<?php echo intval($cantidad); ?>">
                                </div>
								<button class="text-light btn btn-danger remove-product" style="font-weight: bold;"  data-id="<?php echo $libro; ?>">Eliminar</button>
                            </div>
							<p style="font-weight: bold;">Subtotal: $<span class="subtotal" style="font-weight: bold;"><?php echo number_format($libro_query['precio'] * $cantidad, 2); ?></span></p>
                        </div>
                <?php
                    endforeach;
                } else {
                    echo "<p>No hay productos en el carrito</p>";
                }
                ?>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Resumen del Pedido</h4>
                        <p class="total-container">Total: $<span id="totalAmount">0.000</span></p>
                        <form action="guardar.carrito.pedido.php" method="POST">
							<?php
							$id_usuario = intval($_SESSION['id_usuario']);
							$customer = $id_usuario;

							$fecha_y_hora = date("Y-m-d H:i:s");
							?>
							<input type="hidden" class="form-control" id="orderDate" name="orderDate" value="<?php echo $fecha_y_hora; ?>" readonly required>
							<input type="hidden" class="form-control" id="customer" name="customer" value="<?php echo $customer; ?>" readonly required>

							<?php
							foreach ($linea_pedido as $libro => $cantidad) :
								$sql = "SELECT titulo, precio FROM libro WHERE id_libro=$libro";
								$resultado_libros = $mysqli->query($sql);
								$libro_query = $resultado_libros->fetch_assoc();
							?>
								<tr>
									<td>
										<input type="hidden" class="form-control" name="libros_ids[]" value="<?php echo $libro; ?>" readonly required>
									</td>
									<td><input type="hidden" class="form-control cantidad-input" name="cantidades[]" value="<?php echo intval($cantidad); ?>" required></td>
									<td><input type="hidden" class="form-control precio-input" name="precios[]" value="<?php echo $libro_query['precio']; ?>" readonly required></td>
									<td><input type="hidden" class="form-control subtotal" name="subtotales[]" readonly required></td>
								</tr>
							<?php endforeach; ?>
							
                            <div class="form-group">
                                <label for="payment">Método de Pago</label>
								<?php
								$sql = "SELECT `id_metodo_de_pago`, `metodo` FROM `metodo_de_pago`";
								$payment_method = $mysqli->query($sql);
								$options_payment = "<option value=''>Selecciona un metodo de pago</option>";
								if ($payment_method->num_rows > 0) {
									while ($fila = $payment_method->fetch_assoc()) {
										$options_payment .= "<option value='" . htmlspecialchars($fila['id_metodo_de_pago']) . "'>" . htmlspecialchars($fila['metodo']) . "</option>";
									}
								}
								?>
								<select name="payment" id="payment" class="form-control" required>
                                    <?php echo $options_payment; ?>
                                </select>
								<input type="hidden" class="form-control" id="totalAmount" name="totalAmount" readonly>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Finalizar Pedido</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <script>
	$(document).ready(function () {
		updateTotal();

		$('.cantidad-input').on('input', function () {
			const $card = $(this).closest('.product-card');
			const cantidad = parseInt($(this).val(), 10) || 0;
			const precio = parseFloat(
				$card.find('.product-details p').text().replace(/[^\d.]/g, "")
			) || 0;
			const subtotal = cantidad * precio;
			$card.find('.subtotal').text(subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
			updateTotal();
		});

		$('.remove-product').on('click', function () {
			$(this).closest('.product-card').remove();
			updateTotal();
		});

		function updateTotal() {
			let total = 0;
			$('.subtotal').each(function () {
				const value = parseFloat($(this).text().replace(/[^\d.]/g, "")) || 0;
				total += value;
			});
			$('#totalAmount').text(total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
			$('input[name="totalAmount"]').val(total.toFixed(2)); // Asignar el valor al input hidden
		}
	});


    </script>
</body>

</html>
