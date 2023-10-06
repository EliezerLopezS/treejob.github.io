<?php

include '../seguridad/conn_mysql.php';
include '../seguridad/consultSQL.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexión a la base de datos


    // Recuperación de los datos del formulario

$fullname=$_POST['full-name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$dir=$_POST['dir'];
$password=$_POST['password'];
$password2=$_POST['password2'];

if($password==$password2){
$passhash=password_hash($password,PASSWORD_DEFAULT);
    // Verificación de si el correo electrónico ya existe en la base de datos
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(array('success' => false, 'message' => 'El correo electronico ya existe...'));
        //echo "El correo electrónico ya está registrado en la base de datos.";
        exit();
    }

    // Inserción del usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, phone, addres,  passwod) VALUES (?, ?, ?, ?, ?)");

    if ($stmt === false) {
        echo json_encode(array('success' => false, 'message' => 'Error al preparar la consulta' . $conn->error));
        //die("Error al preparar la consulta: " . $conn->error);
    }
    
    $stmt->bind_param("sssss", $fullname, $email, $phone, $dir, $passhash);
    
    if ($stmt->execute()) {
        echo json_encode(array('success' => true, 'message' => 'Registro exitoso...'));
        //echo "El usuario ha sido registrado correctamente.";
    } else {
        echo json_encode(array('success' => false, 'message' => 'error al registrar el usuario' . $stmt->error));
        //echo "Error al registrar al usuario: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
else {
    echo json_encode(array('success' => false, 'message' => 'Las contraseñas no coinciden'));
}
    
}
?>