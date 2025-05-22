<?php
session_start();
require_once "../conexion.php";
require('../fpdf/fpdf.php'); // Asegúrate de que la ruta sea correcta

if (isset($_GET['id'])) {
    $id_pedido = mysqli_real_escape_string($conexion, $_GET['id']);

    // Obtener los detalles del pedido
    $query = mysqli_query($conexion, "
        SELECT dp.*, p.nombre AS producto 
        FROM detalle_pedidos dp 
        INNER JOIN platos p ON dp.nombre = p.nombre 
        WHERE dp.id_pedido = '$id_pedido'
    ");
    
    // Obtener información adicional del pedido, incluyendo el usuario que lo realizó
    $pedido_info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM pedidos WHERE id = '$id_pedido'"));
    $id_usuario = $pedido_info['id_usuario']; // ID del usuario que realizó el pedido
    $nombre_usuario = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre FROM usuarios WHERE id = '$id_usuario'"))['nombre'];
    
    // Obtener información de la sala y mesa
    $id_sala = $pedido_info['id_sala'];
    $num_mesa = $pedido_info['num_mesa'];

    // Obtener el nombre de la sede usando el ID de sala
    $nombre_sede = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre FROM salas WHERE id = '$id_sala'"))['nombre'];

    // Obtener la dirección de la tabla config
    $direccion_info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT direccion, telefono, email FROM config WHERE id = 1"));
    $direccion = $direccion_info['direccion']; // Dirección obtenida
    $telefono = $direccion_info['telefono']; // Teléfono obtenido
    $email = $direccion_info['email']; // Correo electrónico obtenido

    // Crear el objeto FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    
    // Parte superior izquierda
    $pdf->Cell(0, 10, 'CaféBUENISIMO', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Dirección: ' . $direccion, 0, 1);
    $pdf->Cell(0, 10, 'Teléfono: ' . $telefono, 0, 1);
    $pdf->Cell(0, 10, 'Email: ' . $email, 0, 1);
    
    // Parte superior derecha (enmarcada)
    $pdf->SetXY(150, 10);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'BOLETA DE VENTA ELECTRÓNICA', 0, 1, 'R');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'RUC: 10329772825', 0, 1, 'R');
    $pdf->Cell(0, 10, 'Fecha de Emisión: ' . date('d-m-Y'), 0, 1, 'R');
    $pdf->Cell(0, 10, 'Fecha de Vencimiento: -----', 0, 1, 'R');

    // Espacio antes de los datos del cliente
    $pdf->Ln(10);
    
    // Datos del cliente
    $pdf->Cell(0, 10, 'ID usuario: ' . $id_usuario, 0, 1);
    $pdf->Cell(0, 10, 'Señor(es): ' . $nombre_usuario, 0, 1);
    $pdf->Cell(0, 10, 'Sede: ' . $nombre_sede, 0, 1);
    $pdf->Cell(0, 10, 'N° mesa: ' . $num_mesa, 0, 1);
    
    // Espacio adicional
    $pdf->Ln(5);
    
    // Tabla de productos
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Descripción', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(30, 10, 'Unidad Medida', 1);
    $pdf->Cell(30, 10, 'Valor Unitario', 1);
    $pdf->Cell(30, 10, 'Importe de Venta', 1);
    $pdf->Ln();
    
    $total_general = 0; // Inicializa el total general

    while ($row = mysqli_fetch_assoc($query)) {
        $total_producto = $row['cantidad'] * $row['precio'];
        $total_general += $total_producto; // Acumula el total general

        $pdf->Cell(80, 10, $row['producto'], 1);
        $pdf->Cell(30, 10, $row['cantidad'], 1);
        $pdf->Cell(30, 10, 'UNIDAD', 1); // Unidad de medida
        $pdf->Cell(30, 10, number_format($row['precio'], 2), 1);
        $pdf->Cell(30, 10, number_format($total_producto, 2), 1);
        $pdf->Ln();
    }

    // Espacio entre la tabla de productos y los totales
    $pdf->Ln(5); 

    $subtotal = $total_general / 1.18; // Asumimos que el total incluye el IGV
    $igv = $subtotal * 0.18; // Calcular el IGV al 18%
    $importe_total = $subtotal + $igv; // Total

    // Totales
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Subtotal: ' . number_format($subtotal, 2), 0, 1, 'R');
    $pdf->Cell(0, 10, 'IGV (18%): ' . number_format($igv, 2), 0, 1, 'R');
    $pdf->Cell(0, 10, 'Importe Total: ' . number_format($importe_total, 2), 0, 1, 'R');

    // Información adicional
    $pdf->Cell(0, 10, 'SON: ' . convertirNumeroALetras($importe_total) . ' SOLES.', 0, 1, 'R'); // Resaltado en negro

    // Cerrar y generar el PDF
    $pdf->Output('D', 'boleta_' . $id_pedido . '.pdf'); // Descarga el PDF
} else {
    echo "No se ha especificado un ID de pedido.";
}

// Función para convertir números a letras (puedes implementar esto según tus necesidades)
function convertirNumeroALetras($numero) {
    // Lógica para convertir número a letras
    // Este es solo un ejemplo simple
    return $numero; // Cambiar según la implementación real
}
?>
