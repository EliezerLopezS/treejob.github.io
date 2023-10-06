
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['name1'];
    $email = $_POST['email1'];
    $phone = $_POST['phone1'];
    $message = $_POST['message1'];

    $response = array(); // Respuesta JSON

    if (empty($nombre)) {
        $response['success'] = false;
        $response['message'] = 'El campo nombre es obligatorio';
        echo json_encode($response);
        return; // Termina la ejecución del script
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['success'] = false;
        $response['message'] = 'La dirección de correo electrónico no es válida';
        echo json_encode($response);
        return;
    }

    if (empty($phone)) {
        $response['success'] = false;
        $response['message'] = 'El campo teléfono es obligatorio';
        echo json_encode($response);
        return;
    }

    if (empty($message)) {
        $response['success'] = false;
        $response['message'] = 'El campo mensaje es obligatorio';
        echo json_encode($response);
        return;
    }

    $msg = "De: $nombre <br> Correo: <a href='mailto:$email'>$email</a><br>";
    $msg .= "Telefono: $phone<br><br>";
    $msg .= "Mensaje:";
    $msg .= '<p>' . $message . '</p>';
    $msg .= "Enviado el " . date('d/m/Y', time());

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '371eze6.375@gmail.com';
        $mail->Password = 'meih etzl imwp pane';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('371eze6.375@gmail.com', 'Usuario');
        $mail->addAddress('371eze6.375@gmail.com', 'Receptor');
        //$mail->addReplyTo('otro@dominio.com');

        $mail->isHTML(true);
        $mail->Subject = 'Formulario de contacto';
        $mail->Body = utf8_decode($msg);

        $mail->send();

        $response['success'] = true;
        $response['message'] = 'Correo electrónico enviado con éxito';
        echo json_encode($response);
    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = 'Error al enviar el correo electrónico: ' . $mail->ErrorInfo;
        echo json_encode($response);
    }
}
?>
