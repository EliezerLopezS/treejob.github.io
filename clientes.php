<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['nombreUser'])) {
    // Si no ha iniciado sesión, redirige a la página de inicio de sesión o muestra un mensaje de error.
    header('Location: index'); // Cambia 'login.php' al nombre de tu página de inicio de sesión.
    exit(); // Asegúrate de detener la ejecución del script.
}
error_reporting(E_PARSE);
?>
<?php
include 'seguridad/fechas.php';
include 'acciones/facturas.php';

$nuevaSearchType = isset($_GET['nuevaSearchType']) ? $_GET['nuevaSearchType'] : 'all';
$nuevaSearch = isset($_GET['nuevaSearch']) ? $_GET['nuevaSearch'] : '';

$nuevoTotalFacts = getNuevaTotalFacts($nuevaSearch, $nuevaSearchType);
$nuevosFacts = getNuevosFacts($nuevaSearch, $nuevaSearchType);
?>

<?php
include 'acciones/users.php';

$searchType = isset($_GET['searchType']) ? $_GET['searchType'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$totalUsers = getTotalUsers($search, $searchType);
$users = getUsers($search, $searchType);
?>

<!DOCTYPE html>
<html>

<head>

<title>Mi - Datos</title>
    <!--meta charset="utf-8"-->
    <script type="text/javascript">{ if (history.forward(1)) { location.replace(history.forward(1)) } }</script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <!--script type="text/javascript" src="js/jquery.min.js"></script-->




    <style type="text/css">
        body {
            font-family: calibri;
        }
    </style>


    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="js/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="js/sweetalert2.min.css">
    <script src="jjs/code.jquery.com_jquery-3.6.0.min.js"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-With-Button-icons.css">

    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

          <script>
        // Bloquear el campo #totalT
  $('#totalT').prop('readonly', true);

  // Bloquear el campo #total
  $('#total').prop('readonly', true);

  $('#clienteNombre').prop('readonly', true);
  
  $('#clienteEmail').prop('readonly', true);
  $('#clientePhone').prop('readonly', true);
  $('#clienteAddres').prop('readonly', true);

      </script>

</head>

<body>
    <?php
    include 'inc/nav.php';
    ?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <div id="page"><br><br>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissable" id="msg" style="display: none">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <br>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <b>[Banco de Datos - Operaciones]</b>
                        <div id="mensaje">

                        </div>
                    </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs" id="myTabs">
                            <li class="nav-item">
                                <a class="nav-link active" id="tabp" data-toggle="tab" href="#tab_per" role="tab"
                                    aria-selected="true">
                                    <b><i style="width: 16px" class="fa fa-users"></i> Clientes</b>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab_fact" role="tab" tabindex="2">
                                    <b><i style="width: 16px" class="fa fa-file-pdf"></i> Facturas</b>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#post_index" role="tab" tabindex="3">
                                    <b><i style="width: 16px" class="fa fa-heart"></i>Publica servicios</b>
                                </a>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab_per">
                                <div class="container">
                                    <form class="form-inline">
                                        <br>
                                        <div class="form-group col-md-4">
                                            <select class="form-control" name="searchType" id="searchType">

                                                <option value="all" <?php if ($searchType === 'all')
                                                    echo 'selected'; ?>>Mostrar todos</option>
                                                <option value="name" <?php if ($searchType === 'name')
                                                    echo 'selected'; ?>>Buscar por Nombre</option>
                                                <option value="email" <?php if ($searchType === 'email')
                                                    echo 'selected'; ?>>Buscar por Correo</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4" style="display: none" id="searchContainer">
                                            <input type="text" class="form-control" name="search" id="search"
                                                placeholder="Buscar" value="<?php echo $search; ?>">
                                        </div>
                                        
    

                                        <br>
                                    </form>
                                    <div class="col-md-12" align="right">
                                            <button class="btn btn-primary" id="addClient" data-toggle="modal" data-target="#modalAddClient">
                                                <i class="fas fa-user"></i> Agregar Cliente
                                            </button>
                                           
                                        </div>
                                        <br> 
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #f5f5f5">
                                                    <th>ID</th>
                                                    <th>Nombre</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Acciones</th>
                                                    <th>Facturar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="userList">
                                                <?php foreach ($users as $user) { ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <?php echo $user['id']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $user['nombre']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $user['email']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $user['phone']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="btn-group">
                                                                                                <button class="btn btn-warning btn-sm edit-btn"
                                                                                                    data-toggle="modal" data-target="#editModal"
                                                                                                    data-id='<?php echo $user['id']; ?>'
                                                                                                    data-nombre='<?php echo $user['nombre']; ?>'
                                                                                                    data-email='<?php echo $user['email']; ?>'
                                                                                                    data-phone='<?php echo $user['phone']; ?>'
                                                                                                    data-addres='<?php echo $user['addres']; ?>'>
                                                                                                    <i class="fa fa-refresh"></i> | <i
                                                                                                        class="fa fa-trash"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="btn-group">
                                                                                                <button class="btn btn-primary btn-sm edit-btn"
                                                                                                    data-toggle="modal" data-target="#facturaModal"
                                                                                                    data-id2='<?php echo $user['id']; ?>'
                                                                                                    data-nombre2='<?php echo $user['nombre']; ?>'
                                                                                                    data-email2='<?php echo $user['email']; ?>'
                                                                                                    data-phone2='<?php echo $user['phone']; ?>'
                                                                                                    data-addres2='<?php echo $user['addres']; ?>'>
                                                                                                    <i class="fas fa-file-invoice"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="tab_fact">
                                <!-- Contenido de la pestaña facturas -->
                                <div class="container">
                                    <br>
                                    <form method="GET">
                                        <div class="form-row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <select class="form-control" name="nuevaSearchType"
                                                        id="nuevaSearchType">

                                                        <option value="all" <?php if ($nuevaSearchType === 'all')
                                                            echo 'selected'; ?>>Mostrar todos</option>
                                                        <option value="namee" <?php if ($nuevaSearchType === 'namee')
                                                            echo 'selected'; ?>>Buscar por Nombre</option>
                                                        <option value="date" <?php if ($nuevaSearchType === 'date')
                                                            echo 'selected'; ?>>Buscar por Fecha</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group" id="searchContainern" style="display: none;">
                                                    <input type="text" class="form-control" name="nuevaSearch"
                                                        id="nuevaSearch" placeholder="Buscar"
                                                        value="<?php echo $nuevaSearch; ?>">
                                                </div>
                                            </div>
                                            <!-- Nuevo campo de búsqueda por fecha -->
                                            <div class="col-md-3">
                                                <div class="form-group" id="searchContainerF" style="display: none;">
                                                    <input type="date" class="form-control" name="nuevaSearchDate"
                                                        id="nuevaSearchDate">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </form>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr style="background-color: #f5f5f5">
                                                    <th>ID</th>
                                                    <th>Nombre del cliente</th>
                                                    <th>Email</th>
                                                    <th>Fecha de emisión</th>
                                                    <th>Pdf</th>
                                                    <th>Vista Previa y Descargar</th>
                                                    <th>Enviar por correo</th>
                                            </thead>
                                            <tbody id="factList">
                                                <?php foreach ($nuevosFacts as $fact) { ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <?php echo $fact['id']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $fact['clienteNombre']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $fact['email']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $fact['fechaEmision']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo basename($fact['rutaPDF']); ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <button class="btn btn-warning btn-sm edit-btn pdf-preview-btn"
                                                                                                data-bs-toggle="modal" data-bs-target="#pdfPreview"
                                                                                                data-id="<?php echo $fact['id']; ?>"
                                                                                                data-ruta="<?php echo basename($fact['rutaPDF']); ?>">
                                                                                                <i class="fa fa-file-pdf"></i> | <i
                                                                                                    class="fas fa-arrow-down"></i>
                                                                                            </button>
                                                                                        </td>
                                                                                        <td>
                                                                                            <button class="btn btn-danger btn-sm email-btn"
                                                                
                                                                                                data-id1="<?php echo $fact['id']; ?>"
                                                                                                data-nombre="<?php echo $fact['clienteNombre']; ?>"
                                                                                                data-email="<?php echo $fact['email']; ?>"
                                                                                                data-emision="<?php echo $fact['fechaEmision']; ?>"
                                                                                                data-ruta1="<?php echo basename($fact['rutaPDF']); ?>">
                                                                                                <i class="fas fa-file-invoice"></i>
                                                                                            </button>
                                                                                        </td>
                                                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="post_index">
                                <div class="container">
                                                    <br>
                                        <h4 align="center" style="  color: #007bff;font-size: 24px;font-weight: bold;margin-bottom: 20px; ">ESCRIBE POSTS PARA TUS SERVICIOS</h4>
                                         <div class="col-md-12" align="left">
                                            <button class="btn btn-primary" id="add_pos" data-toggle="modal" data-target="#modalAddPost">
                                                <i class="fa fa-pencil"></i> Agregar Post
                                            </button>
                                           
                                        </div>
                                        <br><br>
                                        <div  class="table-responsive">
                                        <table class="tabla-posts display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr style="background-color: #f5f5f5;">
                                                        <th>Título</th>
                                                        <th>Contenido</th>
                                                        <th>Imagen</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php

                                                    // Consulta SQL para recuperar los posts
                                                    $sql = "SELECT * FROM posts";

                                                    // Ejecutar la consulta
                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        // Si hay resultados, muestra los posts en la tabla
                                                        while ($row = $result->fetch_assoc()) {
                                                            $postTitle = $row["title"];
                                                            $postConten = $row["content"];
                                                            $postImage = basename($row["image_path"]);
                                                            $imageSrc = "imag_post/" . $postImage;
                                                            $maxContentLength = 90; // Número máximo de caracteres que deseas mostrar inicialmente

                                                            // Verificar la longitud del contenido
                                                            if (strlen($postConten) > $maxContentLength) {
                                                                // Si el contenido es más largo que el límite, recortarlo y agregar "..." al final
                                                                $postContentShort = substr($postConten, 0, $maxContentLength) . "...";
                                                            } else {
                                                                // Si el contenido es igual o más corto que el límite, usar el contenido completo
                                                                $postContentShort = $postConten;
                                                            }
                                                            // Mostrar cada post en una fila de la tabla
                                                            echo '<tr>
                                                    <td>' . $postTitle . '</td>
                                                    <td>' . $postContentShort . '</td>
                                                    <td><img src="' . $imageSrc . '" alt="Imagen del Post" style="max-width: 100px;" /></td>
                                                    <td>
                                                    <button class="btn btn-primary update-post" data-toggle="modal" data-target="#updateModal"
                                                        data-post-id="' . $row["id"] . '"
                                                        data-post-title="' . $postTitle . '"
                                                        data-post-content="' . $postConten . '"
                                                        data-post-image="' . $postImage . '">
                                                        <i class="fas fa-refresh"></i> 
                                                    </button>
                                                        <button class="btn btn-danger delete-post" data-post-id="' . $row["id"] . '">
                                                            <i class="fas fa-trash"></i> 
                                                        </button>
                                                    </td>
                                                </tr>';
                                                        }
                                                    } else {
                                                        echo "No se encontraron posts.";
                                                    }

                                                    // Cerrar la conexión
                                                    $conn->close();
                                                    ?>
                                                </tbody>
                                            </table>
                                    </div>

                                 </div>


                            </div>
                        </div>
<!--div>aqui van los modales</div-->
<!-- Modal para actualizar -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Actualizar Publicación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Aquí coloca los campos para actualizar -->
        <form id="updateForm" enctype="multipart/form-data">
          <input type="hidden"  id="postId" name="postId">
          
          <div class="form-group">
            <label for="postTitle">Título:</label>
            <input type="text" class="form-control" id="postTitle" name="postTitle">
          </div>
          <div class="form-group">
            <label for="postContent">Contenido:</label>
            <textarea class="form-control" id="postContent" name="postContent"></textarea>
          </div>
          <!-- Otros campos de actualización -->
          <div class="form-group">
                        <label for="postImage">Imagen (opcional)</label>
                        <input type="file" class="form-control-file" id="postImage" name="postImage">
                    </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="updatePostBtn">Actualizar</button>
      </div>
    </div>
  </div>
</div>

 <!-- Modal para agregar POSTS -->
 <div class="modal fade" id="modalAddPost" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Agregar Post</h5>
                <div id="load_" align="center"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para editar los campos del usuario -->
                <div class="form-group mb-3" id="errorCon" align="center" style="font-size: 12px;"></div>
                <form id="postForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="postTitle">Título del Post</label>
                        <input type="text" class="form-control" id="postTitle" name="postTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="postContent">Contenido del Post</label>
                        <textarea class="form-control" id="postContent" name="postContent" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="postImage">Imagen (opcional)</label>
                        <input type="file" class="form-control-file" id="postImage" name="postImage">
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                
                <button type="button" id="btnAddPost" class="btn btn-primary">Publicar</button>
                <button type="button" id="btnAddExPost" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para facturar -->
<div class="modal fade" id="facturaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Crear Factura</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Formulario de factura -->
            <form id="facturaForm">
              <!-- Datos del cliente -->
              <input type="hidden" id="UserId" name="UserId">
              <div class="form-group">
                <label for="clienteNombre">Nombre del Cliente</label>
                <input type="text" class="form-control" id="clienteNombre" placeholder="Nombre del Cliente" readonly>
              </div>
              <div class="form-group">
                <label for="clienteEmail">Correo Electrónico del Cliente</label>
                <input type="email" class="form-control" id="clienteEmail" placeholder="Correo Electrónico" readonly>
              </div>
             <div class="form-group">
                <label for="clientePhone">Telefono del Cliente</label>
                <input type="phone" class="form-control" id="clientePhone" placeholder="Phone" readonly>
              </div>
             <div class="form-group">
                <label for="clienteAddres">Direccion del Cliente</label>
                <input type="text" class="form-control" id="clienteAddres" placeholder="Address" readonly>
              </div>
              <!-- Detalles de los productos -->
              <h4>Detalles de los Productos</h4>
              <div id="productos">
                <!-- Aquí se agregarán dinámicamente los campos para los productos -->
              </div>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#productoModalL" id="agregarProducto">Agregar Producto</button>
              
              <!-- Totales -->
              <h4>Totales</h4>
              <div class="form-group">
                <label for="total">Total</label>
                <input type="text" class="form-control" id="total" readonly>
              </div>
              <div class="form-group">
                <label for="pagoAdd">Pago adelantado</label>
                <input type="text" class="form-control" id="pagoAdd">
              </div>
              <div class="form-group">
                <label for="totalT">Total por pagar</label>
                <input type="text" class="form-control" id="totalT" readonly>
              </div>
              <!--div class="form-group">
                <label for="impuesto">Impuesto (IVA)</label>
                <input type="text" class="form-control" id="impuesto" readonly>
              </div-->

            </form>
          </div>
          <div class="modal-footer">
            <!-- Botones para generar la factura y cerrar el modal -->
            <button type="button" class="btn btn-primary" id="generarFactura">Generar Factura</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelButton">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

 <!-- Modal para ingresar descripción y precio del producto -->
 <div class="modal fade" id="productoModalL"  tabindex="-1" role="dialog" aria-labelledby="productoModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: rgb(243, 243, 243);">
          <div class="modal-header">
            <h5 class="modal-title" id="productoModalLabel">Agregar Producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="productoForm">
              <div class="form-group">
                <label for="productoDescripcion">Descripción</label>
                <input type="text" class="form-control" id="productoDescripcion" placeholder="Descripción">
              </div>
              <div class="form-group">
                <label for="productoCosto">Costo</label>
                <input type="text" class="form-control" id="productoCosto" placeholder="Costo">
                

              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="guardarProducto">Guardar</button>
            <button type="button" class="btn btn-danger" id="btn_canc" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

 <!-- Modal para agregar cliente -->
 <div class="modal fade" id="modalAddClient" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Agregar Clientes</h5>
                <div id="load_ajax_mPersonal" align="center"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para editar los campos del usuario -->
                <div class="form-group mb-3" id="errorCon" align="center" style="font-size: 12px;"></div>
                <form id="editForm">
                    <input type="hidden" id="inUserId" name="inUserId">
                    <div class="form-group">
                        <label for="editNombre">Nombre</label>
                        <input type="text" class="form-control" id="inNombre" name="inNombre" oninput="checkFormValidit()">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="inEmail" name="inEmail" oninput="checkFormValidit()">
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone</label>
                        <input type="text" class="form-control" id="inPhone" name="inPhone" oninput="checkFormValidit()">
                    </div>
                    <div class="form-group">
                        <label for="editDireccion">Dirección</label>
                        <input type="text" class="form-control" id="inDireccion" name="inDireccion" oninput="checkFormValidit()">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnAddPersonal" class="btn btn-success">AGREGAR CLIENTE</button>
                <button type="button" id="btnAddExPer" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>



 
    <!-- Modal para editar -->

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Modificar/Eliminar Clientes</h5>
                <div id="load_ajax_mPersonal" align="center"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para editar los campos del usuario -->
                <form id="editForm">
                    <input type="hidden" id="editUserId" name="editUserId">
                    <div class="form-group">
                        <label for="editNombre">Nombre</label>
                        <input type="text" class="form-control" id="editNombre" name="editNombre">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="editEmail">
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone</label>
                        <input type="text" class="form-control" id="editPhone" name="editPhone">
                    </div>
                    <div class="form-group">
                        <label for="editDireccion">Dirección</label>
                        <input type="text" class="form-control" id="editDireccion" name="editDireccion">
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
             <button type="submit" id="btnUpdPersonal" class="btn btn-primary">ACTUALIZAR</button>
                <button type="button" id="btnDelPersonal" class="btn btn-danger">ELIMINAR CLIENTE</button>
                <button type="button" id="btnExiPersonal" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar la factura -->
<div class="modal fade" id="pdfPreview" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfPreviewLabel">Vista Previa del PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Inserta aquí el visor de PDF o el elemento <embed> o <iframe> para mostrar el PDF -->
                <embed src="#" type="application/pdf" width="100%" height="600px" />
            </div>
            <div class="modal-footer">
                <a href="#" id="pdfDownloadLink"class="btn btn-primary" download>Descargar PDF</a>
                <button type="button" id class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!--div>aqui terminan los modales</div-->




                    </div>                                    
                </div>    
             </div>  
         </div>   
     </div> 
    </div>   



    <script>
       function checkFormValidit() {

    var fullNameIn = document.getElementById("inNombre");
    var emailIn = document.getElementById("inEmail");
    var phoneIn = document.getElementById("inPhone");
    var dirIn = document.getElementById("inDireccion");
 

    // Expresiones regulares para validar los campos
    var fullNameRegex = /^[a-zA-Z ]{1,50}$/;
    var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    var phoneRegex = /^[0-9]{8,15}$/;
    var dirRegex = /^[a-zA-Z0-9\s,.'-]+$/;

    var errors = []; // Array para almacenar los mensajes de error



    if (!fullNameRegex.test(fullNameIn.value)) {
        errors.push("El nombre no debe incluir números.");
        fullNameIn.style.color = "red";
    } else {
        fullNameIn.style.color = "black";
    }

    if (!emailRegex.test(emailIn.value)) {
        errors.push("Correo no válido.");
        emailIn.style.color = "red";
    } else {
        emailIn.style.color = "black";
    }

    if (!phoneRegex.test(phoneIn.value)) {
        errors.push("Numero de telefono solo incluye números.");
        phoneIn.style.color = "red";
    } else {
        phoneIn.style.color = "black";
    }

    if (!dirRegex.test(dirIn.value)) {
        errors.push("Direccion solo incluye numeros y letras.");
        dirIn.style.color = "red";
    } else {
        dirIn.style.color = "black";
    }

    // Actualizar los estilos del botón de envío
    var submitButton = document.getElementById("btnAddPersonal");
    submitButton.disabled = errors.length > 0;

    // Mostrar los mensajes de error en el contenedor correspondiente
    var errorContainer = document.getElementById("errorCon");
    if (errors.length > 0) {
        errorContainer.textContent = errors.join("\n");
        errorContainer.style.color = "red";
        errorContainer.style.fontFamily = "Arial, sans-serif";
    } else {
        errorContainer.textContent = ""; // Limpiar el mensaje de error si todos los campos están completos y las contraseñas coinciden
    }
}
    </script>

    <script>
$(document).ready(function() {
    $('#addClient').click(function(){
      $("#inNombre").val("");
      $("#inEmail").val("");
      $("#inPhone").val("");
      $("#inDireccion").val("");
    });
    $('#btnAddExPer').click(function(){
      $("#inNombre").val("");
      $("#inEmail").val("");
      $("#inPhone").val("");
      $("#inDireccion").val("");
    });
    
    // Agregar un evento de clic al botón "AGREGAR USUARIO"
    $("#btnAddPersonal").click(function() {
        // Obtener los valores de los campos del formulario en el modal
        var nombre = $("#inNombre").val();
        var email = $("#inEmail").val();
        var phone = $("#inPhone").val();
        var direccion = $("#inDireccion").val();

        // Realizar la solicitud AJAX
        $.ajax({
            url: "acciones/addUser.php", // Cambia esto por la URL de tu archivo PHP para procesar la inserción
            type: "POST",
            data: {
                nombre: nombre,
                email: email,
                phone: phone,
                direccion: direccion
            },
            success: function(response) {
                var data = JSON.parse(response);
                if(!data.success){
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            showConfirmButton: true
                        }).then(() => {
                                        $("#modalAddClient").modal("hide");
                                        location.reload();
                                    });
                     } else{             
                // Por ejemplo, mostrar un mensaje de éxito o actualizar la tabla de facturas
                
                //alert("Usuario agregado correctamente.");
            Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: data.message,
            showConfirmButton: true
            //timer: 10000
                      }).then(() => {
                                        $("#modalAddClient").modal("hide");
                                        location.reload();
                                    });

                                }
                
            },
            error: function(xhr, status, error) {
                // Manejar errores de la solicitud AJAX si es necesario
                console.error(xhr.responseText);
                
            }
        });
    });
});
</script>



    <script>
