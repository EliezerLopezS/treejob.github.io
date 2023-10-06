<?php
include 'acciones/facturas.php';

$nuevaSearchType = isset($_GET['nuevaSearchType']) ? $_GET['nuevaSearchType'] : 'all';
$nuevaSearch = isset($_GET['nuevaSearch']) ? $_GET['nuevaSearch'] : '';

$nuevoTotalFacts = getNuevaTotalFacts($nuevaSearch, $nuevaSearchType);
$nuevosFacts = getNuevosFacts($nuevaSearch, $nuevaSearchType);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD con Búsqueda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
</head>
<body>
    <div class="container">
        <h1>Facturas</h1>
        <form method="GET">
            <div class="form-row">
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control" name="nuevaSearchType" id="nuevaSearchType">
                        
                            <option value="all" <?php if ($nuevaSearchType === 'all') echo 'selected';?>>Mostrar todos</option>
                            <option value="namee" <?php if ($nuevaSearchType === 'namee') echo 'selected'; ?>>Buscar por Nombre</option>
                            <option value="date" <?php if ($nuevaSearchType === 'date') echo 'selected'; ?>>Buscar por Fecha</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" id="searchContainern" style="display: none;">
                        <input type="text" class="form-control" name="nuevaSearch" id="nuevaSearch" placeholder="Buscar" value="<?php echo $nuevaSearch; ?>">
                    </div>
                </div>
                <!-- Nuevo campo de búsqueda por fecha -->
                <div class="col-md-3">
                    <div class="form-group" id="searchContainerF" style="display: none;">
                        <input type="date" class="form-control" name="nuevaSearchDate" id="nuevaSearchDate">
                    </div>
                </div>
            </div>
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
                        <?php foreach($nuevosFacts as $fact) { ?>
                            <tr>
                                <td><?php echo $fact['id']; ?></td>
                                <td><?php echo $fact['clienteNombre']; ?></td>
                                <td><?php echo $fact['email']; ?></td>
                                <td><?php echo $fact['fechaEmision']; ?></td>
                                <td><?php echo basename($fact['rutaPDF']); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn pdf-preview-btn" data-bs-toggle="modal" data-bs-target="#pdfPreview" data-id="<?php echo $fact['id']; ?>" data-ruta="<?php echo basename($fact['rutaPDF']); ?>">
                                        <i class="fa fa-file-pdf"></i> | <i class="fas fa-arrow-down"></i> 
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm email-btn"  data-bs-toggle="modal" data-bs-target="#facturaModal"
                                    data-id="<?php echo $fact['id']; ?>" data-nombre="<?php echo $fact['clienteNombre']; ?>" data-email="<?php echo $fact['email']; ?>"
                                    data-emision="<?php echo $fact['fechaEmision']; ?>" data-ruta="<?php echo basename($fact['rutaPDF']); ?>">
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
    // Tu código aquí...

            console.log('Botón clickeado'); // Agrega esta línea
            var id = $(this).data('id');
            var nombre = $(this).data('nombre');
            var email = $(this).data('email');
            var emision = $(this).data('emision');
            var rutaPDF = $(this).data('ruta');

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
                    // Muestra el mensaje de éxito
                    alert(response);
                },
                error: function () {
                    // Muestra un mensaje de error si ocurre algún problema
                    alert('Error al enviar el correo electrónico');
                }
            });
        });
    });
</script>

</body>
</html>
