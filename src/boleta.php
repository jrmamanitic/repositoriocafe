<?php
session_start();
require_once "../conexion.php";

if (isset($_GET['id'])) {
    $id_pedido = mysqli_real_escape_string($conexion, $_GET['id']);

    // Obtener los detalles del pedido
    $query = mysqli_query($conexion, "
        SELECT dp.*, p.nombre AS producto 
        FROM detalle_pedidos dp 
        INNER JOIN platos p ON dp.nombre = p.nombre 
        WHERE dp.id_pedido = '$id_pedido'
    ");
    
    // Obtener información adicional del pedido
    $pedido_info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM pedidos WHERE id = '$id_pedido'"));
    $id_usuario = $pedido_info['id_usuario'];
    $nombre_usuario = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre FROM usuarios WHERE id = '$id_usuario'"))['nombre'];
    $id_sala = $pedido_info['id_sala'];
    $num_mesa = $pedido_info['num_mesa'];
    $nombre_sede = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre FROM salas WHERE id = '$id_sala'"))['nombre'];
    $direccion_info = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT direccion, telefono, email FROM config WHERE id = 1"));

    // Generar la boleta
    $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Venta Electrónica</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .boleta {
            width: 350px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            padding: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .boleta h2 {
            font-size: 18px;
            margin: 0;
            color: #007BFF;
            text-align: center;
        }

        .boleta h3 {
            font-size: 14px;
            margin: 10px 0;
            text-align: center;
        }

        .boleta p {
            font-size: 12px;
            margin: 5px 0;
        }

        .boleta .header {
            text-align: center;
        }

        .boleta table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .boleta table th, .boleta table td {
            font-size: 12px;
            text-align: left;
            padding: 5px;
            border: 1px solid #ddd;
        }

        .boleta table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .totals {
            margin-top: 10px;
            font-size: 12px;
        }

        .totals p {
            text-align: right;
            margin: 3px 0;
        }

        .totals .highlight {
            font-weight: bold;
            color: #007BFF;
        }
    </style>
</head>
<body>
    <div class="boleta">
        <div class="header">
            <h2>CaféBUENISIMO</h2>
            <p>' . $direccion_info['direccion'] . '</p>
            <p>Tel: ' . $direccion_info['telefono'] . '</p>
            <p>Email: ' . $direccion_info['email'] . '</p>
        </div>

        <h3>Boleta de Venta Electrónica</h3>
        <p><strong>RUC:</strong> 10329772825</p>
        <p><strong>Fecha de Emisión:</strong> ' . date('d-m-Y') . '</p>
        <p><strong>Cliente:</strong> ' . $nombre_usuario . '</p>
        <p><strong>Sede:</strong> ' . $nombre_sede . '</p>
        <p><strong>N° Mesa:</strong> ' . $num_mesa . '</p>

        <table>
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Cant.</th>
                    <th>Precio</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>';

    $total_general = 0;

    while ($row = mysqli_fetch_assoc($query)) {
        $total_producto = $row['cantidad'] * $row['precio'];
        $total_general += $total_producto;

        $html .= '<tr>
            <td>' . $row['producto'] . '</td>
            <td style="text-align: center;">' . $row['cantidad'] . '</td>
            <td style="text-align: right;">' . number_format($row['precio'], 2) . '</td>
            <td style="text-align: right;">' . number_format($total_producto, 2) . '</td>
        </tr>';
    }

    $subtotal = $total_general / 1.18;
    $igv = $subtotal * 0.18;

    $html .= '</tbody>
        </table>
        
        <div class="totals">
            <p>Subtotal: ' . number_format($subtotal, 2) . '</p>
            <p>IGV (18%): ' . number_format($igv, 2) . '</p>
            <p class="highlight">Total: ' . number_format($total_general, 2) . '</p>
        </div>
    </div>
</body>
</html>';

    echo $html;
} else {
    echo "No se ha especificado un ID de pedido.";
}

function convertirNumeroALetras($numero) {
    // Implementar conversión según tus necesidades
    return $numero;
}
?>
