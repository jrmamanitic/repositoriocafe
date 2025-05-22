<?php
session_start();
include "../conexion.php";

$alert = "";

if (!empty($_POST)) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass = $_POST['pass'];

    if (empty($nombre) || empty($correo) || empty($pass)) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Todos los campos son obligatorios.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
    } else {
        $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo' AND estado = 1");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        El correo ya existe.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO usuarios (nombre, correo, pass, rol) VALUES ('$nombre', '$correo', '$pass', 5)");
            if ($query_insert) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Usuario registrado exitosamente.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Error al registrar el usuario.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">

  <!-- Estilos personalizados -->
  <style>
    body {
      background-image: url('../assets/img/cafei.gif');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: 'times new roman', sans-serif;
      font-size: 15px;
    }

    .register-box {
      background: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 10px;
      animation: fadeIn 1s ease-out;
      opacity: 0;
      animation-fill-mode: forwards;
    }

    .register-box .input-group {
      animation: fadeInUp 1s ease-out;
      opacity: 0;
      animation-fill-mode: forwards;
    }

    .register-box .btn {
      animation: fadeInUp 1.2s ease-out;
      opacity: 0;
      animation-fill-mode: forwards;
    }

    .alert {
      animation: fadeInAlert 1s ease-out;
      opacity: 0;
      animation-fill-mode: forwards;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInAlert {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }
  </style>
  
</head>
<body class="hold-transition login-page">
<div class="register-box">
  <div class="login-logo">
    <a href="#"><b>REGISTRARSE</b></a>
  </div>

  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Crea una cuenta para comenzar</p>
      <?php echo isset($alert) ? $alert : ''; ?>
      <form action="" method="post" autocomplete="off">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="nombre" placeholder="Nombre completo" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="correo" placeholder="Correo Electrónico" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" class="form-control" name="pass" id="password" placeholder="Contraseña" required>
            <div class="input-group-append">
                <button type="button" id="togglePassword" class="input-group-text">
                    <span class="fas fa-eye" id="eyeIcon"></span>
                </button>
            </div>
        </div>

        <div class="row">
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
          </div>
          <div class="col-6">
            <a href="../index.php" class="btn btn-secondary btn-block">Iniciar sesión</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
        // Alternar entre mostrar y ocultar la contraseña
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Cambiar el icono de ojo
        this.querySelector('span').classList.toggle('fa-eye');
        this.querySelector('span').classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>
