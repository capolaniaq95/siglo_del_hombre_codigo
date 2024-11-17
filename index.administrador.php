<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        .img-container {
            position: relative;
            width: 100%;
            height: 100px;
            overflow: hidden;
        }

        .img-container img {
            width: 100px;
            /* Ajusta el tamaño de la imagen a un tamaño pequeño */
            height: auto;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }

        .portfolio-item {
            text-align: center;
        }

        .portfolio-item-caption i {
            font-size: 2.5rem;
            /* Tamaño más pequeño para los íconos */
        }

        .portfolio h2,
        .portfolio h2 {
            font-size: 2.0rem;
            /* Tamaño más pequeño para los encabezados */
        }

        .portfolio .card {
            padding: 5px;
            border: none;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-column min-vh-100">
        <header>
            <nav class="navbar navbar-expand-lg navbar-primary bg-info">
                <div class="container-fluid">
                    <a class="navbar-brand px-2 text-white" href="index.administrador.php">Siglo del Hombre</a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main class="mb-5 mt-3 flex-fill">
            <section id="portfolio" class="portfolio">
                <div class="container">
                    <h2 class="text-uppercase text-center text-secondary">Administrador</h4>
                        <hr class="star-dark mb-5">
                        <div class="row">

                            <div class="col-md-6 col-lg-4">
                                <a class="d-block portfolio-item card" data-toggle="modal" href="/pedidos/pedido.php">
                                    <h4 class="text-center text-secondary">Pedidos</h4>
                                    <div class="portfolio-item-caption text-center">
                                        <i class="fa fa-search-plus"></i>
                                    </div>
                                    <div class="img-container">
                                        <img class="img-fluid" src="/images/icono_pedidos.png" alt="Pedidos">
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <a class="d-block portfolio-item card" data-toggle="modal" href="/libros/libro.php">
                                    <h4 class="text-center text-secondary">Libros</h4>
                                    <div class="portfolio-item-caption text-center">
                                        <i class="fa fa-search-plus"></i>
                                    </div>
                                    <div class="img-container">
                                        <img class="img-fluid" src="/images/iconos_libros.jpeg" alt="Productos">
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <a class="d-block portfolio-item card" data-toggle="modal" href="/inventario/inventario.php">
                                    <h4 class="text-center text-secondary">Inventario</h4>
                                    <div class="portfolio-item-caption text-center">
                                        <i class="fa fa-search-plus"></i>
                                    </div>
                                    <div class="img-container">
                                        <img class="img-fluid" src="/images/icono_inventario.jpeg" alt="Pedidos">
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <a class="d-block portfolio-item card" data-toggle="modal" href="/usuarios/usuario.php">
                                    <h4 class="text-center text-secondary">Usuarios</h4>
                                    <div class="portfolio-item-caption text-center">
                                        <i class="fa fa-search-plus"></i>
                                    </div>
                                    <div class="img-container">
                                        <img class="img-fluid" src="/images/icono_usuario.png" alt="Usuarios">
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <a class="d-block portfolio-item card" data-toggle="modal" href="index.php">
                                    <h4 class="text-center text-secondary">Sitio Web</h4>
                                    <div class="portfolio-item-caption text-center">
                                        <i class="fa fa-search-plus"></i>
                                    </div>
                                    <div class="img-container">
                                        <img class="img-fluid" src="/images/icono_sitio_web.png" alt="Sitio Web">
                                    </div>
                                </a>
                            </div>

                        </div>
                </div>
            </section>
        </main>
    </div>

    <footer class="bg-dark text-white mt-auto py-3">
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy5Yk4pKjmb6/8tJTxXKoO4YHh5tFO4kD2Jg2w2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-rbsA7j6Fn5vK6e1jlg00uYFnbAM4A2E3xOSKq6xE7cqp9SZO+L/5Q/XfAkG4P1tn" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jG7s3e3SddU6zLZnCTunZ2a6D4iwHeL6vU2f9mB79mKwwm4eD" crossorigin="anonymous"></script>
</body>

</html>