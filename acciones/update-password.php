<?php
// update-password.php
include '../seguridad/conn_mysql.php';
include '../seguridad/consultSQL.php';
// Verificar si se ha enviado el formulario de actualización de contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $token = $_POST["token"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        // Las contraseñas no coinciden, mostrar mensaje de error
        echo "Las contraseñas no coinciden.";
        // Puedes redirigir al formulario de restablecimiento de contraseña nuevamente o mostrar un mensaje de error en la misma página.
        header("Location: reset-password-form.php?token=$token");
        exit();
    } else {
        // Las contraseñas coinciden, proceder a actualizar la contraseña en la base de datos
        // Realiza aquí la lógica necesaria para actualizar la contraseña en la base de datos
        // Ejemplo: UPDATE usuarios SET password = '$password' WHERE token = '$token'
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Encriptar la contraseña
        $stmt = $conn->prepare("UPDATE usuarios SET passwod = ? WHERE token = ?");
        $stmt->bind_param("ss", $password, $token);
        $stmt->execute();
        // Mostrar mensaje de éxito y redirigir al usuario a la página de inicio de sesión
        echo "Contraseña actualizada exitosamente.";
        // Puedes redirigir al usuario a la página de inicio de sesión
        header("Location: ../index.php");
        exit();
    }
}
?>
