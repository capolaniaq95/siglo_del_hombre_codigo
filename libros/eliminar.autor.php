<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar autor</title>
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

        <div class="container mt-4">
            <h2>Eliminar autor</h2>
            <?php

            require "../conexion.php";

            if (isset($_GET['id'])) {
                $id_autor = intval($_GET['id']);

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $sql = "DELETE FROM autor WHERE id_autor='$id_autor'";
                    if ($mysqli->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Autor eliminado correctamente.</div>";
                        echo "<a href='autor.php' class='btn btn-primary'>Volver a la lista de autores</a>";
                    } else {
                        echo "<div class='alert alert-danger'>Error al eliminar el autor: " . $mysqli->error . "</div>";
                    }
                    $mysqli->close();
                    exit;
                } else {
                    $sql = "SELECT nombre FROM autor WHERE id_autor = '$id_autor'";
                    $result = $mysqli->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $autor = $result->fetch_assoc();
                        $result->free();
                    } else {
                        echo "<div class='alert alert-danger'>autor no encontrado.</div>";
                        $mysqli->close();
                        exit;
                    }
                }
            } else {
                echo "<div class='alert alert-danger'>ID de autor no proporcionado.</div>";
                $mysqli->close();
                exit;
            }
            ?>

            <form action="" method="post">
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong> ¿Estás seguro de que deseas eliminar la autor? "<?php echo htmlspecialchars($autor['nombre']); ?>"? Esta acción no se puede deshacer.
                </div>
                <button type="submit" class="btn btn-success">Eliminar autor</button>
                <a href="autor.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy5Yk4pKjmb6/8tJTxXKoO4YHh5tFO4kD2Jg2w2" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-rbsA7j6Fn5vK6e1jlg00uYFnbAM4A2E3xOSKq6xE7cqp9SZO+L/5Q/XfAkG4P1tn" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jG7s3e3SddU6zLZnCTunZ2a6D4iwHeL6vU2f9mB79mKwwm4eD" crossorigin="anonymous"></script>
</body>

</html>