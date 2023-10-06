<?php
include 'acciones/users.php';

$searchType = $_GET['searchType'];
$searchValue = $_GET['searchValue'];

$users = getUsers($searchValue, $searchType);

// Genera el HTML de la lista de usuarios actualizada
foreach ($users as $user) {
    echo '<tr>';
    echo '<td>' . $user['id'] . '</td>';
    echo '<td>' . $user['nombre'] . '</td>';
    echo '<td>' . $user['email'] . '</td>';
    echo '<td>' . $user['phone'] . '</td>';
    
    
    
    
    
    
    echo '<td>';
    echo '<button class="btn btn-warning btn-sm edit-btn" data-id="' . $user['id'] . '" data-nombre="' . $user['nombre'] . '" data-email="' . $user['email'] . '" data-phone="' . $user['phone'] . '" data-addres="' . $user['addres'] . '" data-toggle="modal" data-target="#editModal">';

    echo '<i class="fa fa-refresh"></i> | <i class="fa fa-trash"></i>';
    echo '</button>';
    //echo '<button class="btn btn-warning btn-sm edit-btn" data-id="' . $user['id'] . '" data-toggle="modal" data-target="#editModal">';
    //echo '<i class="bi bi-pencil"></i> Editar';
    //echo '</button>';
   // echo '<button class="btn btn-danger btn-sm delete-btn" data-id="' . $user['id'] . '">';
    //echo '<i class="bi bi-trash"></i> Eliminar';
    //echo '</button>';
    echo '</td>';
    echo '<td>';
echo '<button class="btn btn-primary btn-sm edit-btn" data-toggle="modal" data-target="#facturaModal" data-id="' . $user['id'] . '" data-nombre="' . $user['nombre'] . '" data-email="' . $user['email'] . '" data-phone="' . $user['phone'] . '" data-addres="' . $user['addres'] . '">';
    echo '<i class="fas fa-file-invoice"></i>';
    echo '</button>';
    echo '</td>';
    echo '</tr>';
}

?>
