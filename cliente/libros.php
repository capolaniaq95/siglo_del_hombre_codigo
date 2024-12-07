<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Libros</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    .card-custom {
      border: 1px solid #dee2e6;
      border-radius: 0.5rem;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      transition: transform 0.2s;
      cursor: pointer;
      /* Cursor pointer para indicar que es clickeable */
    }

    .card-custom:hover {
      transform: scale(1.05);
    }

    .card-img-top {
      height: 25rem;
      object-fit: cover;
    }

    .card-body {
      padding: 1.5rem;
    }

    .card-footer {
      background-color: #f8f9fa;
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


  <section>
    <div class="container" style="padding: 30px;">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
        
        require "../conexion.php";
        
        if (isset($_GET['id_categoria'])){

          $id_categoria = intval($_GET['id_categoria']);

          $sql = "SELECT 
          l.id_libro, 
          l.titulo, 
          l.descripcion,  
          l.precio, 
          l.imagen, 
          a.nombre AS autor, 
          c.categoria AS genero
          FROM libro l
          JOIN autor a ON l.id_autor = a.id_autor
          JOIN categoria c ON l.id_categoria = c.id_categoria
          WHERE l.id_categoria=$id_categoria";

          $result = $mysqli->query($sql);

          if ($result === false) {
          die('Error en la consulta: ' . $mysqli->error);
          }

          if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $imagenRuta = $row['imagen'];
            $idLibro = htmlspecialchars($row["id_libro"], ENT_QUOTES, 'UTF-8');
            $titulo = htmlspecialchars($row["titulo"], ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($row["descripcion"], ENT_QUOTES, 'UTF-8');
            $autor = htmlspecialchars($row["autor"], ENT_QUOTES, 'UTF-8');
            $genero = htmlspecialchars($row["genero"], ENT_QUOTES, 'UTF-8');
            $precio = htmlspecialchars($row["precio"], ENT_QUOTES, 'UTF-8');

            echo '<div class="col">';
            echo '<div class="card card-custom h-100" data-toggle="modal" data-target="#bookModal" data-id="' . $idLibro . '" data-title="' . $titulo . '" data-description="' . $descripcion . '" data-author="' . $autor . '" data-genre="' . $genero . '" data-price="' . $precio . '" data-image="' . $imagenRuta . '">';
            echo '<img src="' . $imagenRuta . '" class="card-img-top" alt="' . $titulo . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $titulo . '</h5>';
            echo '<p class="card-text"><strong>Descripción: </strong>' . $descripcion . '</p>';
            echo '<p class="card-text"><strong>Autor: </strong>' . $autor . '</p>';
            echo '<p class="card-text"><strong>Género: </strong>' . $genero . '</p>';
            echo '<p class="card-text"><strong>Precio: </strong>$' . $precio . '</p>';
            echo '</div>';
            echo '<div class="card-footer">';
            if (isset($_SESSION["id_usuario"])) {
              echo '<form method="post" action="agregar.carrito.php">';
              echo '<input type="hidden" name="id_libro" value="' . $idLibro . '">';
              echo '<button type="submit" class="btn" style="background-color: #17a2b8; color: white;">Agregar al Carrito</button>';
              echo '</form>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          } else {

            echo "<div class='alert alert-danger'>No se encontraron libros para la Categoria</div>";
            // echo "<a href='categorias.php' class='btn btn-primary'>Atras</a>";
            $mysqli->close();
            exit;
          }
        }else if (isset($_GET['id_autor'])){

          $id_autor = intval($_GET['id_autor']);

          $sql = "SELECT 
          l.id_libro, 
          l.titulo, 
          l.descripcion,  
          l.precio, 
          l.imagen, 
          a.nombre AS autor, 
          c.categoria AS genero
          FROM libro l
          JOIN autor a ON l.id_autor = a.id_autor
          JOIN categoria c ON l.id_categoria = c.id_categoria
          WHERE l.id_autor=$id_autor";

          $result = $mysqli->query($sql);

          if ($result === false) {
          die('Error en la consulta: ' . $mysqli->error);
          }

          if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $imagenRuta = $row['imagen'];
            $idLibro = htmlspecialchars($row["id_libro"], ENT_QUOTES, 'UTF-8');
            $titulo = htmlspecialchars($row["titulo"], ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($row["descripcion"], ENT_QUOTES, 'UTF-8');
            $autor = htmlspecialchars($row["autor"], ENT_QUOTES, 'UTF-8');
            $genero = htmlspecialchars($row["genero"], ENT_QUOTES, 'UTF-8');
            $precio = htmlspecialchars($row["precio"], ENT_QUOTES, 'UTF-8');

            echo '<div class="col">';
            echo '<div class="card card-custom h-100" data-toggle="modal" data-target="#bookModal" data-id="' . $idLibro . '" data-title="' . $titulo . '" data-description="' . $descripcion . '" data-author="' . $autor . '" data-genre="' . $genero . '" data-price="' . $precio . '" data-image="' . $imagenRuta . '">';
            echo '<img src="' . $imagenRuta . '" class="card-img-top" alt="' . $titulo . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $titulo . '</h5>';
            echo '<p class="card-text"><strong>Descripción: </strong>' . $descripcion . '</p>';
            echo '<p class="card-text"><strong>Autor: </strong>' . $autor . '</p>';
            echo '<p class="card-text"><strong>Género: </strong>' . $genero . '</p>';
            echo '<p class="card-text"><strong>Precio: </strong>$' . $precio . '</p>';
            echo '</div>';
            echo '<div class="card-footer">';
            if (isset($_SESSION["id_usuario"])) {
              echo '<form method="post" action="agregar.carrito.php">';
              echo '<input type="hidden" name="id_libro" value="' . $idLibro . '">';
              echo '<button type="submit" class="btn" style="background-color: #17a2b8; color: white;">Agregar al Carrito</button>';
              echo '</form>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          } else {

            echo "<div class='alert alert-danger'>No se encontraron libros para este autor</div>";
            // echo "<a href='categorias.php' class='btn btn-primary'>Atras</a>";
            $mysqli->close();
            exit;
          }
        } else if ($_POST){

          $search = $_POST['search'];

          $sql = "SELECT l.id_libro, l.titulo, l.descripcion, l.precio, l.imagen, a.nombre AS autor, c.categoria AS genero 
                  FROM libro l 
                  JOIN autor a ON l.id_autor = a.id_autor 
                  JOIN categoria c ON l.id_categoria = c.id_categoria 
                  WHERE l.titulo LIKE '%$search%' 
                    OR a.nombre LIKE '%$search%' 
                    OR c.categoria LIKE '%$search%'";
          $result = $mysqli->query($sql);

          if ($result === false) {
          die('Error en la consulta: ' . $mysqli->error);
          }

          if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $imagenRuta = $row['imagen'];
            $idLibro = htmlspecialchars($row["id_libro"], ENT_QUOTES, 'UTF-8');
            $titulo = htmlspecialchars($row["titulo"], ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($row["descripcion"], ENT_QUOTES, 'UTF-8');
            $autor = htmlspecialchars($row["autor"], ENT_QUOTES, 'UTF-8');
            $genero = htmlspecialchars($row["genero"], ENT_QUOTES, 'UTF-8');
            $precio = htmlspecialchars($row["precio"], ENT_QUOTES, 'UTF-8');

            echo '<div class="col">';
            echo '<div class="card card-custom h-100" data-toggle="modal" data-target="#bookModal" data-id="' . $idLibro . '" data-title="' . $titulo . '" data-description="' . $descripcion . '" data-author="' . $autor . '" data-genre="' . $genero . '" data-price="' . $precio . '" data-image="' . $imagenRuta . '">';
            echo '<img src="' . $imagenRuta . '" class="card-img-top" alt="' . $titulo . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $titulo . '</h5>';
            echo '<p class="card-text"><strong>Descripción: </strong>' . $descripcion . '</p>';
            echo '<p class="card-text"><strong>Autor: </strong>' . $autor . '</p>';
            echo '<p class="card-text"><strong>Género: </strong>' . $genero . '</p>';
            echo '<p class="card-text"><strong>Precio: </strong>$' . $precio . '</p>';
            echo '</div>';
            echo '<div class="card-footer">';
            if (isset($_SESSION["id_usuario"])) {
              echo '<form method="post" action="agregar.carrito.php">';
              echo '<input type="hidden" name="id_libro" value="' . $idLibro . '">';
              echo '<button type="submit" class="btn" style="background-color: #17a2b8; color: white;">Agregar al Carrito</button>';
              echo '</form>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          } else {

            echo "<div class='alert alert-danger'>No se encontraron libros para este autor</div>";
            // echo "<a href='categorias.php' class='btn btn-primary'>Atras</a>";
            $mysqli->close();
            exit;
          }



        }
        else{

          $sql = "SELECT 
          l.id_libro, 
          l.titulo, 
          l.descripcion,  
          l.precio, 
          l.imagen, 
          a.nombre AS autor, 
          c.categoria AS genero
          FROM libro l
          JOIN autor a ON l.id_autor = a.id_autor
          JOIN categoria c ON l.id_categoria = c.id_categoria";

          $result = $mysqli->query($sql);

          if ($result === false) {
          die('Error en la consulta: ' . $mysqli->error);
          }

          if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $imagenRuta = $row['imagen'];
            $idLibro = htmlspecialchars($row["id_libro"], ENT_QUOTES, 'UTF-8');
            $titulo = htmlspecialchars($row["titulo"], ENT_QUOTES, 'UTF-8');
            $descripcion = htmlspecialchars($row["descripcion"], ENT_QUOTES, 'UTF-8');
            $autor = htmlspecialchars($row["autor"], ENT_QUOTES, 'UTF-8');
            $genero = htmlspecialchars($row["genero"], ENT_QUOTES, 'UTF-8');
            $precio = htmlspecialchars($row["precio"], ENT_QUOTES, 'UTF-8');

            echo '<div class="col">';
            echo '<div class="card card-custom h-100" data-toggle="modal" data-target="#bookModal" data-id="' . $idLibro . '" data-title="' . $titulo . '" data-description="' . $descripcion . '" data-author="' . $autor . '" data-genre="' . $genero . '" data-price="' . $precio . '" data-image="' . $imagenRuta . '">';
            echo '<img src="' . $imagenRuta . '" class="card-img-top" alt="' . $titulo . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $titulo . '</h5>';
            echo '<p class="card-text"><strong>Descripción: </strong>' . $descripcion . '</p>';
            echo '<p class="card-text"><strong>Autor: </strong>' . $autor . '</p>';
            echo '<p class="card-text"><strong>Género: </strong>' . $genero . '</p>';
            echo '<p class="card-text"><strong>Precio: </strong>$' . $precio . '</p>';
            echo '</div>';
            echo '<div class="card-footer">';
            if (isset($_SESSION["id_usuario"])) {
              echo '<form method="post" action="agregar.carrito.php">';
              echo '<input type="hidden" name="id_libro" value="' . $idLibro . '">';
              echo '<button type="submit" class="btn" style="background-color: #17a2b8; color: white;">Agregar al Carrito</button>';
              echo '</form>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          } else {
          echo "<div class='col-12'><p>No se encontraron libros.</p></div>";
          }

        }


        $mysqli->close();
        ?>

      </div>
    </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bookModalLabel">Título del Libro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img src="" id="modalBookImage" class="img-fluid" alt="Imagen del libro">
          <p id="modalBookDescription"></p>
          <p><strong>Autor:</strong> <span id="modalBookAuthor"></span></p>
          <p><strong>Género:</strong> <span id="modalBookGenre"></span></p>
          <p><strong>Precio:</strong> $<span id="modalBookPrice"></span></p>
        </div>
        <div class="modal-footer">
        <?php if (isset($_SESSION["id_usuario"])) : ?>
          <form method="post" action="agregar.carrito.php">
            <input type="hidden" name="id_libro" id="modalBookId">
            <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
          </form>
        <?php endif ?>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <footer class="bg-light text-center text-lg-start mt-4">
    <div class="container-fluid p-4 bg-dark" style="background-color: #6c757d;">
      <div class="row">
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
          <h5 class="text-uppercase text-white">Contenido del Pie de Página</h5>
          <p class="text-white">Aquí puedes usar filas y columnas para organizar el contenido del pie de página. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase text-white">images/cienaños</h5>
          <ul class="list-unstyled mb-0">
            <li><a href="#!" class="text-white">Enlace 1</a></li>
            <li><a href="#!" class="text-white">Enlace 2</a></li>
            <li><a href="#!" class="text-white">Enlace 3</a></li>
            <li><a href="#!" class="text-white">Enlace 4</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase text-white">Enlaces</h5>
          <ul class="list-unstyled mb-0">
            <li><a href="#!" class="text-white">Enlace 1</a></li>
            <li><a href="#!" class="text-white">Enlace 2</a></li>
            <li><a href="#!" class="text-white">Enlace 3</a></li>
            <li><a href="#!" class="text-white">Enlace 4</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center p-3 text-white bg-dark" style="max-height: 3rem;">
      © 2023 Copyright:
      <a class="text-white" href="#">Siglo del Hombre</a>
    </div>
  </footer>

  <script>
    $('#bookModal').on('show.bs.modal', function(event) {
      var card = $(event.relatedTarget); // Botón que activó el modal
      var id = card.data('id');
      var title = card.data('title');
      var description = card.data('description');
      var author = card.data('author');
      var genre = card.data('genre');
      var price = card.data('price');
      var image = card.data('image');

      var modal = $(this);
      modal.find('.modal-title').text(title);
      modal.find('#modalBookDescription').text(description);
      modal.find('#modalBookAuthor').text(author);
      modal.find('#modalBookGenre').text(genre);
      modal.find('#modalBookPrice').text(price);
      modal.find('#modalBookImage').attr('src', image);
      modal.find('#modalBookId').val(id);
    });
  </script>
</body>

</html>