<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar metodo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        .dropdown-menu-custom {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-menu-custom a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-menu-custom a:hover {
            background-color: #17a2b8;
            color: white;
        }

        .page-item a:hover {
            background-color: #17a2b8;
            color: white;
        }

        .nav-item:hover .dropdown-menu-custom {
            display: block;
        }
        


        .table td, .table th {
            white-space: nowrap; 
        }

        .table-container {
            width: 1000px;
        }

        #filtro a:hover {
            background-color: #17a2b8;
            color: white;
        }
    </style>

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
                                <a class="nav-link text-white" href="pedido.php">Pedidos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="Metodo.pago.php">Metodo de Pago</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="../devolucion/devolucion.php" id="navbarDropdown" role="button">
                                    Devoluciones
                                </a>
                                <div class="dropdown-menu-custom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="../devolucion/proceso.php">Proceso</a>
                                    <a class="dropdown-item" href="../devolucion/aceptada.php">Aceptada</a>
                                    <a class="dropdown-item" href="../devolucion/rechazada.php">Rechazada</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container mt-4">
            <h2>Eliminar metodo</h2>
            <?php

            require "../conexion.php";

            if (isset($_GET['id'])) {
                $id_metodo = intval($_GET['id']);

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $sql = "DELETE FROM metodo_de_pago WHERE id_metodo_de_pago='$id_metodo'";
                    if ($mysqli->query($sql) === TRUE) {
                        echo "<div class='alert alert-info'>metodo eliminado correctamente.</div>";
                        echo "<a href='metodo.pago.php' class='btn btn-primary'>Volver a la lista de metodoes</a>";
                    } else {
                        echo "<div class='alert alert-danger'>Error al eliminar el metodo: " . $mysqli->error . "</div>";
                    }
                    $mysqli->close();
                    exit;
                } else {
                    $sql = "SELECT metodo FROM metodo_de_pago WHERE id_metodo_de_pago = '$id_metodo'";
                    $result = $mysqli->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $metodo = $result->fetch_assoc();
                        $result->free();
                    } else {
                        echo "<div class='alert alert-danger'>metodo no encontrado.</div>";
                        $mysqli->close();
                        exit;
                    }
                }
            } else {
                echo "<div class='alert alert-danger'>ID de metodo no proporcionado.</div>";
                $mysqli->close();
                exit;
            }
            ?>

            <form action="" method="post">
                <div class="alert alert-warning">
                    <strong>Advertencia:</strong> ¿Estás seguro de que deseas eliminar la metodo? "<?php echo $metodo['metodo']; ?>"? Esta acción no se puede deshacer.
                </div>
                <button type="submit" class="btn btn-info">Eliminar metodo</button>
                <a href="metodo.pago.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy5Yk4pKjmb6/8tJTxXKoO4YHh5tFO4kD2Jg2w2" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-rbsA7j6Fn5vK6e1jlg00uYFnbAM4A2E3xOSKq6xE7cqp9SZO+L/5Q/XfAkG4P1tn" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jG7s3e3SddU6zLZnCTunZ2a6D4iwHeL6vU2f9mB79mKwwm4eD" crossorigin="anonymous"></script>
</body>

</html>