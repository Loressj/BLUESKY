<?php
session_start();

// Verifica si la sesión está iniciada
if (!isset($_SESSION['rut'])) {
    // Si la sesión no está iniciada, redirige al usuario a pwreset.php
    header("Location: pwreset.php");
    exit(); // Asegura que el script se detenga después de la redirección
}

// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificamos si la variable de sesión 'rut' está definida
    if (!isset($_SESSION['rut'])) {
        echo "La variable de sesión 'rut' no está definida.";
        exit;
    }

    $rut = $_SESSION['rut'];
    $new_password1 = $_POST['new_password1'];
    $new_password2 = $_POST['new_password2'];

    // Verificar si las contraseñas coinciden
    if ($new_password1 != $new_password2) {
        $mensaje_html = "<div class='alert alert-danger' role='alert'>Las contraseñas no coinciden.</div>";
    } else {
        // Incluir el archivo de conexión a la base de datos
        include('db/db.php');

        // Conexión a la base de datos con PostgreSQL
        $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        // Verificar si la conexión fue exitosa
        if (!$conn) {
            echo "Error en la conexión a la base de datos.";
            exit;
        }

        try {
            // Obtener la fecha y hora actual
            $fecha_actual = date("Y-m-d H:i:s");

            // Preparar la consulta SQL para actualizar la contraseña y la fecha de última modificación
            $query = "UPDATE usuarios SET contrasena = '$new_password1', ultima_modificacion_contrasena = '$fecha_actual' WHERE rut = '$rut'";
            $result = pg_query($conn, $query);

            // Verificar si la consulta fue exitosa
            if ($result) {
                $mensaje_html = "<div class='alert alert-success' role='alert'>La contraseña se actualizó correctamente.</div>";
                // Redirigir al usuario a login.php después de 2 segundos
                echo "<script>setTimeout(function() { window.location.href = 'login.php'; }, 2000);</script>";
            } else {
                // Si hay algún error, mensaje de error para mostrar en el HTML
                $mensaje_html = "<div class='alert alert-danger' role='alert'>Error al actualizar la contraseña: " . pg_last_error($conn) . "</div>";
            }
            // Cerrar la conexión a la base de datos
            pg_close($conn);
        } catch (Exception $e) {
            // Si hay algún error, mensaje de error para mostrar en el HTML
            $mensaje_html = "<div class='alert alert-danger' role='alert'>Error al actualizar la contraseña: " . $e->getMessage() . "</div>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva contraseña</title>
    <link rel="stylesheet" href="/Portal_Capacitacion/templates/css/newpw.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <section>
        <div class="color"></div>
        <div class="color"></div>
        <div class="color"></div>
        <div class="box">
            <div class="square" style="--i:0;"></div>
            <div class="square" style="--i:1;"></div>
            <div class="square" style="--i:2;"></div>
            <div class="square" style="--i:3;"></div>
            <div class="square" style="--i:4;"></div>
            <div class="square" style="--i:5;"></div>
            <div class="square" style="--i:6;"></div>
             <div class="container" style="width: 28em;">
                <div class="form">
                    <h2>Nueva contraseña</h2>
                    <p>Su nueva contraseña debe contener al menos: una mayúscula, un carácter especial, un número y tener una longitud mínima de 8 caracteres.</p>
                    <form id="forgotPasswordForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm();">
                        <div class="inputBox">
                            <input type="password" id="new_password1" name="new_password1" placeholder="Ingrese su nueva contraseña" required autocomplete="off"/>
                        </div>
                        <div class="inputBox">
                            <input type="password" id="new_password2" name="new_password2" placeholder="Reingrese su contraseña" required autocomplete="off"/>
                        </div>
                        <div class="inputBox">
                            <input type="submit" value="Enviar" />
                        </div>
                    </form>
                    <?php
                    // Mostrar el mensaje en el HTML
                    echo $mensaje_html;
                    ?>
                </div>
             </div>
        </div>
    </section>

    <script>
        function validateForm() {
      var password = document.getElementById("new_password1").value;

      // Expresiones regulares para verificar requisitos de la contraseña
      var specialChars = /[!@#$%^&*(),.-_?":{}|<>]/g; // Caracteres especiales
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
    function validarContraseña() {
        var contraseña = document.getElementById("new_password1").value;
        var confirmarContraseña = document.getElementById("new_password2").value;
        
        if (contraseña !== confirmarContraseña) {
            alert("Las contraseñas no coinciden. Por favor, inténtalo de nuevo.");
            return false; // Evita que se envíe el formulario si las contraseñas no coinciden
        }
        
        return true; // Envía el formulario si las contraseñas coinciden
    }
</script>
</body>
</html>
