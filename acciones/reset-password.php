<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include '../seguridad/conn_mysql.php';
include '../seguridad/consultSQL.php';

// Función para generar un token aleatorio
function generateToken($length = 32) {
    $token = bin2hex(openssl_random_pseudo_bytes($length));
    return $token;
}

// Verificar si el formulario de restablecimiento de contraseña se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el correo electrónico ingresado por el usuario
    $email = $_POST["email"];

    // Verificar si el correo electrónico existe en tu base de datos o sistema de usuarios
    // Realiza aquí la lógica necesaria para verificar la existencia del correo electrónico
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {

   

    // Generar un token único para el usuario
    $token = generateToken();

    // Guarda el token en tu base de datos o sistema de usuarios para su posterior verificación
    $stmt = $conn->prepare("UPDATE usuarios SET token = ? WHERE email = ?");
    $stmt->bind_param("ss", $token, $email);
    if ($stmt->execute()) {
    // Crear el cuerpo del correo electrónico
    //$resetLink = "https://tupagina.com/reset-password-form.php?token=" . $token;
    $resetLink = "http://localhost/mi/acciones/reset-password-form.php?token=" . $token;
    $message = "Hola,\n\nPuedes restablecer tu contraseña haciendo clic en el siguiente enlace:\n\n" . $resetLink;

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Configura el servidor SMTP que uses
        $mail->SMTPAuth = true;
        $mail->Username = '371eze6.375@gmail.com';  // Tu dirección de correo electrónico
        $mail->Password = 'meih etzl imwp pane';  // Tu contraseña de correo electrónico
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('371eze6.375@gmail.com', 'Eliezer Lopez');  // Tu dirección de correo electrónico y nombre

        $mail->addAddress($email);  // Agrega el correo electrónico del destinatario

        $mail->isHTML(false);
        $mail->Subject = 'Restablecer contraseña';
        $mail->Body = $message;

        // Envía el correo electrónico
        $mail->send();

       // echo 'Correo electrónico enviado con éxito. Por favor, revisa tu bandeja de entrada.';
        echo json_encode(array('success' => true, 'message' => 'Correo electrónico enviado con éxito. Por favor, revisa tu bandeja de entrada...'));
    } catch (Exception $e) {
        //echo 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
        echo json_encode(array('success' => false, 'message' => 'Error al enviar el correo electrónico: '. $mail->ErrorInfo));
    }
}else{
    echo json_encode(array('success' => false, 'message' => 'Error al guardar el token en la base de datos'));
}
}else{
    echo json_encode(array('success' => false, 'message' => '¡El correo que ingreso no existe en el sistema!'));
}
}
?>
