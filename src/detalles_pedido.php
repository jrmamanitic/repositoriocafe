<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 5) {
    require_once "../conexion.php";
    $id_pedido = $_GET['id'];

    // Consulta para obtener los detalles del pedido
    $query = mysqli_query($conexion, "SELECT dp.*, p.nombre AS producto, dp.precio AS precio_producto FROM detalle_pedidoS dp INNER JOIN platos p ON dp.nombre = p.nombre WHERE dp.id_pedido = $id_pedido");
    
    include_once "includes/header.php";
?>

<!-- Botones para generar y descargar la boleta -->
<div class="mb-3">
    <a href="boleta.php?id=<?php echo $id_pedido; ?>" class="btn btn-success">Generar Boleta</a>
    <a href="descargar_boleta.php?id=<?php echo $id_pedido; ?>" class="btn btn-primary">Descargar Boleta</a>
    <a href="pagar.php?id=<?php echo $id_pedido; ?>" class="btn btn-warning">Pagar</a> <!-- Botón Pagar -->
</div>

<div class="card">
    <div class="card-header">
        Detalles del Pedido #<?php echo $id_pedido; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($query)) {
                        $total_producto = $row['cantidad'] * $row['precio_producto'];
                    ?>
                        <tr>
                            <td><?php echo $row['producto']; ?></td>
                            <td><?php echo $row['cantidad']; ?></td>
                            <td><?php echo number_format($row['precio_producto'], 2); ?></td>
                            <td><?php echo number_format($total_producto, 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>
