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

        .nav-item:hover .dropdown-menu-custom {
            display: block;
        }
    </style>
</head>

<body>
<header>
            <nav class="navbar navbar-expand-lg navbar-primary bg-info">
                <div class="container-fluid">
                    <a class="navbar-brand px-2 text-white" href="../index.administrador.php">Siglo del Hombre</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="usuario.php" id="navbarDropdown" role="button">
                                    Usuarios
                                </a>
                                <div class="dropdown-menu-custom" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/usuarios/cliente.php">Clientes</a>
                                    <a class="dropdown-item" href="/usuarios/administrador.php">Administradores</a>
                                </div>
                            </li>
                        </ul>
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
                        echo "<script> alert('Correo electrónico incorrecto.');window.location='agregar.usuario.php' </script>";
                        exit();
                    }

                    $direccion = $_POST['direccion'];
                    $nombre = $_POST['nombre'];

                    $match_correo = '/\d/';
                    if (preg_match($match_correo, $nombre)) {
                        echo "<script> alert('Nombre agregado con caracteres incorrectos, no pueden usarse numeros ni caracteres especiales.');window.location='agregar.usuario.php' </script>";
                        exit();
                    }

                    $celular = $_POST['celular'];

                    $match_celular = '/^3\d{9}$/';
                    if (!preg_match($match_celular, $celular)) {
                        echo "<script> alert('Número de celular incorrecto. Debe comenzar con 3 y tener 10 dígitos.');window.location='agregar.usuario.php' </script>";
                        exit();
                    }

                    $password = $_POST['password'];
                    $id_tipo = $_POST['id_tipo'];

                    if ($id_tipo == 'Administrador') {
                        $id_tipo = 1;
                    } else {
                        $id_tipo = 2;
                    }


                    $sql = "INSERT INTO usuario (correo, direccion, nombre, celular, password, rol, id_tipo)
						VALUES ('$correo', '$direccion', '$nombre', '$celular', '$password', $id_tipo, $id_tipo)";

                    if ($mysqli->query($sql) === TRUE) {
                        echo "<div class='alert alert-success'>Usuario agregado correctamente.</div>";
                        echo "<a href='usuario.php' class='btn btn-primary'>Volver a la lista de usuario</a>";
                        exit();
                    } else {
                        echo "Error al guardar el usuario: " . $mysqli->error;
                    }

                    $mysqli->close();
                }
                ?>
                <div class="registro-caja">

                    <h2 class="mt-4">Registro de Usuario</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Celular</label>
                            <input type="text" class="form-control" id="password" name="celular" required>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol:</label>
                            <select class="form-control" id="rol" name="id_tipo" required>
                                <option value="Administrador">Administrador</option>
                                <option value="Cliente">Cliente</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-registrar btn-block mt-3">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>