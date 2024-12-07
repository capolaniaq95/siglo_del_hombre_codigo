<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Ingresar Libro</title>
    <style>
        .custom-form-container {
            border: 1px solid #black;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
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
            <h2>Agregar Libro</h2>
            <?php

            require '../conexion.php';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $categoria = intval($_REQUEST['categoria']);
                $autor = intval($_REQUEST['autor']);
                $titulo = $_REQUEST['titulo'];
                $descripcion = $_REQUEST['descripcion'];
                $editorial = $_REQUEST['editorial'];
                $precio = intval($_REQUEST['precio']);
                $imagen = $_FILES['imagen'];

                $directorio = __DIR__ . '../images/';

                if (!is_dir($directorio)) { 
                    mkdir($directorio, 0755, true);
                }
                
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


                $sql = "INSERT INTO `libro`(`titulo`, `descripcion`, `editorial`, `imagen`, `precio`, `estado`, `id_categoria`, `id_autor`)
						 		VALUES ('$titulo','$descripcion','$editorial','$imagen', $precio, 'No Disponible', $categoria, $autor)";
                if ($mysqli->query($sql) === TRUE) {
                    echo "<div class='alert alert-success'>libro agregado correctamente.</div>";
                    echo "<a href='/libros/libro.php' class='btn btn-primary'>Volver a la lista de libros</a>";
                    $mysqli->close();
                    exit;
                } else {
                    echo "<div class='alert alert-danger'>Error al agregar el Libro " . $mysqli->error . "</div>";
                }
            }
            ?>
</body>

</html>