var inputValue = '';

// Escuchar el evento input en el campo #pagoAdd
$('#productoCosto').on('input', function() {
  // Remover caracteres no numéricos, excepto el punto decimal
  inputValue = this.value.replace(/[^\d.]/g, '');

  // Actualizar el campo con el valor formateado
  this.value = inputValue;
});

// Escuchar el evento keydown en el campo #pagoAdd
$('#productoCosto').on('keydown', function(e) {
  if (e.key === 'Enter') {
    e.preventDefault(); // Evitar que se procese la tecla Enter normalmente

    // Agregar .00 a la entrada si no contiene ya un punto decimal
    if (!inputValue.includes('.')) {
      inputValue += '.00';
      this.value = inputValue; // Actualizar el valor del campo
    }

  }
});
</script>


<script>
    // Función para cerrar el modal y recargar la página
    $('#cancelButton').click(function() {
        $('#facturaModal').modal('hide'); // Cierra el modal
        location.reload(); // Recarga la página
    });
    $('#btn_canc').click(function(){
      $('#productoDescripcion').val('');
      $('#productoCosto').val('');
    });

    // Array para almacenar los productos en la factura modal
    var productosFactura = [];

    // Manejar el evento de agregar producto a la factura modal

    $('#guardarProducto').click(function() {

      var productoFactura = {};
      productoFactura.descripcion = $('#productoDescripcion').val();
      productoFactura.costo = parseFloat($('#productoCosto').val());
      


      // Validar que la descripción y el costo no estén vacíos
      if (!productoFactura.descripcion || isNaN(productoFactura.costo) || productoFactura.costo <= 0) {
        alert('Por favor, ingrese una descripción válida y un costo mayor que cero.');
        return;
      }

      // Agregar el producto a la factura modal
      productosFactura.push(productoFactura);

      // Agregar fila al formulario para mostrar el producto en la factura modal
      var $table = $('#productos table');
  if ($table.length === 0) {
    // Si no existe, crea la tabla y sus encabezados
    $table = $('<table class="table">' +
              '  <thead>' +
              '    <tr>' +
              '      <th>Descripción</th>' +
              '      <th>Precio</th>' +
              '      <th>Accion</th>' +
              '    </tr>' +
              '  </thead>' +
              '  <tbody>' +
              '  </tbody>' +
              '</table>');
    $('#productos').append($table);
   
}

// Agrega cada producto como una fila en la tabla
// Agrega cada producto como una fila en la tabla
$table.find('tbody').append('<tr>' +
                            '  <td>' + productoFactura.descripcion + '</td>' +
                            '  <td>' + productoFactura.costo.toFixed(2) + '</td>' +
                            '  <td><button class="btn btn-danger btn-sm eliminar-producto">Eliminar</button></td>' + 
                            '</tr>');

      $('#productoDescripcion').val('');
      $('#productoCosto').val('');
     $('#productoModalL').modal('hide');
    // Limpia los campos del nuevo modal si es necesario
    $('#productoDescripcion').val('');
    $('#productoCosto').val('');

    });

