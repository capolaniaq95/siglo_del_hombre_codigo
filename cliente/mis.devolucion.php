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

    <main class="flex-fill">
      <div class="container mt-4">
        <h2>Mis Devoluciones</h2>
        <div>
          <?php

          require "../conexion.php";

          $id_usuario = intval($_SESSION["id_usuario"]);

          $sql = "SELECT
                              devolucion.id_devolucion,
                              pedido.fecha,
                              pedido.total,
                              devolucion.motivo,
                              devolucion.estado,
                              devolucion.referencia
                            FROM
                              devolucion
                            INNER JOIN
                              pedido ON devolucion.id_pedido = pedido.id_pedido
                            WHERE
                              pedido.id_usuario=$id_usuario";

          $result = $mysqli->query($sql);

          if (!$result) {
            echo "<div class='alert alert-danger'>Error en la consulta: " . $mysqli->error . "</div>";
          } else {
            if ($result->num_rows > 0) {
              echo '<table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Fecha</th>
											                      <th>total</th>
                                            <th>Motivo devolucion</th>
                                            <th>Estado</th>
                                            <th>referencia</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

              while ($row = $result->fetch_assoc()) {
                echo '<tr>
                                        <td>' . htmlspecialchars($row["fecha"]) . '</td>
                                        <td>' . htmlspecialchars($row["total"]) . '</td>
                                        <td>' . htmlspecialchars($row["motivo"]) . '</td>
                                        <td>' . htmlspecialchars($row["estado"]) . '</td>
                                        <td>' . htmlspecialchars($row["referencia"]) . '</td>
                                        <td>
                                            <a href="consultar.devolucion.php?id_devolucion=' . urlencode($row["id_devolucion"]) . '" class="btn btn-success btn-sm">Consultar</a>
                                        </td>
                                    </tr>';
              }
              echo '</tbody></table>';
            } else {
              echo "<div class='alert alert-info'>No hay registros de devoluciones.</div>";
            }

            $result->free();
          }

          $mysqli->close();
          ?>
        </div>
      </div>
    </main>

    <footer class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <p>&copy; 2024 Librería Siglo del Hombre. Todos los derechos reservados.</p>
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

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy5Yk4pKjmb6/8tJTxXKoO4YHh5tFO4kD2Jg2w2" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-rbsA7j6Fn5vK6e1jlg00uYFnbAM4A2E3xOSKq6xE7cqp9SZO+L/5Q/XfAkG4P1tn" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jG7s3e3SddU6zLZnCTunZ2a6D4iwHeL6vU2f9mB79mKwwm4eD" crossorigin="anonymous"></script>
</body>

</html>