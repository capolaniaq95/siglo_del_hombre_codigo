<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Autores y Libros</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    .main-content {
      flex: 1;
    }

    .card-custom {
      border: 1px solid #dee2e6;
      border-radius: 0.5rem;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      transition: transform 0.2s;
      height: 100%;
    }

    .card-custom:hover {
      transform: scale(1.05);
    }

    .card-img-top {
        width: 100%;
      height: 15rem; /* Ajusta la altura para mostrar más de la imagen */
      object-fit: contain;
      display: block; /* Muestra la imagen completa */
    }

    .card-body {
      padding: 1.5rem;
    }

    .card-footer {
      background-color: #f8f9fa;
    }

    .footer-custom {
      background-color: #6c757d; /* Gris oscuro */
      color: white;
      padding: 1rem 0;
    }

    .footer-custom a {
      color: white;
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

  <main class="main-content">
    <section>
      <div class="container" style="padding: 30px;">
        <?php
        // Conexión a la base de datos
        $mysqli = new mysqli('localhost', 'root', '', 'siglo_del_hombre');

        // Verificar la conexión
        if ($mysqli->connect_error) {
          die('Error en la conexión: ' . $mysqli->connect_error);
        }
        
        if (isset($_GET['id_autor'])) {
          $idAutor = intval($_GET['id_autor']);

          // Consulta para obtener los libros del autor
          $sqlLibros = "
            SELECT libro.id_libro, libro.titulo, libro.imagen, libro.descripcion, libro.precio, autor.nombre AS autor
            FROM libro
            JOIN autor ON libro.id_autor = autor.id_autor
            WHERE libro.id_autor = ?
          ";
          $stmt = $mysqli->prepare($sqlLibros);
          $stmt->bind_param('i', $idAutor);
          $stmt->execute();
          $resultLibros = $stmt->get_result();

          if ($resultLibros->num_rows > 0) {
            echo '<h1 class="mb-4">Libros de ' . htmlspecialchars($_GET['nombre_autor'], ENT_QUOTES, 'UTF-8') . '</h1>';
            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';
            while ($row = $resultLibros->fetch_assoc()) {
              $imagenLibroRuta = htmlspecialchars($row['imagen'], ENT_QUOTES, 'UTF-8');
              $idLibro = htmlspecialchars($row["id_libro"], ENT_QUOTES, 'UTF-8');
              $titulo = htmlspecialchars($row["titulo"], ENT_QUOTES, 'UTF-8');
              $descripcion = htmlspecialchars($row["descripcion"], ENT_QUOTES, 'UTF-8');
              $precio = htmlspecialchars($row["precio"], ENT_QUOTES, 'UTF-8');
              $autor = htmlspecialchars($row["autor"], ENT_QUOTES, 'UTF-8');

              echo '<div class="col mb-4">'; 
              echo '<div class="card card-custom h-100">';
              echo '<img src="' . $imagenLibroRuta . '" class="card-img-top" alt="' . $titulo . '">';
              echo '<div class="card-body">';
              echo '<h5 class="card-title">' . $titulo . '</h5>';
              echo '<p class="card-text">Autor: ' . $autor . '</p>';
              echo '<p class="card-text">Descripción: ' . $descripcion . '</p>';
              echo '<p class="card-text">Precio: $' . $precio . '</p>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
            echo '</div>';
          } else {
            echo "<div class='col-12'><p>No se encontraron libros para este autor.</p></div>";
          }
        } else {
          // Mostrar autores si no hay id_autor en la URL
          echo '<h1 class="mb-4">Autores</h1>';
          echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';

          // Consulta para obtener los autores
          $sqlAutores = "SELECT id_autor, nombre, imagen FROM autor";
          $resultAutores = $mysqli->query($sqlAutores);

          if ($resultAutores->num_rows > 0) {
            while ($row = $resultAutores->fetch_assoc()) {
              $imagenRuta = htmlspecialchars($row['imagen'], ENT_QUOTES, 'UTF-8');
              $idAutor = htmlspecialchars($row["id_autor"], ENT_QUOTES, 'UTF-8');
              $nombreAutor = htmlspecialchars($row["nombre"], ENT_QUOTES, 'UTF-8');

              echo '<div class="col mb-4">';
              echo '<div class="card card-custom h-100">';
              echo '<img src="' . $imagenRuta . '" class="card-img-top" alt="' . $nombreAutor . '">';
              echo '<div class="card-body">';
              echo '<h5 class="card-title">' . $nombreAutor . '</h5>';
              echo '</div>';
              echo '<div class="card-footer">';
              echo '<a href="libros.php?id_autor=' . $idAutor . '&nombre_autor=' . urlencode($nombreAutor) . '" class="btn btn-info">Ver Libros</a>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          } else {
            echo "<div class='col-12'><p>No se encontraron autores.</p></div>";
          }
        }

        // Cerrar la conexión
        $mysqli->close();
        ?>
      </div>
    </section>
  </main>

  <footer class="footer-custom text-center text-lg-start mt-4">
    <div class="container-fluid p-4">
      <div class="row">
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
          <h5 class="text-uppercase">Contenido del Pie de Página</h5>
          <p>Aquí puedes usar filas y columnas para organizar el contenido del pie de página. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">images/cienaños</h5>
          <ul class="list-unstyled mb-0">
            <li><a href="#!" class="text-white">Enlace 1</a></li>
            <li><a href="#!" class="text-white">Enlace 2</a></li>
            <li><a href="#!" class="text-white">Enlace 3</a></li>
            <li><a href="#!" class="text-white">Enlace 4</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Enlaces</h5>
          <ul class="list-unstyled mb-0">
            <li><a href="#!" class="text-white">Enlace 1</a></li>
            <li><a href="#!" class="text-white">Enlace 2</a></li>
            <li><a href="#!" class="text-white">Enlace 3</a></li>
            <li><a href="#!" class="text-white">Enlace 4</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: #6c757d;">
      © 2023 Copyright:
      <a href="#" class="text-white">Siglo del Hombre</a>
    </div>
  </footer>
</body>

</html>