// calc toto
function calcularTotal() {
  var total = 0;
  for (var i = 0; i < productosFactura.length; i++) {
    total += productosFactura[i].costo;
  }
  var pagoAddValue = parseFloat($('#pagoAdd').val()) || 0;
  var totalTt = total - pagoAddValue;
  $('#total').val(total.toFixed(2));
  //var totFormateado = '$' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
  //document.getElementById('total').value = totFormateado;
  $('#totalT').val(totalTt.toFixed(2));
 // var totTFormateado = '$' + totalTt.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
  //document.getElementById('totalT').value = totTFormateado;
}

var inputValue = '';

// Escuchar el evento input en el campo #pagoAdd
$('#pagoAdd').on('input', function() {
  // Remover caracteres no numéricos, excepto el punto decimal
  inputValue = this.value.replace(/[^\d.]/g, '');

  // Actualizar el campo con el valor formateado
  this.value = inputValue;
});

// Escuchar el evento keydown en el campo #pagoAdd
$('#pagoAdd').on('keydown', function(e) {
  if (e.key === 'Enter') {
    e.preventDefault(); // Evitar que se procese la tecla Enter normalmente

    // Agregar .00 a la entrada si no contiene ya un punto decimal
    if (!inputValue.includes('.')) {
      inputValue += '.00';
      this.value = inputValue; // Actualizar el valor del campo
    }

    // Formatear el valor como un número float
    var floatValue = parseFloat(inputValue) || 0;

    // Calcular el totalT en tiempo real
    var totalActual = parseFloat($('#total').val()) || 0;
    var totalTt = totalActual - floatValue;

    if (floatValue > totalActual) {
      // El pago ingresado es mayor que el total actual
      alert('El pago no puede ser mayor que el total de la factura.');
      this.value = ''; // Limpiar el valor del pagoAdd
    } else {
      // Actualizar el totalT
      $('#totalT').val(totalTt.toFixed(2));
    }
  }
});





