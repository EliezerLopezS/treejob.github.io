<?php
include './seguridad/conn_mysql.php';

function getNuevosFacts($nuevaSearch = "", $nuevaSearchType = "all") {
    global $conn;

    // Agrega manejo de errores aquí
    $query = "SELECT * FROM facturas WHERE 1=1";

    if ($nuevaSearchType === 'namee') {
        $query .= " AND clienteNombre LIKE '%$nuevaSearch%'";
    } 
    elseif ($nuevaSearchType === 'date') {
        $query .= " AND fechaEmision LIKE '%$nuevaSearch%'";
    }

    $result = $conn->query($query);
    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $nuevosFacts = [];
    while ($row = $result->fetch_assoc()) {
        $nuevosFacts[] = $row;
    }
    return $nuevosFacts;
}

function getNuevaTotalFacts($nuevaSearch = "") {
    global $conn;
    $query = "SELECT COUNT(*) as total FROM facturas WHERE clienteNombre LIKE '%$nuevaSearch%'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}
?>
