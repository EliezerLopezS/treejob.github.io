<?php
// Configuración de la conexión a la base de datos (debes ajustar esto)
include './seguridad/conn_mysql.php';
// Obtener el ID del usuario desde la solicitud POST
$userId = $_POST['userId'];

// Consulta SQL para obtener los datos del usuario
$sql = "DELETE FROM usuarios WHERE id = $userId";


if ($conn->query($sql) === TRUE) {
    // La eliminación fue exitosa
    echo json_encode(array('success' => true, 'message' => 'Usuario eliminado exitosamente'));
} else {
    // Si hubo un error en la eliminación
    echo json_encode(array('success' => false, 'message' => 'Error al eliminar el usuario: ' . $conn->error));
}

// Cerrar la conexión a la base de datos
$conn->close();
?>