// PRUEBA




// Manejar el evento de clic en el botón guardarProducto
$('#guardarProducto').click(function() {
  calcularTotal();
  // Realizar aquí cualquier otra lógica necesaria al hacer clic en el botón
});
    // Manejar el evento de generar la factura

  $('#facturaModal').on('shown.bs.modal', function() {
  // Limpiar los campos que deben estar vacíos al abrir el modal
  $('#pagoAdd').val('');
  $('#total').val('');
  $('#totalT').val('');
});
$('#facturaModal').on('hidden.bs.modal', function() {
  // Ocultar la tabla de productos al cerrar el modal
  $('#productos').hide();

  // Eliminar todas las filas de la tabla
  $('#productos table tbody').empty();
});


  </script>
<script>
  
// Manejar el evento de clic en el botón "Eliminar"
$(document).on('click', '.eliminar-producto', function() {
    var rowIndex = $(this).closest('tr').index(); // Obtener el índice de la fila
    productosFactura.splice(rowIndex, 1); // Eliminar el producto del array

    // Eliminar la fila de la tabla
    $(this).closest('tr').remove();

    // Recalcular el total después de eliminar un producto
    calcularTotal();
});

</script>


<script>
    $('#editModal').on('show.bs.modal',function(event)
            {                
                
                var button = $(event.relatedTarget)
                var id1 = button.data('id')
                var nombre1 = button.data('nombre')
                var email1 = button.data('email')
                var phone1 = button.data('phone')
                var addres1 = button.data('addres')

                var modal = $(this)
                modal.find('#editUserId').val(id1)
                modal.find('#editNombre').val(nombre1)
                modal.find('#editEmail').val(email1)
                modal.find('#editPhone').val(phone1)
                modal.find('#editDireccion').val(addres1)	
            });

    $('#facturaModal').on('show.bs.modal',function(event)
            {                
                
                var button = $(event.relatedTarget)
                var id2 = button.data('id')
                var nombre2 = button.data('nombre')
                var email2 = button.data('email')
                var phone2 = button.data('phone')
                var addres2 = button.data('addres')

                var modal = $(this)
                modal.find('#UserId').val(id2)
                modal.find('#clienteNombre').val(nombre2)
                modal.find('#clienteEmail').val(email2)
                modal.find('#clientePhone').val(phone2)
                modal.find('#clienteAddres').val(addres2)	
            });
             /*ELIMINAR PERSONAL*/
             $("#btnDelPersonal").click(function() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará al usuario de forma permanente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar la solicitud AJAX para eliminar al usuario
            $.ajax({
                url: 'acciones/ajax_func.php',
                type: 'POST',
                data: { dat_op: 3, del_personal: $("#editUserId").val() },
                dataType: 'json',
                success: function(response) {
                    
                    if (response.success) {
                        // Mostrar SweetAlert de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario eliminado',
                            text: response.message,
                            showConfirmButton: true,
                        }).then(() => {
                            // Recargar la página u otra acción necesaria
                            location.reload();
                        });
                    } else {
                        // Mostrar SweetAlert de error si la eliminación falló
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la solicitud AJAX si es necesario
                    console.error(xhr.responseText);
                }
            });
        }
    });
});



            /*ACTUALIZAR PERSONAL*/
            $("#btnUpdPersonal").click(function()
            {
                $.ajax({
                    url: 'acciones/ajax_func.php',
                    type: 'POST',
                    data: {dat_op:2,
                    dat_id: $("#editUserId").val(),
                    dat_nombre: $("#editNombre").val(),
                    dat_email: $("#editEmail").val(),
                    dat_phone: $("#editPhone").val(),
                    dat_addres: $("#editDireccion").val(),
                    },
                    success: function(response) 
                    {
                        
                        var data = JSON.parse(response);
                        if (!data.success) {
                            Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                        // Mostrar SweetAlert de éxito
                        
                    } else {
                        // Mostrar SweetAlert de error si la eliminación falló
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario actualizado',
                            text: response.message,
                            showConfirmButton: true,
                        }).then(() => {
                            // Recargar la página u otra acción necesaria
                            location.reload();
                        });
                    }
                        
                        
                    }
                });
            });
