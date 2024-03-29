<?php
require 'vendor/autoload.php'; // Carga el autoload de Composer para PHPMailer

// Verifica si se recibió el rut del formulario
if (isset($_POST['rut'])) {
    $rut = $_POST['rut'];

    // include('/var/www/html/Portal_Capacitacion/db/db.php');
    include 'db/db.php';

    /*

    $host = 'localhost';
    $port = '5432';
    $dbname = 'Nevada_Learning';
    $user = 'postgres';
    $password = 'NEVada--3621';

    */

    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    // Consulta para obtener el correo electrónico asociado al RUT (asegúrate de escapar correctamente el valor del RUT para evitar inyección de SQL)
    $query = "SELECT correo FROM usuarios WHERE rut='$rut'";
    $result = pg_query($conn, $query);
    if (!$result) {
        echo "Error en la consulta: " . pg_last_error($conn);
    }
    

    // Verifica si se encontró un correo electrónico asociado al RUT
    if (pg_num_rows($result) > 0) {
        $usuario = pg_fetch_assoc($result);
        $correo = $usuario['correo'];

        // Genera un código numérico de 5 caracteres
        $codigo = mt_rand(10000, 99999);
        // Guardar el código en una variable de sesión
        session_start();
        $_SESSION["rut"] = $rut;
        $_SESSION['codigo_recuperacion'] = $codigo;

        // Configura la conexión con el servidor SMTP y el envío del correo electrónico
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host       = 'smtp.office365.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noreply@inevada.cl';
        $mail->Password   = 'Wok18964';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('noreply@inevada.cl', 'Nombre del Remitente'); // Cambia esto por tu dirección de correo electrónico y nombre
        $mail->addAddress($correo); // Agrega el correo electrónico del destinatario

        $mail->isHTML(true);
        $mail->Subject = 'Código de Recuperación de Clave';
        $mail->Body = 'Tu código de recuperación de clave es: ' . $codigo;

        // Envía el correo electrónico
        if ($mail->send()) {
            // Establece la bandera en localStorage para indicar que el usuario llegó desde envio_correo.php
            echo '<script>window.localStorage.setItem("arrivedFromEnvioCorreo", "true");</script>';
            // Redirige al usuario a la página codigo.php
            echo '<script>alert("Se ha enviado un código de recuperación a tu correo electrónico."); window.location.href = "codigo.php";</script>';
        } else {
            echo '<script>alert("Error al enviar el correo electrónico: ' . $mail->ErrorInfo . '"); window.location.href = "pwreset.php";</script>';
        }
    } else {
        echo '<script>alert("No se encontró ningún usuario registrado con ese RUT. Resultado de la consulta: ' . print_r($result, true) . '"); window.location.href = "pwreset.php";</script>';

    }

    // Cierra la conexión a la base de datos
    pg_close($conn);
} else {
    // Redirige al usuario de vuelta al formulario si no se proporcionó un RUT
    header('Location: pwreset.php');
    exit;
}
?>
