<?php
// Configuración de la conexión a la base de datos (debes ajustar esto)
$servername = "localhost";
$username = "root";
$password = "";
$database = "mi";

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $database);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}
// Obtener el ID del usuario desde la solicitud POST
$userId = $_POST['userId'];

// Consulta SQL para obtener los datos del usuario
$sql = "SELECT * FROM usuarios WHERE id = $userId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Crear un arreglo asociativo con los datos del usuario
    $usuario = array(
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'email' => $row['email'],
        'phone' => $row['phone'],
        'direccion' => $row['addres']
    );
    // Devolver los datos del usuario en formato JSON
    echo json_encode($usuario);
} else {
    // Si el usuario no se encuentra, devolver un mensaje de error o un arreglo vacío, según sea necesario
    echo json_encode(array('error' => 'Usuario no encontrado'));
}

// Cerrar la conexión a la base de datos
$conn->close();
?>