</script>



<script>
    $(document).ready(function() {
        // Al cargar la página, verifica el valor inicial del select
        toggleSearchField();

        // Maneja el evento de cambio en el select
        $('#searchType').change(function() {
            toggleSearchField();
        });

        // Maneja el evento de escritura en el campo de búsqueda
        $('#search').on('input', function() {
            if ($('#searchType').val() === 'name' || $('#searchType').val() === 'email') {
                performRealTimeSearch(); // Realiza la búsqueda en tiempo real
            }
        });

        function toggleSearchField() {
            var searchType = $('#searchType').val();
            if (searchType === 'name' || searchType === 'email') {
                $('#searchContainer').show(); // Muestra el contenedor del campo de búsqueda
            } else {
                $('#searchContainer').hide(); // Oculta el contenedor del campo de búsqueda
                $('#search').val(''); // Limpia el campo de texto
                performRealTimeSearch(); // Realiza la búsqueda en tiempo real para mostrar todos los usuarios
            }
        }

        function performRealTimeSearch() {
            var searchType = $('#searchType').val();
            var searchValue = $('#search').val();

            $.ajax({
                type: 'GET',
                url: 'ajax_search.php', // Ruta del archivo PHP que manejará la búsqueda en tiempo real
                data: {
                    searchType: searchType,
                    searchValue: searchValue
                },
                success: function(response) {
                    // Actualiza la lista de usuarios en la página con la respuesta del servidor
                    $('#userList').html(response);
                }
            });
        }
    });
