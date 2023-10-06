<?php
include './seguridad/conn_mysql.php';

function getUsers($search = "", $searchType = "all") {
    global $conn;

    // Agrega manejo de errores aquí
    $query = "SELECT * FROM clientes WHERE 1=1";

    if ($searchType === 'name') {
        $query .= " AND nombre LIKE '%$search%'";
    } elseif ($searchType === 'email') {
        $query .= " AND email LIKE '%$search%'";
    }

    $result = $conn->query($query);
    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

function getTotalUsers($search = "") {
    global $conn;
    $query = "SELECT COUNT(*) as total FROM clientes WHERE nombre LIKE '%$search%'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}
?>

<!--?php
include './seguridad/conn_mysql.php';

function getUsers($search = "", $searchType = "all", $page = 1, $perPage = 10) {
    global $conn;
    $offset = ($page - 1) * $perPage;

    // Agrega manejo de errores aquí
    $query = "SELECT * FROM usuarios WHERE 1=1";

    if ($searchType === 'name') {
        $query .= " AND nombre LIKE '%$search%'";
    } elseif ($searchType === 'email') {
        $query .= " AND email LIKE '%$search%'";
    }

    $query .= " LIMIT $offset, $perPage";

    $result = $conn->query($query);
    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

/*
function getUsers($search = "", $page = 1, $perPage = 10) {
    global $conn;
    $offset = ($page - 1) * $perPage;
    $query = "SELECT * FROM usuarios WHERE nombre LIKE '%$search%' LIMIT $offset, $perPage";
    $result = $conn->query($query);
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}
*/
function getTotalUsers($search = "") {
    global $conn;
    $query = "SELECT COUNT(*) as total FROM usuarios WHERE nombre LIKE '%$search%'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}
?-->
