

<?php
session_start();
// Conexión a la base de datos
include '../seguridad/conn_mysql.php';
include '../seguridad/consultSQL.php';


// Obtener los datos enviados por AJAX
$username = $_POST['username'];
$password = $_POST['passwordlog'];

if($username!="" && $password!=""){

        $verUser="SELECT * FROM usuarios WHERE nombre = '$username' OR email = '$username'";
        $resultado = mysqli_query($conn, $verUser);

        if ($resultado) {
            $filaU = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
            $UserC = mysqli_num_rows($resultado);
        
            if ($UserC > 0) {
                $hash = $filaU['passwod'];
                if (password_verify($password, $hash)) {
                    $_SESSION['nombreUser'] = $username;
                    $_SESSION['claveUser'] = $password;
                    //echo json_encode(array('success' => true));
                    echo '<script> location.href="../index.php"; </script>';
                } else {
                    //echo json_encode(array('success' => false, 'message' => 'Credenciales incorrectas gg'));
                    //Las credenciales son incorrectas, enviar respuesta de error
                    echo 'Credenciales incorrectas.';
                    echo "<script>alert('Usuario o credenciales incorrectas');</script>";
                    echo '<script> location.href="../index.php"; </script>';

                    //$error_message = 'Credenciales incorrectas.';
                    //echo "<script>Swal.fire('Error', '$error_message', 'error').then(() => { location.href='../index.php'; });</script>";

                
                }
            } else {
                //echo json_encode(array('success' => false, 'message' => 'Credenciales incorrectas'));
                //echo 'usuario no registrado.';
                echo "<script>alert('Usuario o credenciales incorrectas');</script>";
                echo '<script> location.href="../index.php"; </script>';

                //$error_message = 'Credenciales incorrectas.';
                //echo "<script>Swal.fire('Error', '$error_message', 'error').then(() => { location.href='../index.php'; });</script>";
            }
        } else {
           // echo json_encode(array('success' => false, 'message' => 'Error en la consulta SQL'));
            echo 'error en la consulta.';
            echo "<script>alert('Usuario o credenciales incorrectas');</script>";
            echo '<script> location.href="../index.php"; </script>';
            //$error_message = 'Credenciales incorrectas.';
            //echo "<script>Swal.fire('Error', '$error_message', 'error').then(() => { location.href='../index.php'; });</script>";
        }
        }else{
            //echo json_encode(array('success' => false, 'message' => 'vacioL'));
            echo 'usuario o credenciales incorrectas.';
            echo "<script>alert('Campos vacios');</script>";
            echo '<script> location.href="../index.php"; </script>';
            //$error_message = 'Credenciales incorrectas.';
            //echo "<script>Swal.fire('Error', '$error_message', 'error').then(() => { location.href='../index.php'; });</script>";
        }

// Consultar la base de datos para verificar las credenciales
/*$sql = "SELECT * FROM usuarios WHERE nombre = '$username' OR email = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $hash = $row['passwod'];

    if (password_verify($password, $hash)) {
        // Las credenciales son correctas, enviar respuesta de éxito
        $_SESSION['nombreUser'] = $username;
        $_SESSION['claveUser'] = $password;

        echo json_encode(array('success' => true));
    } else {
        // Las credenciales son incorrectas, enviar respuesta de error
        echo json_encode(array('success' => false, 'message' => 'Credenciales incorrectas'));
    }
} else {
    // Las credenciales son incorrectas, enviar respuesta de error
    echo json_encode(array('success' => false, 'message' => 'Credenciales incorrectas'));
}

$conn->close();
*/

?>