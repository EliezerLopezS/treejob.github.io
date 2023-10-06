<?php
require '../seguridad/conn_mysql.php';

$op=$_POST['dat_op'];

switch ($op) {
case '1': {//modificar post
	
// Verificar si se recibieron los datos necesarios

    // Recibir los datos del formulario
    $postId = $_POST['postId'];
    $postTitle = $_POST['postTitle'];
    $postContent = $_POST['postContent'];

    // Verificar si se proporcionó una nueva imagen
	$targetDirectory = "../imag_post/";

	// Verificar si se proporcionó una nueva imagen
	if (!empty($_FILES['postImage']['tmp_name'])) {
		$originalFileName = basename($_FILES['postImage']['name']);
		
		// Generar un nombre de archivo único basado en la marca de tiempo
		$uniqueFileName = time() . '_' . $originalFileName;
		
		$targetFile = $targetDirectory . $uniqueFileName;
		
		// Verificar si la imagen anterior existe y eliminarla
		$sql = "SELECT image_path FROM posts WHERE post_id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $postId); // "i" indica que $postId es un entero
		
		// Ejecutar la consulta
		$stmt->execute();
		
		// Vincular el resultado a una variable
		$stmt->bind_result($previousImagePath);
		
		// Obtener la ruta de la imagen anterior (si existe)
		if ($stmt->fetch()) {
			// Verificar si la imagen anterior existe y eliminarla
			if (file_exists($previousImagePath)) {
				unlink($previousImagePath); // Eliminar la imagen anterior
			}
		} else {
			// El post_id proporcionado no existe en la base de datos, manejar el error si es necesario
		}
		
		$stmt->close();

		
		
	
		// Verificar si se subió la nueva imagen correctamente
		if (move_uploaded_file($_FILES['postImage']['tmp_name'], $targetFile)) {
			$imagePath = $targetFile; // Almacenar la ruta de la nueva imagen
		} else {
			echo json_encode(array('success' => false, 'message' => 'Error al subir la imagen: ' . $_FILES['postImage']['error']));
			exit;
		}
	} else {
		// Si no se proporcionó una nueva imagen, mantener la imagen anterior sin cambios
		$imagePath = $previousImagePath; // Reemplazar con la ruta correcta
	}

    // Actualizar los datos del post en la base de datos
    // Aquí deberías implementar la lógica para actualizar el post en la base de datos, incluyendo la imagen si se proporcionó una nueva
	$sql = "UPDATE posts SET title=?, content=?, image_path=? WHERE id=?";

	// Prepara la declaración SQL
	$stmt = $conn->prepare($sql);
	if ($stmt) {
		// Vincula los valores a los marcadores de posición y ejecuta la consulta
		$stmt->bind_param("sssi", $postTitle, $postContent, $imagePath, $postId);
		if ($stmt->execute()) {
			echo json_encode(array('success' => true, 'message' => 'Post actualizado correctamente.'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Error al actualizar el post: ' . $stmt->error));
		}

		// Cierra la declaración
		$stmt->close();
	} else {
		echo json_encode(array('success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error));
	}


}break;
case '2': {//MODIFICAR PERSONAL
	if (
	isset($_POST['dat_id']) || 
	isset($_POST['dat_nombre']) || 
	isset($_POST['dat_email']) || 
	isset($_POST['dat_phone']) || 
	isset($_POST['dat_addres'])
    )
	{
		$mid=$_POST['dat_id'];
		$name=$_POST['dat_nombre'];
		$email=$_POST['dat_email'];
		$phone=$_POST['dat_phone'];
		$addres=$_POST['dat_addres'];
		
		    // Prepara la consulta SQL con marcadores de posición (?)
			$sql = "UPDATE clientes SET nombre=?, email=?, phone=?, addres=? WHERE id=?";

			// Prepara la declaración SQL
			$stmt = $conn->prepare($sql);
		
			if ($stmt) {
				// Vincula los valores a los marcadores de posición y ejecuta la consulta
				$stmt->bind_param("ssssi", $name, $email, $phone, $addres, $mid);
				if ($stmt->execute()) {
					echo json_encode(array('success' => true, 'message' => 'Usuario actualizado correctamente.'));
				} else {
					echo json_encode(array('success' => false, 'message' => 'Error al actualizar el usuario: ' . $stmt->error));
				}
		
				// Cierra la declaración
				$stmt->close();
			} else {
				echo json_encode(array('success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error));
			}
		
			// Cierra la conexión
			$conn->close();
	}
}break;
case '3': {
	//ELIMINAR tbls_PERSONAL
	if (isset($_POST['del_personal']))
	{
		$id_personal=$_POST['del_personal'];
		$sql="DELETE FROM clientes WHERE id=$id_personal";
		if ($conn->query($sql) === TRUE) {
			//echo "Usuario agregado correctamente.";
			echo json_encode(array('success' => true, 'message' => 'Usuario eliminado correctamente.'));
		} else {
			//echo "Error al agregar usuario: " . $conn->error;
			echo json_encode(array('success' => false, 'message' => 'Error al eliminar usuario: ' . $conn->error));
		}
		
		$conn->close();
	}
}break;



}
?>