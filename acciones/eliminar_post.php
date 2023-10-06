<?php
include '../seguridad/conn_mysql.php';

if (isset($_POST['postId'])) {
    // Recuperar el ID del post desde la solicitud AJAX
    $postId = $_POST['postId'];


$sql = "SELECT image_path FROM posts WHERE id = ?";

// Preparar la declaración SQL
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Vincular el ID del post al marcador de posición y ejecutar la consulta
    $stmt->bind_param("i", $postId); // 'i' significa entero
    
    if ($stmt->execute()) {
        // Obtener la ruta de la imagen
        $stmt->bind_result($imagePath);
        $stmt->fetch();
        $stmt->close();
        
        // Eliminar la imagen del servidor
        if (!empty($imagePath) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Eliminar el post de la base de datos
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Vincular el ID del post al marcador de posición y ejecutar la consulta de eliminación
            $stmt->bind_param("i", $postId); // 'i' significa entero
            
            if ($stmt->execute()) {
                // La eliminación fue exitosa
                echo json_encode(array('success' => true, 'message' => 'Post eliminado con éxito.'));
            } else {
                // Error al ejecutar la consulta de eliminación
                echo json_encode(array('success' => false, 'message' => 'Error al eliminar el post: ' . $stmt->error));
            }
            
            // Cerrar la declaración
            $stmt->close();
        } else {
            // Error en la preparación de la consulta de eliminación
            echo json_encode(array('success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error));
        }
    } else {
        // Error al ejecutar la consulta para obtener la ruta de la imagen
        echo json_encode(array('success' => false, 'message' => 'Error al obtener la ruta de la imagen: ' . $stmt->error));
    }
} else {
    // Error en la preparación de la consulta para obtener la ruta de la imagen
    echo json_encode(array('success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error));
}

// Cerrar la conexión
$conn->close();
} else {
// ID del post no recibido
echo json_encode(array('success' => false, 'message' => 'ID del post no recibido.'));
}

?>