</script>
<script>
 $(document).ready(function() {
  // Maneja el evento de clic en "Generar Factura"
  $('#generarFactura').click(function() {
    // Recopila los datos del formulario/modal
    var clienteId = $('#UserId').val();
    
    var clienteNombre = $('#clienteNombre').val();
    var clienteEmail = $('#clienteEmail').val();
    var clientePhone = $('#clientePhone').val();
    var clienteAddres = $('#clienteAddres').val();
    
    // Recopila los datos de la tabla (descripción y precio)
    var productos = [];
$('#productos tbody tr').each(function() {
  var descripcion = $(this).find('td:eq(0)').text(); // La primera celda (índice 0) contiene la descripción
  var precio = $(this).find('td:eq(1)').text(); // La segunda celda (índice 1) contiene el precio

  // Agrega el producto al arreglo de productos
  productos.push({ descripcion: descripcion, precio: precio });
});

    

    var clienteTotal = $('#total').val();
    var clienteAdd= $('#pagoAdd').val(); 
    if (clienteAdd === '') {
  clienteAdd = '0.00';
} 
    var clienteTot= $('#totalT').val(); 
    // ... Obtén otros datos necesarios aquí ...

    // Crea un objeto con todos los datos a enviar
    var dataToSend = {
      clienteId: clienteId,
      clienteNombre: clienteNombre,
      clienteEmail: clienteEmail,
      clientePhone: clientePhone,
      clienteAddres: clienteAddres,
      productos: productos,
      clienteTotal: clienteTotal,
      clienteAdd: clienteAdd,
      clienteTot: clienteTot // Agrega los datos de la tabla aquí
      // ... Agrega otros datos aquí ...
    };

    // Realiza la solicitud Ajax
    $.ajax({
      type: 'POST',
      url: 'generarPDF.php',
      data: dataToSend,
      dataType: 'json',
      success: function(response) {
        
        if (response.success) {
          // La generación de PDF fue exitosa
          
          $('#facturaModal').modal('hide');
          //alert('PDF generado con éxito. Puedes enviarlo por correo o hacer lo que desees.');
          Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'PDF generado con éxito.', // Reemplaza 'Tu mensaje personalizado aquí' con el texto que desees mostrar
                        showConfirmButton: true,
                        confirmButtonText: 'Sí, continuar',
                        cancelButtonText: 'Cancelar'
                        //timer: 2500
                    }).then((result) => {
    if (result.isConfirmed) {
        // Aquí puedes ejecutar la acción que deseas realizar cuando el usuario confirma
        window.open('http://localhost/mi/pdfs/' + response.nombreArchivo, '_blank');
                setTimeout(function() {
        location.reload();
      }, 1000); // 2000 milisegundos = 2 segundos
    }});


                // Abre el archivo PDF en una nueva ventana o pestaña
                

        } else {
          // Hubo un error en la generación de PDF
          alert('Error al generar el PDF. Inténtalo de nuevo.');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error en la solicitud AJAX:', error);
      }
    });
  });
});

