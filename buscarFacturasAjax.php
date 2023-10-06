<?php
include 'acciones/facturas.php';

$searchType = $_GET['searchTypen'];
$searchValue = $_GET['searchValuen'];

$nuevosFacts = getNuevosFacts($searchValue, $searchType);

// Genera el HTML de la lista de usuarios actualizada
foreach ($nuevosFacts as $fact) {
    echo '<tr>';
    echo '<td>' . $fact['id'] . '</td>';
    echo '<td>' . $fact['clienteNombre'] . '</td>';
    echo '<td>' . $fact['email'] . '</td>';
    echo '<td>' . $fact['fechaEmision'] . '</td>';
    echo '<td>' . basename($fact['rutaPDF']) . '</td>';

    

    
    
    
    
                                                                                                                                
    echo '<td>';
    // Reemplaza esto con la forma en que obtienes la ID de la factura si es diferente
    echo '<button class="btn btn-warning btn-sm edit-btn pdf-preview-btn" data-toggle="modal" data-target="#pdfPreview" data-id="' . $fact['id'] . '" data-ruta="' . basename($fact['rutaPDF']) . '">
     <i class="fa fa-file-pdf"></i> | <i class="fas fa-arrow-down"></i> Vista Previa y Descargar
</button>';


    //echo '<button class="btn btn-warning btn-sm edit-btn" data-id="' . $user['id'] . '" data-toggle="modal" data-target="#editModal">';
    //echo '<i class="bi bi-pencil"></i> Editar';
    //echo '</button>';
   // echo '<button class="btn btn-danger btn-sm delete-btn" data-id="' . $user['id'] . '">';
    //echo '<i class="bi bi-trash"></i> Eliminar';
    //echo '</button>';
    echo '</td>';
    echo '<td>';
    echo '<button class="btn btn-danger btn-sm email-btn" 
    data-id1="' . $fact['id'] . '" data-nombre="' . $fact['clienteNombre'] . '" data-email="' . $fact['email'] . '"
    data-emision="' . $fact['fechaEmision'] . '" data-ruta1="' . basename($fact['rutaPDF']) . '">
    <i class="fas fa-file-invoice"></i>
    </button>';


    echo '</td>';
    echo '</tr>';
}
?>
