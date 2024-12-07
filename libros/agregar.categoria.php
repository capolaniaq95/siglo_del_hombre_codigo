<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Categoria</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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
                        <a class="nav-link text-white" href="libro.php">Libros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="autor.php">Autores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="categoria.php">Categorias Libro</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
        <main class="flex-fill">
            <div class="container mt-4">
                <h2>Agregar Categoria</h2>
                <?php
                require '../conexion.php';

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

					$categoria = $_REQUEST['categoria'];
    
                    $match_correo = '/\d/';
                    if (preg_match($match_correo, $categoria)) {
                        echo "<script> alert('Categoria agregada con caracteres incorrectos, no pueden usarse numeros, ni caracteres especiales.');window.location='agregar.categoria.php' </script>";
                        exit();
                    }

                    $imagen = $_FILES['imagen'];
                    $directorio = __DIR__ . '../images/';
                
                    $rutaImagen = $directorio . basename($imagen['name']);
                    
                    if (file_exists($rutaImagen)) {
                        echo "<script> alert('Imagen ya existe debe renombrarla');window.location='login.php' </script>";
                    } else {
                        if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
                            echo "<div class='alert alert-success'>Imagen subida correctamente.</div>";
                        } else {
                            echo "<div class='alert alert-danger'> problema al cargar imagen.</div>";
                        }
                    }
                    $imagen = 'images/' . basename($imagen['name']);

                    $sql = "INSERT INTO `categoria`(`categoria`, `imagen`) VALUES ('$categoria', '$imagen')";
                    if ($mysqli->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Categoria agregado correctamente.</div>";
                        echo "<a href='categoria.php' class='btn btn-primary'>Volver a la lista de Categoria</a>";
                        $mysqli->close();
                        exit;
                    } else {
                        echo "<div class='alert alert-danger'>Error al agregar el Categoria: " . $mysqli->error . "</div>";
                    }
                }
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="ubicacion">Nombre de la Categoria</label>
                        <input type="text" class="form-control" id="ubicacion" name="categoria" required>
                    </div>
                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" required>
                    </div>
                    <div class="form-group d-flex">
                        <button type="submit" class="btn btn-info mr-2">Agregar Categoria</button>
                        <a href="ubicacion.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </main>

        <footer class="bg-dark text-white py-3 mt-auto">
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy5Yk4pKjmb6/8tJTxXKoO4YHh5tFO4kD2Jg2w2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-rbsA7j6Fn5vK6e1jlg00uYFnbAM4A2E3xOSKq6xE7cqp9SZO+L/5Q/XfAkG4P1tn" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jG7s3e3SddU6zLZnCTunZ2a6D4iwHeL6vU2f9mB79mKwwm4eD" crossorigin="anonymous"></script>
</body>

</html>