</script>




<script>
    $('#pdfPreview').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var rutapdf = button.data('ruta');
        var modal = $(this);

        // Actualizar el atributo href del enlace de descarga del PDF
        var pdfDownloadLink = modal.find('#pdfDownloadLink');
        pdfDownloadLink.attr('href', 'pdfs/' + rutapdf);

        // Actualizar el src del elemento <embed> para mostrar el PDF
        var pdfEmbed = modal.find('embed');
        pdfEmbed.attr('src', 'pdfs/' + rutapdf);
    });
</script>

<script>
    $(document).ready(function () {
        // Al cargar la página, verifica el valor inicial del select
        toggleSearchField();

        // Maneja el evento de cambio en el select
        $('#nuevaSearchType').change(function () {
            toggleSearchField();
        });

        // Maneja el evento de escritura en el campo de búsqueda
        $('#nuevaSearch').on('input', function () {
            if ($('#nuevaSearchType').val() === 'namee') {
                performRealTimeSearch(); // Realiza la búsqueda en tiempo real
            }
        });

        // Maneja el evento de cambio en el campo de búsqueda por fecha
        $('#nuevaSearchDate').on('change', function () {
            if ($('#nuevaSearchType').val() === 'date') {
                performRealTimeSearch(); // Realiza la búsqueda en tiempo real cuando cambia la fecha
            }
        });

        function toggleSearchField() {
            var searchTypen = $('#nuevaSearchType').val();

            // Oculta ambos campos por defecto
            $('#searchContainern').hide();
            $('#searchContainerF').hide();

            if (searchTypen === 'namee') {
                $('#searchContainern').show(); // Muestra el contenedor del campo de búsqueda por nombre
            } else if (searchTypen === 'date') {
                $('#searchContainerF').show(); // Muestra el contenedor del campo de búsqueda por fecha
            } else {
                // Realiza otras acciones o muestra todos los usuarios si es necesario
                performRealTimeSearch();
            }
        }

        function performRealTimeSearch() {
            var searchTypen = $('#nuevaSearchType').val();
            var searchValuen = '';

            if (searchTypen === 'namee') {
                searchValuen = $('#nuevaSearch').val();
            } else if (searchTypen === 'date') {
                searchValuen = $('#nuevaSearchDate').val();
            }

            $.ajax({
                type: 'GET',
                url: 'buscarFacturasAjax.php', // Ruta del archivo PHP que manejará la búsqueda en tiempo real
                data: {
                    searchTypen: searchTypen,
                    searchValuen: searchValuen
                },
                success: function (response) {
                    // Actualiza la lista de usuarios en la página con la respuesta del servidor
                    $('#factList').html(response);
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function () {
       $(document).on('click', '.email-btn', function () {
            var id = $(this).data('id1');
            var nombre = $(this).data('nombre');
            var email = $(this).data('email');
            var emision = $(this).data('emision');
            var rutaPDF = $(this).data('ruta1');

            $.ajax({
                type: 'POST',
                url: 'acciones/enviar_email.php', // Ruta al archivo PHP en el servidor
                data: {
                    id: id,
                    nombre: nombre,
                    email: email,
                    emision: emision,
                    rutaPDF: rutaPDF
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.success) {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: data.message,
            showConfirmButton: false,
            //timer: 2500
        });
        //$('#errorCont').html(data.message).addClass('success-message');
       
    } else {
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: data.message
        });
        //$('#errorCont').html(data.message).addClass('error-message');
       
    }
                    // Muestra el mensaje de éxito
                    //alert(response);
                }//,
               // error: function () {
                    // Muestra un mensaje de error si ocurre algún problema
                  //  alert('Error al enviar el correo electrónico');
                //}
            });
        });
    });
