<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require "conexion.php";
require __DIR__ . '/vendor/autoload.php';

/*
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP para Outlook
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.office365.com';  // Servidor SMTP de Outlook (Office 365)
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'carlos_apolania@soy.sena.edu.co'; // Tu dirección de correo Outlook
    $mail->Password   = 'cA82882828';  // Tu contraseña de correo Outlook
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
    $mail->Port       = 587;  // Puerto SMTP de Outlook

    // Remitente y destinatario
    $mail->setFrom('carlos_apolania@soy.sena.edu.co', 'Carlos Polania');
    $mail->addAddress('carlospolaniaq@gmail.com', 'Carlitos');     // Añadir destinatario

    // Contenido del correo
    $mail->isHTML(true);                                  // Establecer el formato del correo en HTML
    $mail->Subject = 'Prueba de envío de correo';
    $mail->Body    = 'Este es un correo de prueba <b>usando PHPMailer</b> con Outlook.';
    $mail->AltBody = 'Este es el contenido en texto plano para clientes de correo que no soportan HTML';

    // Enviar el correo
    $mail->send();
    echo 'El correo ha sido enviado';
} catch (Exception $e) {
    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
}

*/

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
        ORDER BY l.id_libro DESC 
        LIMIT 4"; // Ajusta el LIMIT según necesites

$result = $mysqli->query($sql);


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio - Siglo del Hombre</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    .novedades {
      color: black; /* Color azul claro */
      font-size: 2.5rem;
      font-weight: bold;
      margin: 20px 0;
    }
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
      <a class="navbar-brand px-2 text-white" href="index.php">Siglo del Hombre</a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link text-white" href="/cliente/libros.php">Libros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/cliente/autores.php">Autores</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/cliente/categorias.php">Categorías</a>
          </li>

          <?php
          session_start();
          if (isset($_SESSION["id_usuario"])): ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="/cliente/mis.pedidos.php">Mis Pedidos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="/cliente/mis.devolucion.php">Mis Devoluciones</a>
            </li>
            <?php
            if ($_SESSION["id_tipo"] == 1): ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="index.administrador.php">Administrador</a>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="logout.php">Logout</a>
            </li>
            <?php if (isset($_SESSION['carrito'])): ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="/cliente/carrito.php">
                  <i class="fas fa-shopping-cart"></i>
                </a>
              </li>
            <?php endif; ?>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link text-white" href="login.php">Ingresar</a>
            </li>
          <?php endif; ?>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="POST" action="/cliente/libros.php">
          <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" name="search">
          <button class="btn btn-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
      </div>
    </div>
  </nav>
</header>


  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="./images/8e5da8bd-5e14-6139-f8a9-663145076970_imagen_web.png" alt="First slide" style="max-height: 25rem;">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="./images/f0c09a4e-776e-9a8d-3c7f-6659fa0bb5e4_imagen_web.jpg" alt="Second slide" style="max-height: 25rem;">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="./images/9c0c1f52-8572-bca2-9b05-66d5f6d27dab_imagen_web.png" alt="Second slide" style="max-height: 25rem;">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="./images/3561b930-6b9f-4026-0c3f-66d233fb91d9_imagen_web.png" alt="Second slide" style="max-height: 25rem;">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="./images/45229dde-26c1-b3f2-3e93-66d239872f29_imagen_web.jpg" alt="Second slide" style="max-height: 25rem;">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="./images/b6eaf9b0-c9df-6d12-2076-66e30ee89a31_imagen_web.jpg" alt="Second slide" style="max-height: 25rem;">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <section>
    <div class="container">
      <div class="novedades ">Novedades</div>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
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
              echo '<form method="post" action="/cliente/agregar.carrito.php">';
              echo '<input type="hidden" name="id_libro" value="' . $idLibro . '">';
              echo '<button type="submit" class="btn" style="background-color: #17a2b8; color: white;">Agregar al Carrito</button>';
              echo '</form>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
          
          } ?>
      </div>
    </div>
  </section>

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
          <form method="post" action="/cliente/agregar.carrito.php">
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
          <h5 class="text-uppercase text-white">Footer Content</h5>
          <p class="text-white">Aquí puedes usar filas y columnas para organizar el contenido del pie de página. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
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
