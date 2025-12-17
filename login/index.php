<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de ventas - Login</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icheck-bootstrap@3.0.1/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Libreria Sweetallert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #224abe;
            --accent-color: #36b9cc;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 400px;
            animation: fadeIn 0.8s ease;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        .logo-container {
            padding: 20px 0;
            width: 200px;
            margin: auto;
        }

        .login-logo {
            font-size: 28px;
            font-weight: bold;

        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .input-group-text {
            background-color: #f8f9fa;
        }

        .spinner-border {
            width: 1.2rem;
            height: 1.2rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: white;
            font-size: 14px;
        }
    </style>
</head>

<body class="hold-transition">
    <div class="login-box">
        <div class="logo-container">
            <center>
                <img src="../imagenes/the_star_software.png" alt="Logo Star Software" class="img-fluid">
            </center>
        </div>

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h2 class="login-box-msg"><b>Sistema de</b> VENTAS</h2>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Ingrese sus datos para iniciar sesión</p>

                <form id="loginForm" action="../api/login/login.php" method="POST">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_user" class="form-control" placeholder="Contraseña" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" id="loginButton">
                                <span id="buttonText">Ingresar</span>
                                <span id="buttonSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-1">
                        <a href="#">¿Olvidaste tu contraseña?</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="login-footer">
            <p>&copy; 2023 Star Software - Todos los derechos reservados</p>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Mostrar spinner
            document.getElementById('buttonText').style.display = 'none';
            document.getElementById('buttonSpinner').style.display = 'inline-block';
            document.getElementById('loginButton').disabled = true;

            const formData = new FormData(this);

            fetch('../api/login/login.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Respuesta API:", data); // <-- Debug en consola

                    if (data.status === 'success') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: '¡Login exitoso!',
                            showConfirmButton: false,
                            timer: 1500,
                            didClose: () => {
                                // Redirección correcta usando la URL que envía el backend
                                window.location.href = data.redirect_url;
                                console.log(data.redirect_url);
                            }
                        });
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                    // Restaurar botón
                    document.getElementById('buttonText').style.display = 'inline-block';
                    document.getElementById('buttonSpinner').style.display = 'none';
                    document.getElementById('loginButton').disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Ocurrió un error inesperado.',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Restaurar botón
                    document.getElementById('buttonText').style.display = 'inline-block';
                    document.getElementById('buttonSpinner').style.display = 'none';
                    document.getElementById('loginButton').disabled = false;
                });
        });
    </script>
</body>

</html>