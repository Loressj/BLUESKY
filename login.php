<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
      
      body{
        background: #f2f3fd;
        background: linear-gradient(to right, #565768, #e8eafa);
      }
      .bg{
        /*background-image: url('../../static/core/img/inevada.jpeg');*/
        background-position: center center;
      }
    </style>

  <link rel="stylesheet" href="/Portal_Capacitacion/templates/css/login.css">
</head>
<body>
  <section>
    <div class="color"></div>
    <div class="color"></div>
    <div class="color"></div>
    <div class="box">
        <!-- <div class="square" style="--i:0;"></div> -->
        <!-- <div class="square" style="--i:1;"></div> -->
        <!-- <div class="square" style="--i:2;"></div> -->
        <div class="square" style="--i:3;"></div>
        <div class="square" style="--i:4;"></div>
        <!-- <div class="square" style="--i:5;"></div> -->
        <div class="square" style="--i:6;"></div>
         <div class="container">

            <div class="container w-75 bg-dark mt-4 mb-4 rounded shadow">
              <div class="row align-items-stretch">
                  <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">

                      </div>
                      <div class="col bg-white p-5 rounded-end">

                        <h2 class="fw-bold text-center py-5">Bienvenido</h2>

                        <!-- Form -->
                        <form action="conexion.php" method="POST" onsubmit="return validateForm()">
                            <div class="mb-4">
                                <label for="rut" class="form-label">Usuario</label>
                                <input type="text" class="form-control" name="rut" id="rut" placeholder="Ejemplo: 12345678-9" autofocus>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="********">
                            </div>
                            <!--<div class="mb-4">
                                <input type="checkbox" name="connected" class="form-check-input">
                                <label for="connected" class="form-check-label">Mantenerme conectado</label>
                            </div>-->

                                <!-- Área para mostrar mensajes de error -->
                            <?php
                            if (isset($_GET['error'])) {
                                $error_message = $_GET['error'];
                                echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
                            }
                            ?>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>

                            <div class="my-3">
                                <span>¿Olvidaste la contraseña? <a href="/Portal_Capacitacion/pwreset.php" onclick="">Recuperar clave</a></span>
                            </div>
                        </form>

                        <div class="my-3">
                          <img src="/Portal_Capacitacion/templates/img/inevada.jpeg" alt="" width="50" height="50" align="left"/>
                          <img src="/Portal_Capacitacion/templates/img/IVC.jpeg" alt="" width="50" height="50" align="center"/>
                          <img src="/Portal_Capacitacion/templates/img/COVAL.jpeg" alt="" width="50" height="50" align="center"/>
                          <img src="/Portal_Capacitacion/templates/img/SALUDVIDA.jpeg" alt="" width="50" height="50" align="right"/>
                        </div>
                      </div>
                  </div>
                </div>
            </div>            
          </section>
          <!--<script src="login.js"></script>-->
  <script>
    function validateForm() {
      var password = document.getElementById("password").value;

      // Expresiones regulares para verificar requisitos de la contraseña
      var specialChars = /[!@#$%^&*(),.?":{}|<>]/g; // Caracteres especiales
      var uppercaseChars = /[A-Z]/g; // Letras mayúsculas
      var numberChars = /[0-9]/g; // Números

      if (
        password.length < 8 || // Mínimo 8 caracteres
        !specialChars.test(password) || // Al menos un carácter especial
        !uppercaseChars.test(password) || // Al menos una letra mayúscula
        !numberChars.test(password) // Al menos un número
      ) {
        alert("La contraseña debe tener al menos 8 caracteres, un carácter especial, una letra mayúscula y un número.");
        return false; // Evitar enviar el formulario si la validación falla
      }

      return true; // Enviar el formulario si la validación es exitosa
    }
  </script>  

</body>
</html>
</body>

</html>
