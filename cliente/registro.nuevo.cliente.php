<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .registro-caja {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            border: 2px solid #0EAAD2;
            margin-top: 50px;
        }

        .registro-caja h2 {
            color: #0EADD2;
            text-align: center;
            margin-bottom: 30px;
        }



        .btn-registrar {
            background-color: #0EADD2;
            border-color: #0EADD2;
            color: #fff;
        }

        .btn-registrar:hover {
            background-color: #0EADD2;
            border-color: #0EADD2;
            color: #fff;
        }

        .btn-registrar:focus {
            box-shadow: none;
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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php

                require '../conexion.php';

                $mensaje = '';

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $correo = $_POST['correo'];

                    $match_correo = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
                    if (!preg_match($match_correo, $correo)) {
                        echo "<script> alert('Correo electrónico incorrecto.');window.location='registro.php' </script>";
                        exit();
                    }

                    $direccion = $_POST['direccion'];
                    $nombre = $_POST['nombre'];

                    $match_correo = '/\d/';
                    if (preg_match($match_correo, $nombre)) {
                        echo "<script> alert('Nombre agregado con caracteres incorrectos, no pueden usarse numeros, ni caracteres especiales.');window.location='registro.php' </script>";
                        exit();
                    }

                    $celular = $_POST['celular'];

                    $match_celular = '/^3\d{9}$/';
                    if (!preg_match($match_celular, $celular)) {
                        echo "<script> alert('Número de celular incorrecto. Debe comenzar con 3 y tener 10 dígitos.');window.location='registro.php' </script>";
                        exit();
                    }

                    $password = $_POST['password'];

                    $id_tipo = 2;

                    $sql = "INSERT INTO usuario (correo, direccion, nombre, celular, password, rol, id_tipo)
						VALUES ('$correo', '$direccion', '$nombre', '$celular', '$password', $id_tipo, $id_tipo)";

                    if ($mysqli->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Usuario agregado correctamente.</div>";
                        echo "<a href='../login.php' class='btn btn-primary'>Ingresar</a>";
                        exit();
                    } else {
                        echo "Error al guardar el usuario: " . $mysqli->error;
                    }

                    $mysqli->close();
                }
                ?>

            </div>
        </div>
    </div>
</body>