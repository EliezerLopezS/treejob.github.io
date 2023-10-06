<?php
include '../seguridad/conn_mysql.php';

// Obtener los valores de la solicitud AJAX
$nombre = $_POST["nombre"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$direccion = $_POST["direccion"];

// Insertar los datos en la tabla "facturas"
$sql = "INSERT INTO clientes (nombre, email, phone, addres) VALUES ('$nombre', '$email', '$phone', '$direccion')";

if ($conn->query($sql) === TRUE) {
    //echo "Usuario agregado correctamente.";
    echo json_encode(array('success' => true, 'message' => 'Usuario agregado correctamente.'));
} else {
    //echo "Error al agregar usuario: " . $conn->error;
    echo json_encode(array('success' => false, 'message' => 'Error al agregar usuario: ' . $conn->error));
}

$conn->close();
?>
