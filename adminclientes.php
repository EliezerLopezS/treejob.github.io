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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>CRUD con Búsqueda y Paginación</title>
      <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <script src="js/sweetalert2.min.js"></script>
      <link rel="stylesheet" href="js/sweetalert2.min.css">
      <script src="jjs/code.jquery.com_jquery-3.6.0.min.js"></script>
      
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
      <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">

      <script src="https://apis.google.com/js/platform.js" async defer></script>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
      
      
      <link src="js/main.js">
      <link src="js/funciones.js">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
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
  <div class="container">
      <form class="form-inline">
          <br>
          <div class="form-group col-md-4">
              <select class="form-control" name="searchType" id="searchType">
                  
                  <option value="all" <?php if ($searchType === 'all') echo 'selected'; ?>>Mostrar todos</option>
                  <option value="name" <?php if ($searchType === 'name') echo 'selected'; ?>>Buscar por Nombre</option>
                  <option value="email" <?php if ($searchType === 'email') echo 'selected'; ?>>Buscar por Correo</option>
              </select>
          </div>
          <div class="form-group col-md-4" style="display: none" id="searchContainer">
              <input type="text" class="form-control" name="search" id="search" placeholder="Buscar" value="<?php echo $search; ?>">
          </div>
          <div class="col-md-12" align="right">
										<button id="ap1" class="btn btn-primary btn_block btn-xs" >
										<i style="width: 16px" class="fa fa-user"></i> 
										Nuevo Personal</button>
                                    </div>
                                    
          <br>
      </form>

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
                          <td><?php echo $user['id']; ?></td>
                          <td><?php echo $user['nombre']; ?></td>
                          <td><?php echo $user['email']; ?></td>
                          <td><?php echo $user['phone']; ?></td>
                          <td>
                              <div class="btn-group">
                                  <button class="btn btn-warning btn-sm edit-btn" data-toggle="modal" data-target="#editModal"
                                      data-id='<?php echo $user['id']; ?>'
                                      data-nombre='<?php echo $user['nombre']; ?>'
                                      data-email='<?php echo $user['email']; ?>'
                                      data-phone='<?php echo $user['phone']; ?>'
                                      data-addres='<?php echo $user['addres']; ?>'>
                                      <i class="fa fa-refresh"></i> | <i class="fa fa-trash"></i>
                                  </button>
                              </div>
                          </td>
                          <td>
                              <div class="btn-group">
                                  <button class="btn btn-primary btn-sm edit-btn" data-toggle="modal" data-target="#facturaModal"
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
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#productoModal" id="agregarProducto">Agregar Producto</button>
              
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
 <div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="productoModalLabel" aria-hidden="true" data-backdrop="static">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
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
            <button type="button" class="btn btn-success" id="guardarProducto">Guardar</button>
            <button type="button" class="btn btn-secondary" id="btn_canc" data-dismiss="modal">Cancelar</button>
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
                <button type="button" id="btnDelPersonal" class="btn btn-danger" id="deleteUserBtn">ELIMINAR USUARIO</button>
                <button type="button" id="btnExiPersonal" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>
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
      $('#productoModal').modal('hide');
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
// Manejar el evento de cambio en el input pagoAdd
/*$('#pagoAdd').on('change', function() {
    var pagoAddValue = parseFloat($('#pagoAdd').val()) || 0; // Convierte a float
    $('#pagoAdd').val(pagoAddValue.toFixed(2)); // Formatea con dos decimales
    calcularTotal(); // Llama a la función para recalcular el total
  });*/


// Manejar el evento de cambio en el input pagoAdd
// Manejar el evento de desenfoque (blur) en el input pagoAdd
/*$('#pagoAdd').on('keydown', function(e) {
  if (e.key === 'Enter') {
    e.preventDefault(); // Evitar que se procese la tecla Enter normalmente
    $('#totalT').focus(); // Reemplaza 'siguienteInput' con el ID del siguiente campo de entrada
  }
});*/

/*$('#pagoAdd').on('change', function() {
  var pagoAddValue = parseFloat($('#pagoAdd').val()) || 0; // Convierte a float
  var totalActual = parseFloat($('#total').val()) || 0; // Convierte a float
  
  var totalTt = totalActual - pagoAddValue;
  
  if (pagoAddValue > totalActual) {
    // El pago ingresado es mayor que el total actual
    alert('El pago no puede ser mayor que el total de la factura.');
    $('#pagoAdd').val(''); // Limpiar el valor del pagoAdd
  } else {
    $('#totalT').val(totalTt.toFixed(2)); // Actualizar el totalT
  }
});*/
// Variable para almacenar el valor actual del campo
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
             $("#btnDelPersonal").click(function()
            {
                $.ajax({
                    url: 'acciones/ajax_func.php',
                    type: 'POST',
                    data: {dat_op:3,del_personal: $("#editUserId").val()},
                    beforeSend: function()
                    {
                        $("#load_ajax_mPersonal").html("<img src='assets/imag/gif-load (1).gif'><br>...Enviando Datos...");
                        $("#btnUpdPersonal").hide();
                        $("#btnDelPersonal").hide();
                        $("#btnExiPersonal").hide();
                    },
                    success: function(datos) 
                    {
                        $("#load_ajax_mPersonal").html(datos);
                        $("#btnUpdPersonal").show();
                        $("#btnDelPersonal").show();
                        $("#btnExiPersonal").show();						
						$('#modPersonal').modal('hide');
                        location.reload();
                    },
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
                    beforeSend: function()
                    {
                        $("#load_ajax_mPersonal").html("<img src='assets/img/gif-load (1).gif'><br>...Enviando Datos...");
                        $("#btnUpdPersonal").hide();
                        $("#btnDelPersonal").hide();
                        $("#btnExiPersonal").hide();
                    },
                    success: function(datos) 
                    {
                        $("#load_ajax_mPersonal").html(datos);
                        $("#btnUpdPersonal").show();
                        $("#btnDelPersonal").show();
                        $("#btnExiPersonal").show();
                        //$("#searchType").load("adminclientes.php");
                        location.reload();
                    },
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
          alert('PDF generado con éxito. Puedes enviarlo por correo o hacer lo que desees.');

                // Abre el archivo PDF en una nueva ventana o pestaña
                window.open('http://localhost/mi/pdfs/' + response.nombreArchivo, '_blank');
                setTimeout(function() {
        location.reload();
      }, 1000); // 2000 milisegundos = 2 segundos

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
</body>
</html>
