<?php
include '../seguridad/conn_mysql.php';
// Verificar si se recibieron los datos del formulario

if (isset($_POST['postTitle']) && isset($_POST['postContent'])) {
    // Recuperar los datos del formulario
    $postTitle = $_POST['postTitle'];
    $postContent = $_POST['postContent'];
    
    // Manejar la subida de la imagen (si se proporciona)
    $imagePath = ""; // Variable para almacenar la ruta de la imagen
    
    if (isset($_FILES['postImage'])) {
        $targetDirectory = "../imag_post/"; // Directorio donde se guardarán las imágenes
        $originalFileName = basename($_FILES['postImage']['name']);
    
        // Generar un nombre de archivo único basado en la marca de tiempo
        $uniqueFileName = time() . '_' . $originalFileName;
        
        $targetFile = $targetDirectory . $uniqueFileName;
        // Verificar si se subió la imagen correctamente
        if (move_uploaded_file($_FILES['postImage']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile; // Almacenar la ruta de la imagen
        } else {
            //echo json_encode(array('success' => false, 'message' => 'Error al subir la imagen.'));
            echo json_encode(array('success' => false, 'message' => 'Error al subir la imagen: ' . $_FILES['postImage']['error']));
            exit;
        }
    }
    
    $sql = "INSERT INTO posts (title, content, image_path) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

if ($stmt) {
    // Vincular los valores a los marcadores de posición y ejecutar la consulta
    $stmt->bind_param("sss", $postTitle, $postContent, $imagePath); // 's' significa cadena de texto
    
    if ($stmt->execute()) {
        // La inserción fue exitosa
        echo json_encode(array('success' => true, 'message' => 'Publicación guardada con éxito.'));
    } else {
        // Error al ejecutar la consulta
        echo json_encode(array('success' => false, 'message' => 'Error al guardar la publicación: ' . $stmt->error));
    }
    
    // Cerrar la declaración
    $stmt->close();
} else {
    // Error en la preparación de la consulta
    echo json_encode(array('success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error));
}

// Cerrar la conexión
$conn->close();
} else {
    // Datos del formulario no recibidos
    echo json_encode(array('success' => false, 'message' => 'No se recibieron datos del formulario.'));
}
?>