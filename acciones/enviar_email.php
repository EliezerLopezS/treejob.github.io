<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Verifica si se han recibido los datos
if (isset($_POST['id'], $_POST['nombre'], $_POST['email'], $_POST['emision'], $_POST['rutaPDF'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $emision = $_POST['emision'];

    // Configura las credenciales SMTP y crea una instancia de PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Cambia esto a tu servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = '371eze6.375@gmail.com'; // Cambia esto a tu dirección de correo electrónico
    $mail->Password = 'meih etzl imwp pane'; // Cambia esto a tu contraseña
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465; // Puerto SMTP

    // Configura el correo electrónico
    $mail->setFrom('371eze6.375@gmail.com', 'TREE JOB');
    $mail->addAddress($email, $nombre);
    $mail->Subject = 'Envio factura';

        // Agrega el archivo adjunto
        $rutaPDF = '../pdfs/' . basename($_POST['rutaPDF']); // Ruta completa al archivo PDF
        $mail->addAttachment($rutaPDF);

    // Contenido del correo electrónico
    $mail->isHTML(true); // Indica que el contenido del correo es HTML

    $mensaje = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("log.png"); /* Cambia la ruta a tu imagen de fondo */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo semitransparente blanco */
            padding: 20px;
            border-radius: 5px;
            margin: 20px auto;
            max-width: 600px;
        }
        h1 {
            color: #007bff;
        }
        p {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Factura Adjunta</h1>
        <p>Hola ' . $nombre . ',</p>
        <p>Adjunto encontraras la factura correspondiente al pago de los trabajos realizados.</p>
        <p>Gracias por confiar en nosotros.</p>
    </div>
    
</body>
</html>
';

$mail->msgHTML($mensaje);//$mail->Body = $mensaje;



    // Envía el correo electrónico
    if ($mail->send()) {
        //echo 'Correo electrónico enviado correctamente';
        echo json_encode(array('success' => true, 'message' => 'Correo electrónico enviado correctamente'));
    } else {
      //  echo 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
        echo json_encode(array('success' => false, 'message' => 'error al registrar el usuario' . $mail->ErrorInfo));
    }
} else {
    //echo 'Error: Datos no recibidos correctamente.';
    echo json_encode(array('success' => false, 'message' => 'Error: Datos no recibidos correctamente.'));
}
?>
