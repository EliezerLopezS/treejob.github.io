<?php
	date_default_timezone_set('GMT');
	date_default_timezone_set('America/Mexico_City');
require_once('TCPDF-main/INVOICE-main/code128.php');
include 'seguridad/conn_mysql.php';

$clienteNombre = $_POST['clienteNombre'];
$clienteEmail = $_POST['clienteEmail'];
$clientePhone = $_POST['clientePhone'];
$clienteAddres = $_POST['clienteAddres'];
$productos = $_POST['productos']; // Aquí deberías obtener los detalles de los productos desde tu formulario
$total = $_POST['clienteTotal'];
$pagoAdd = $_POST['clienteAdd'];
$totalT = $_POST['clienteTot'];

$pdf = new PDF_Code128('P','mm','Letter');
	$pdf->SetMargins(17,17,17);
	$pdf->AddPage();

	# Logo de la empresa formato png #
	$pdf->Image('assets/img/log.png',155,12,43,35,'PNG');

	# Encabezado y datos de la empresa #
	$pdf->SetFont('Arial','B',16);
	$pdf->SetTextColor(0,0,0);
	$pdf->Cell(150,10,utf8_decode(strtoupper("TREE JOB")),0,0,'L');

	$pdf->Ln(10);
    $pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(39,39,51);

	$pdf->Cell(150,9,utf8_decode("ADDRESS: 413 LAUREL AVE LAKEWOOD, NJ 08701"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,utf8_decode("PHONE: 732 363 1935, 848 525 4756"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,9,utf8_decode("Email: fullseasonlawnandlandscape@gmail.com"),0,0,'L');

	$pdf->Ln(10);
    
    $fechaActual = date("d/m/Y h:i A");
    $pdf->Cell(150, 9, utf8_decode("DATE OF ISSUE: " . $fechaActual), 0, 0);
    


	//$pdf->SetTextColor(97,97,97);
	//$pdf->Cell(150,9,utf8_decode(date("d/m/Y", strtotime("13-09-2022"))." ".date("h:s A")),0,0,'L');

    $pdf->Ln(7);
    $pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(39, 39, 51);

// Etiqueta "Client"
$pdf->Cell(15, 7, utf8_decode("CLIENT:"), 0, 0);

// Valor del cliente (Nombre)
$pdf->SetTextColor(97, 97, 97);
$pdf->Cell(45, 7, utf8_decode($clienteNombre), 0, 0);

// Etiqueta "Phone"
$pdf->SetTextColor(39, 39, 51);
$pdf->Cell(15, 7, utf8_decode("PHONE:"), 0, 0);

// Valor del teléfono
$pdf->SetTextColor(97, 97, 97);
$pdf->Cell(35, 7, utf8_decode($clientePhone), 0, 0); // Reducido el ancho de la celda

// Etiqueta "Email"
$pdf->SetTextColor(39, 39, 51);
$pdf->Cell(12, 7, utf8_decode("EMAIL:"), 0, 0);

// Valor del correo electrónico
$pdf->SetTextColor(97, 97, 97);
$pdf->Cell(33, 7, utf8_decode($clienteEmail), 0, 0); // Reducido el ancho de la celda

// Nueva línea para la siguiente información

    

/*
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(13,7,utf8_decode("Client:"),0,0);
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(60,7,utf8_decode($clienteNombre),0,0,'L');
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(13,7,utf8_decode("Phone:"),0,0,'L');
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(60,7,utf8_decode($clientePhone),0,0,'L');
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(12,7,utf8_decode("Email:"),0,0,'L');
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(35,7,utf8_decode($clienteEmail),0,0);
	$pdf->SetTextColor(39,39,51);
*/
	$pdf->Ln(5);

	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(19,7,utf8_decode("ADDRESS:"),0,0);
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(60,7,utf8_decode($clienteAddres),0,0);

	$pdf->Ln(9);
// Configura la posición inicial de la tabla
$y = 66;


// Define los tamaños de las columnas
$columnWidths = array(120, 60); // Descripción y Precio

// Encabezados de la tabla
$pdf->SetXY(17, $y);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(0, 128, 0);

$pdf->SetDrawColor(0, 128, 0);
$pdf->SetTextColor(255, 255, 255);

foreach ($columnWidths as $width) {
    $pdf->Cell($width, 10, '', 'TLR', 0, 'C', true);
}

$pdf->Ln(8);

$pdf->SetXY(17, $y);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell($columnWidths[0], 10, utf8_decode('DESCRIPTION'), 1, 0, 'C', true);
$pdf->Cell($columnWidths[1], 10, utf8_decode('PRICE'), 1, 1, 'C', true);

// Recorre los productos y agrega filas a la tabla
// Recorre los productos y agrega filas a la tabla
foreach ($productos as $producto) {
    $pdf->SetX(17); // Restablece la posición horizontal
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetDrawColor(0, 128, 0);
    $pdf->SetTextColor(39, 39, 51);

    $pdf->Cell($columnWidths[0], 10, utf8_decode($producto['descripcion']), 1, 0, 'L', true);
	$precioFormateado = '$' . number_format($producto['precio'], 2, '.', ',');
	
	$pdf->Cell($columnWidths[1], 10, utf8_decode($precioFormateado), 1, 1, 'C', true);
    //$pdf->Cell($columnWidths[1], 10,'$'. utf8_decode($producto['precio']), 1, 1, 'C', true);

    // Aumenta la posición vertical para la siguiente fila
    $y += 10;
}

$yTotales = $y + 10; // Asegura que estén debajo de la tabla

// Configura la posición inicial de las celdas de totales
$pdf->SetXY(17, $yTotales);

// Define los tamaños de las celdas de totales
$columnWidthsTotales = array(120, 60); // Descripción y Precio

// Celdas de Totales
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(0, 128, 0);

$pdf->SetDrawColor(0, 128, 0);
$pdf->SetTextColor(255, 255, 255);


foreach ($columnWidthsTotales as $width) {
    $pdf->Cell($width, 10, '', 'TLR', 0, 'C', true);
}

$pdf->Ln(8);

$pdf->SetXY(17, $yTotales);
$pdf->SetTextColor(255, 255, 255);

$pdf->Cell($columnWidthsTotales[0], 10, utf8_decode('TOTAL'), 1, 0, 'C', true);
$total = number_format($total, 2, '.', ','); 
$pdf->Cell($columnWidthsTotales[1], 10,'$'. utf8_decode($total), 1, 1, 'C', true);

// Siguiente celda de total
$yTotales += 10;

$pdf->SetXY(17, $yTotales);
$pdf->Cell($columnWidthsTotales[0], 10, utf8_decode('ADVANCED PAYMENT'), 1, 0, 'C', true);
$pagoAdd = number_format($pagoAdd, 2, '.', ','); 
$pdf->Cell($columnWidthsTotales[1], 10,'$'. utf8_decode($pagoAdd), 1, 1, 'C', true);

// Siguiente celda de total por pagar
$yTotales += 10;

$pdf->SetXY(17, $yTotales);
$pdf->Cell($columnWidthsTotales[0], 10, utf8_decode('PAYMENT DUE'), 1, 0, 'C', true);
$totalT = number_format($totalT, 2, '.', ','); 
$pdf->Cell($columnWidthsTotales[1], 10,'$'. utf8_decode($totalT), 1, 1, 'C', true);

$pdf->Ln(8);
$pdf->SetFont('Helvetica', 'B', 14);
$pdf->SetTextColor(0, 0, 0); // Negro
$pdf->Cell(150, 9, utf8_decode("THANK YOU FOR CHOOSING US."), 0, 0, 'L');

/*/ Totales
$pdf->SetXY(10, $y);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(23, 83, 201);
$pdf->SetDrawColor(23, 83, 201);
$pdf->SetTextColor(255, 255, 255);

for ($i = 0; $i < count($columnWidths); $i++) {
    $pdf->Cell($columnWidths[$i], 10, '', 'TLR', 0, 'C', true);
}

$pdf->Ln(10);

$pdf->SetXY(10, $y);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(array_sum($columnWidths), 10, utf8_decode('Total'), 1, 0, 'C', true);
$pdf->Cell(40, 10, $total, 1, 1, 'C');
$pdf->Ln(10);

$pdf->SetXY(10, $y + 10);
$pdf->Cell(array_sum($columnWidths), 10, utf8_decode('Pago adelantado'), 1, 0, 'C', true);
$pdf->Cell(40, 10, $pagoAdd, 1, 1, 'C');
$pdf->Ln(10);

$pdf->SetXY(10, $y + 20);
$pdf->Cell(array_sum($columnWidths), 10, utf8_decode('Total por pagar'), 1, 0, 'C', true);
$pdf->Cell(40, 10, $totalT, 1, 1, 'C');

*/
$nombreArchivo="";
$nombreArchivo = 'factura_' . date('YmdHis') . '.pdf';
    
    $rutaPDF = 'C:/xampp/htdocs/mi/pdfs/'.$nombreArchivo;

	# Nombre del archivo PDF #
	$pdf->Output($rutaPDF, 'F'); 

   /*/ $response = array('success' => true);
   $response="";
	$response = array('success' => true, 'nombreArchivo' => $nombreArchivo);

// Enviar la respuesta como JSON

echo json_encode($response);
*/
if (!$conn) {
    $response = array('success' => false, 'error' => 'Error de conexión a la base de datos');
} else {
    $clienteNombre = mysqli_real_escape_string($conn, $_POST['clienteNombre']);
	$clienteEmail = mysqli_real_escape_string($conn, $_POST['clienteEmail']);
	
    $fechaEmision = date("Y-m-d H:i:s");
    $query = "INSERT INTO facturas (clienteNombre, email, fechaEmision, rutaPDF) VALUES ('$clienteNombre','$clienteEmail', '$fechaEmision', '$rutaPDF')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $response = array('success' => false, 'error' => 'Error al insertar en la base de datos');
    } else {
        $response = array('success' => true, 'nombreArchivo' => $nombreArchivo);
		
		//echo json_encode(array('success' => true, 'message' => 'PDF generado con exito.'));
    }

    mysqli_close($conn);
}

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);

?>