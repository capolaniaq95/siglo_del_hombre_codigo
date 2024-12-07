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
                <a class="nav-link text-white" href="/cliente/carrito.php">
                  <div class="rounded-circle d-flex justify-content-center align-items-center"
                  style="background-color: #28a745; width: 30px; height: 30px;">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
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

        <div class="container mt-5">
            <h2>Formulario de Devolucion</h2>
            <?php

            require "../conexion.php";

            if (isset($_GET['id_pedido'])) {
                $id_pedido = intval($_GET['id_pedido']);

                $sql = "SELECT pedido.id_usuario, pedido.fecha 
                            FROM pedido 
                            WHERE id_pedido=$id_pedido";

                $result = $mysqli->query($sql);

                $pedido = $result->fetch_assoc();

                $sql = "SELECT linea_de_pedido.id_libro, linea_de_pedido.cantidad, libro.titulo 
                            FROM linea_de_pedido
                            INNER JOIN libro
                            ON linea_de_pedido.id_libro=libro.id_libro
                            WHERE linea_de_pedido.id_pedido=$id_pedido";

                $result_linea = $mysqli->query($sql);
            }
            $fecha_y_hora = date("Y-m-d H:i:s");

            ?>
            <?php if (isset($mensaje)) : ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
            <?php endif; ?>
            <form action="guardar.devolucion.php" method="POST">
                <div class="form-group">
                    <label for="orderDate">Fecha</label>
                    <input type="hidden" class="form-control" name="id_pedido" value="<?php echo $id_pedido; ?>" readonly required>
                    <input type="datetime-local" class="form-control" id="orderDate" name="orderDate" value="<?php echo $fecha_y_hora; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="customerName">Motivo</label>
                    <input type="text" class="form-control" name="motivo">
                </div>
                <div class="form-group">
                    <label for="paymentmethod">Descripcion del motivo</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                </div>

                <h4>Líneas de Pedido</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="orderLinesTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Libro</th>
                                <th>Cantidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($linea = $result_linea->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <input type="hidden" class="form-control" name="libros_ids[]" value="<?php echo $linea['id_libro']; ?>" readonly required>
                                        <input type="text" class="form-control" name="libros[]" value="<?php echo $linea['titulo']; ?>" readonly required>
                                    </td>
                                    <td><input type="number" class="form-control cantidad-input" name="cantidades[]" value="<?php echo intval($linea['cantidad']); ?>" required></td>
                                    <td><button type="button" class="btn btn-danger removeRow">Eliminar</button></td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
                <!-- Comentado el botón de agregar línea -->
                <!-- <button type="button" class="btn btn-secondary" id="addLineBtn">Agregar Línea</button> -->
                <button type="submit" class="btn btn-success">Generar Devolucion</button>
                <a href="../index.php" class="btn btn-secondary">Cancelar</a>
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