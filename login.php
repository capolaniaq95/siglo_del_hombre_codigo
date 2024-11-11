<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tienda Online de Libros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
                height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border: 1px solid #17a2b8; /* Se añade borde negro */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            color: black;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-control:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 5px rgba(23, 162, 184, 0.8);
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
    </style>
</head>

<body>
    
    <div class="login-container">
        <h2 class="text-dark">Iniciar Sesión</h2>
        <form action="ingreso.php" method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>
            <fieldset class="form-group">
                <legend class="col-form-label pt-0">Tipo de Usuario</legend>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="rol" id="gridRadios1" value="Administrador" checked>
                    <label class="form-check-label" for="gridRadios1">
                        Administrador
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="rol" id="gridRadios2" value="Cliente">
                    <label class="form-check-label" for="gridRadios2">
                        Cliente
                    </label>
                </div>
            </fieldset>

            <button type="submit" class="btn btn-info btn-block">Iniciar Sesión</button>
            <div class="text-center mt-2">
                <a href="/cliente/registro.php" class="text-info">¿No tienes una cuenta? Regístrate</a>
            </div>
            <div class="text-center mt-3">
                <a href="logout.php" class="text-info">Logout</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>

</html>
