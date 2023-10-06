<!DOCTYPE html>
<html lang="en">

<head>

  <?php
  require 'seguridad/conn_mysql.php';
  include 'seguridad/fechas.php';

  ?>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SERVICES</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

  <script src="js/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="js/sweetalert2.min.css">

  <script src="https://apis.google.com/js/platform.js" async defer></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
  <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/Carousel-Hero.css">
  <link rel="stylesheet" href="assets/css/Navbar-With-Button-icons.css">
  <link rel="stylesheet" href="assets/css/Pretty-Footer-.css">

  <link rel="stylesheet" href="assets/css/stylescontact.css">
  <script type="text/javascript" href="js/jquery.min.js"></script>
  <!--link rel="stylesheet" href="js/sweetalert.css"-->
  <link src="js/main.js">
  <link src="js/funciones.js">
  <!--script src="js/sweetalert.min.js"></script-->
</head>

<body>
  <style>
    .whatsapp-float,
    .facebook-float,
    .gmail-float {
      position: fixed;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      text-align: center;
      box-shadow: 2px 2px 3px #999;
      z-index: 100;
    }

    .whatsapp-float {
      right: 20px;
      bottom: 20px;
      background-color: green;
    }

    .facebook-float {
      right: 20px;
      bottom: 100px;
      background-color: #3b5998;
    }

    .gmail-float {
      right: 20px;
      bottom: 180px;
      background-color: #db4a39;
    }

    .whatsapp-float a,
    .facebook-float a,
    .gmail-float a {
      display: block;
      line-height: 60px;
      color: #fff;
      font-size: 25px;
      text-decoration: none;
    }
  </style>

  <div class="whatsapp-float">
    <a href="https://wa.me/+529531188818" target="_blank"><i class="fab fa-whatsapp"></i></a>
  </div>

  <div class="facebook-float">
    <a href="https://www.facebook.com/<usuario-facebook>" target="_blank"><i class="fab fa-facebook-f"></i></a>
  </div>

  <div class="gmail-float">
    <a href="mailto:371eze6.375@gmail.com" target="_blank"><i class="far fa-envelope"></i></a>
  </div>
  <?php
  include 'inc/nav.php';
  ?>




  <section class="py-5">
    <div class="container py-5">
      <div class="row mb-4 mb-lg-5">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
          <p class="fw-bold text-success mb-2">Our Services</p>
          <h3 class="fw-bold">What we can do for you?</h3>
        </div>
      </div>
      <div>
      <p style="  text-align: center;
  font-weight: bolder;
  font-size: 18px;
  color: black ">
      With our passion for nature and experience,
        We strengthen your spaces.
      </p>
      <br>
      
      </div>
      <?php

// Consulta SQL para recuperar los posts
$sql = "SELECT title, content, image_path FROM posts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $postTitle = $row["title"];
        $postContent = $row["content"];
        $maxContentLength = 120; // Número máximo de caracteres que deseas mostrar inicialmente

        // Verificar la longitud del contenido
        if (strlen($postContent) > $maxContentLength) {
            // Si el contenido es más largo que el límite, recortarlo y agregar "..." al final
            $postContentShort = substr($postContent, 0, $maxContentLength) . "...";
        } else {
            // Si el contenido es igual o más corto que el límite, usar el contenido completo
            $postContentShort = $postContent;
        }
        $postImage =basename($row["image_path"]);
        $imageSrc = "imag_post/" . $postImage;

        $orderClass = ($counter % 2 == 0) ? "order-md-last" : "order-md-first";

        // Genera el HTML para cada post con la clase "orderClass"
        echo '<div class="row row-cols-1 row-cols-md-2 mx-auto" style="max-width: 900px;">
                <div class="col ' . $orderClass . ' mb-5"><img class="rounded img-fluid shadow" src="' . $imageSrc . '" /></div>
                <div class="col d-md-flex align-items-md-end align-items-lg-center mb-5">
                  <div>
                    <h5 class="fw-bold">' . $postTitle . '</h5>
                    <div class="post-content">' . $postContentShort . '</div>
                    <div class="post-full-content" style="display: none;">' . $postContent . '</div>
                    <button class="btn btn-primary shadow toggle-button" type="button">Leer más</button>
                  </div>
                </div>
              </div>';
        
        $counter++;
    }
} else {
    echo "No se encontraron posts.";
}