</script>

<script>
    
    $('#add_pos').click(function(){
      $('#postTitle').val('');
      $('#postContent').val('');
      $('#postImage').val('');
    });

    $('#btnAddExPost').click(function(){
      $('#postTitle').val('');
      $('#postContent').val('');
      $('#postImage').val('');
    });

   $("#btnAddPost").click(function()
            {


                var postTitle = $("#postTitle").val();
                var postContent = $("#postContent").val();
                var postImage = $("#postImage")[0].files[0];
            
                var formData = new FormData();
                    formData.append('postTitle', postTitle);
                    formData.append('postContent', postContent);
                    formData.append('postImage', $('#postImage')[0].files[0]); 

            $.ajax({
                type: 'POST',
                url: 'acciones/guardar_post.php', // Ruta al archivo PHP en el servidor
                data: formData,
                contentType: false, // Importante: no configurar contentType
                processData: false,
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message,
                            //showConfirmButton: true,
                            //timer: 2500
                        }).then(() => {
                            // Recargar la página u otra acción necesaria
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: data.message
                            //showConfirmButton: true,
                        });
                    }

                },

            });
        });

</script>

<script>
    $(document).ready(function() {
        $('.tabla-posts').DataTable({
           
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
            }
        });
    
});
</script>


<script>

$('.delete-post').click(function() {
  // Obtener el ID del post desde el atributo data
  var postId = $(this).data('post-id');

  Swal.fire({
      title: '¿Estás seguro?',
      text: 'Esta acción eliminará el post de forma permanente.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
  }).then((result) => {
      if (result.isConfirmed) {
          // Realizar la solicitud AJAX para eliminar al usuario
          $.ajax({
            type: 'POST',
            url: 'acciones/eliminar_post.php', // Ruta al archivo PHP para eliminar el post
            data: { postId: postId },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        //showConfirmButton: true,
                        //timer: 2500
                    }).then(() => {
                        // Recargar la página u otra acción necesaria
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: data.message
                        //showConfirmButton: true,
                    });
                }
            },
            error: function(xhr, status, error) {
                // Manejar errores si es necesario
                console.error(xhr.responseText);
            }
        });
      }
  });
});


</script>

<script>
    $('#updateModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var postId = button.data('post-id');
    var postTitle = button.data('post-title');
    var postContent = button.data('post-content');
    var postImage = button.data('post-image');

    var modal = $(this);
    modal.find('#postId').val(postId);
    modal.find('#postTitle').val(postTitle);
    modal.find('#postContent').val(postContent);
    //modal.find('#postImage').val(postImage);
});

/*ACTUALIZAR POST*/
$("#btnUpdPersonal").click(function()
            {   var postId = $("#postId").val();
                var postTitle = $("#postTitle").val();
                var postContent = $("#postContent").val();
                var postImage = $("#postImage")[0].files[0];
            
                var formData = new FormData();
                    formData.append('postTitle', postTitle);
                    formData.append('postContent', postContent);
                    formData.append('postImage', $('#postImage')[0].files[0]); 

                $.ajax({
                    url: 'acciones/ajax_func.php',
                    type: 'POST',
                    data: {dat_op:1,formData
                    },
                    success: function(response) 
                    {
                        var data = JSON.parse(response);
                        if (!data.success) {
                            Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                        // Mostrar SweetAlert de éxito
                        
                    } else {
                        // Mostrar SweetAlert de error si la eliminación falló
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario actualizado',
                            text: response.message,
                            showConfirmButton: true,
                        }).then(() => {
                            // Recargar la página u otra acción necesaria
                            location.reload();
                        });
                    }
                        
                        
                    }
                });
            });
</script>
</body>

</html>