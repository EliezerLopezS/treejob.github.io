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
    <title>CONTACT</title>
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
    <link rel="stylesheet" href="assets/css/styles.css">
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
<div id="mydiv">

<?php include './inc/navbar.php'; ?>
   
      
<section class="py-5" id="mysection">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <br>
                    <p class="fw-bold text-danger mb-2">Contacts</p>
                    <h2 class="fw-bold text-primary">How you can reach us</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center">

                <div class="col-md-6 col-xl-4">
                    <div>
        
                        <form class="p-3 p-xl-4" id="contactmail" autocomplete="off">
                            <div class="mb-3"><input class="form-control" type="text" id="name1" name="name1" placeholder="Name" required></div>
                            <div class="mb-3"><input class="form-control" type="email" id="email1" name="email1" placeholder="Email" required></div>
                            <div class="mb-3"><input class="form-control" type="phone" id="phone1" maxlength="15" name="phone1" placeholder="Phone" required></div>
                            <div class="mb-3"><textarea class="form-control" id="message1" name="message1" rows="6" placeholder="Message" required></textarea></div>
                            <div><button class="btn btn-primary shadow d-block w-100" type="button" name="submit" onclick="submitFormcontact();clearFields();" disabled>Send </button></div>
                        </form>
                        
                    </div>

            
                </div>
                <div class="col-md-4 col-xl-4 d-flex justify-content-center justify-content-xl-start">
                    <div class="d-flex flex-wrap flex-md-column justify-content-md-start align-items-md-start h-100">
                        <div class="d-flex align-items-center p-3">
                            <div class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-telephone">
                                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"></path>
                                </svg></div>



                            <div class="px-2">
                                <h6 class="fw-bold mb-0">Phone</h6>
                                <p class="text-muted mb-0">+17323631935, +18485254756</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center p-3">
                            <div class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-envelope">
                                    <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"></path>
                                </svg></div>
                            <div class="px-2">
                                <h6 class="fw-bold mb-0">Email</h6>
                                <p class="text-muted mb-0">fullseasonlawnandlandscape@gmail.com</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center p-3">
                            <div class="bs-icon-md bs-icon-circle bs-icon-primary shadow d-flex flex-shrink-0 justify-content-center align-items-center d-inline-block bs-icon bs-icon-md"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-pin">
                                    <path d="M4.146.146A.5.5 0 0 1 4.5 0h7a.5.5 0 0 1 .5.5c0 .68-.342 1.174-.646 1.479-.126.125-.25.224-.354.298v4.431l.078.048c.203.127.476.314.751.555C12.36 7.775 13 8.527 13 9.5a.5.5 0 0 1-.5.5h-4v4.5c0 .276-.224 1.5-.5 1.5s-.5-1.224-.5-1.5V10h-4a.5.5 0 0 1-.5-.5c0-.973.64-1.725 1.17-2.189A5.921 5.921 0 0 1 5 6.708V2.277a2.77 2.77 0 0 1-.354-.298C4.342 1.674 4 1.179 4 .5a.5.5 0 0 1 .146-.354zm1.58 1.408-.002-.001.002.001zm-.002-.001.002.001A.5.5 0 0 1 6 2v5a.5.5 0 0 1-.276.447h-.002l-.012.007-.054.03a4.922 4.922 0 0 0-.827.58c-.318.278-.585.596-.725.936h7.792c-.14-.34-.407-.658-.725-.936a4.915 4.915 0 0 0-.881-.61l-.012-.006h-.002A.5.5 0 0 1 10 7V2a.5.5 0 0 1 .295-.458 1.775 1.775 0 0 0 .351-.271c.08-.08.155-.17.214-.271H5.14c.06.1.133.191.214.271a1.78 1.78 0 0 0 .37.282z"></path>
                                </svg></div>
                            <div class="px-2">
                                <h6 class="fw-bold mb-0">Location</h6>
                                <p class="text-muted mb-0">413 Laurel Ave, Lakewood, NJ 08701
                                </p>
                                
                            </div>
                          
                        </div>
                        <div class="d-flex align-items-center p-3">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3052.347818007265!2d-74.20186612485507!3d40.08995747546445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c18214b38fdfbf%3A0xc712219ef5adc5fc!2s413%20Laurel%20Ave%2C%20Lakewood%2C%20NJ%2008701%2C%20EE.%20UU.!5e0!3m2!1ses-419!2smx!4v1695512088906!5m2!1ses-419!2smx" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>



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
    /*function submitFormcontact() {
    $.ajax({
        type: 'POST',
        url: 'acciones/mensajemailer.php',
        data: $('#contactmail').serialize(),
        success: function(response) {
    var data = JSON.parse(response);
    if (data.success) {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: data.message,
            showConfirmButton: false,
            //timer: 2500
        });
        
       // $('#forgetPasswordModal').modal('hide');
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: data.message
        });
        
        //$('#forgetPasswordModal').modal('hide');
    }
}
    });
}
*/
function submitFormcontact() {
  $.ajax({
    type: 'POST',
    url: 'acciones/mensajemailer.php',
    data: $('#contactmail').serialize(),
    success: function(response) {
      var data;
      if (typeof response === 'object') {
        data = response; // La respuesta ya es un objeto JSON
      } else {
        data = JSON.parse(response); // Analizar la respuesta JSON
      }

      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: data.message,
          showConfirmButton: false,
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: '¡Error!',
          text: data.message
        });
      }
    }
  });
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


<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>