$conn->close();
?>


    </div>
  </section>






  <?php
  include 'inc/footer.php';
  ?>

  <script>
    // Obtener referencias a los campos y al botón
    var nameField = document.getElementById('name1');
    var emailField = document.getElementById('email1');
    var phoneField = document.getElementById('phone1');
    var messageField = document.getElementById('message1');
    var submitButton = document.querySelector('button[name="submit"]');

    function validateForm() {
      // Validar campo de nombre
      var nameValue = nameField.value.trim();
      if (nameValue === '' || !/^[A-Za-z]{1,50}$/.test(nameValue)) {
        nameField.style.color = 'red';
        submitButton.disabled = true;
      } else {
        nameField.style.color = 'black';
      }

      // Validar campo de email
      var emailValue = emailField.value.trim();
      if (emailValue === '' || !/^\S+@\S+\.\S+$/.test(emailValue)) {
        emailField.style.color = 'red';
        submitButton.disabled = true;
      } else {
        emailField.style.color = 'black';
      }

      // Validar campo de teléfono
      var phoneValue = phoneField.value.trim();
      if (phoneValue === '' || !/^\d{8,15}$/.test(phoneValue)) {
        phoneField.style.color = 'red';
        submitButton.disabled = true;
      } else {
        phoneField.style.color = 'black';
      }

      // Validar campo de mensaje
      var messageValue = messageField.value.trim();
      if (messageValue === '' || messageValue.length > 60) {
        messageField.style.color = 'red';
        submitButton.disabled = true;
      } else {
        messageField.style.color = 'black';
      }

      // Habilitar/deshabilitar el botón de envío
      var fields = [nameField, emailField, phoneField, messageField];
      for (var i = 0; i < fields.length; i++) {
        if (fields[i].style.color === 'red') {
          submitButton.disabled = true;
          return;
        }
      }
      submitButton.disabled = false;
    }

    // Invocar la función validateForm() al cargar la página
    validateForm();

    // Asociar la función validateForm() a los eventos 'input' de los campos
    var fields = [nameField, emailField, phoneField, messageField];
    for (var i = 0; i < fields.length; i++) {
      fields[i].addEventListener('input', validateForm);
    }
  </script>

  <script>
    function clearFields() {
      document.getElementById('name1').value = '';
      document.getElementById('email1').value = '';
      document.getElementById('phone1').value = '';
      document.getElementById('message1').value = '';
    }
  </script>

  <script>

    var modalElement = document.getElementById("signin1"); // Reemplaza "myModal" con el ID de tu modal
    modalElement.addEventListener("hidden.bs.modal", function () {
      // Aquí resetea los campos del formulario al cerrar el modal
      document.getElementById("errorCont").textContent = "";
      document.getElementById("password").value = "";
      document.getElementById("password2").value = "";
      document.getElementById("full-name").value = "";
      document.getElementById("email").value = "";
      document.getElementById("phone").value = "";
      document.getElementById("formCheck-1").checked = false;
    });
  </script>
<script>
$(document).ready(function() {
    // Agregar un evento de clic a todos los botones "Leer más"
    $(".toggle-button").click(function() {
        // Encuentra el contenedor del contenido del post
        var contentContainer = $(this).siblings(".post-content");
        var fullContentContainer = $(this).siblings(".post-full-content");
        
        // Alternar la visibilidad del contenido del post
        contentContainer.toggle();
        fullContentContainer.toggle();
        
        // Alternar el texto del botón "Leer más"
        var buttonText = $(this).text() === "Leer más" ? "Leer menos" : "Leer más";
        $(this).text(buttonText);
    });
});
</script>

  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>