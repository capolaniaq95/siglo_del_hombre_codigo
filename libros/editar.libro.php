<?php
require "../conexion.php";

$categoria_resultado = $mysqli->query("SELECT id_categoria, categoria FROM categoria");
if (!$categoria_resultado) {
    echo "Error al obtener categorías: " . $mysqli->error;
    exit();
}

$autor_resultado = $mysqli->query("SELECT id_autor, nombre FROM autor");
if (!$autor_resultado) {
    echo "Error al obtener autores: " . $mysqli->error;
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_libro = $_POST["id_libro"];
    $categoria = $_POST["categoria"];
    $autor = $_POST["autor"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha_publicacion = $_POST["fecha_publicacion"];
    $editorial = $_POST["editorial"];
    $precio = $_POST["precio"];
    $imagen = $_POST["imagen"];

    $sql = "UPDATE libro 
            SET id_categoria='$categoria', id_autor='$autor', titulo='$titulo', descripcion='$descripcion', 
            editorial='$editorial', precio='$precio', imagen='$imagen' 
            WHERE id_libro='$id_libro'";
    if ($mysqli->query($sql) === TRUE) {
        echo '<script>alert("Libro actualizado exitosamente.");</script>';
        echo '<script>window.location.href = "libro.php";</script>';
        exit();
    } else {
        echo "Error al actualizar el libro: " . $mysqli->error;
    }
}


$libro = null;
if (isset($_GET["id"])) {
    $id_libro = $_GET["id"];
    $libro_resultado = $mysqli->query("SELECT * FROM libro WHERE id_libro='$id_libro'");
    if ($libro_resultado) {
        $libro = $libro_resultado->fetch_assoc();
    } else {
        echo "Error al obtener información del libro: " . $mysqli->error;
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Editar Libro</title>
    <style>
        .custom-form-container {
            border: 1px solid #0EADD2;
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

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="text-center mb-4" style="color: #0EADD2;">Editar Libro</h2>
                <div class="custom-form-container">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_libro" value="<?php echo $libro['id_libro']; ?>">
                        <input type="hidden" name="imagen_actual" value="<?php echo $libro['imagen']; ?>">
                        <div class="form-group">
                            <label for="categoria">Categoría</label>
                            <select class="form-control" id="categoria" name="categoria" required>
                                <?php while ($categoria = $categoria_resultado->fetch_assoc()) : ?>
                                    <option value="<?php echo $categoria['id_categoria']; ?>" <?php if ($categoria['id_categoria'] == $libro['id_categoria']) echo 'selected'; ?>><?php echo $categoria['categoria']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="autor">Autor</label>
                            <select class="form-control" id="autor" name="autor" required>
                                <?php while ($autor = $autor_resultado->fetch_assoc()) : ?>
                                    <option value="<?php echo $autor['id_autor']; ?>" <?php if ($autor['id_autor'] == $libro['id_autor']) echo 'selected'; ?>><?php echo $autor['nombre']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="titulo">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $libro['titulo']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $libro['descripcion']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editorial">Editorial</label>
                            <input type="text" class="form-control" id="editorial" name="editorial" value="<?php echo $libro['editorial']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $libro['precio']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <input type="text" class="form-control-file" id="imagen" name="imagen" value="<?php echo $libro['imagen']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>