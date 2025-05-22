<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 5) {
    require_once "../conexion.php";
    $id_user = $_SESSION['idUser'];

    // Modificar la consulta para filtrar por usuario si el rol es 5
    if ($_SESSION['rol'] == 5) {
        $query = mysqli_query($conexion, "SELECT p.*, s.nombre AS sala, u.nombre AS usuario FROM pedidos p INNER JOIN salas s ON p.id_sala = s.id INNER JOIN usuarios u ON p.id_usuario = u.id WHERE p.id_usuario = '$id_user'");
    } else {
        $query = mysqli_query($conexion, "SELECT p.*, s.nombre AS sala, u.nombre AS usuario FROM pedidos p INNER JOIN salas s ON p.id_sala = s.id INNER JOIN usuarios u ON p.id_usuario = u.id");
    }

    include_once "includes/header.php";
?>

<!-- Inicia el contenido HTML con el estilo CSS -->
<style>
/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    color: #333;
}

/* Header */
.cafe-card-header {
    background-color: #d9a68f;
    color: #fff;
    font-size: 1.5rem;
    text-align: center;
    padding: 15px;
    border-radius: 8px 8px 0 0;
}

/* Card */
.cafe-card {
    margin-top: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.cafe-card-body {
    background-color: #fff;
    padding: 20px;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background-color: #f3d4c0;
    font-weight: bold;
}

td {
    background-color: #f9f1e1;
}

/* Table Row Hover Effect */
tr:hover {
    background-color: #f1e4d7;
}

/* Button Styles */
.btn-info {
    background-color: #d9a68f;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}

.btn-info:hover {
    background-color: #c0876f;
}

/* Badge Styles */
.badge-danger {
    background-color: #e74c3c;
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
}

.badge-success {
    background-color: #2ecc71;
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .table th, .table td {
        font-size: 0.9rem;
        padding: 8px;
    }

    .cafe-card {
        margin: 10px;
    }

    .cafe-card-header {
        font-size: 1.2rem;
    }
}
</style>

<div class="card cafe-card">
    <div class="card-header cafe-card-header">
        Historial de Pedidos
    </div>
    <div class="card-body cafe-card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="tbl">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sede</th>
                        <th>Mesa</th>
                        <th>Fecha</th>
                        <th>Subtotal</th>
                        <th>IGV</th>
                        <th>Total</th>
                        <th>Usuario</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($query)) {
                        // Calcular subtotal e IGV
                        $subtotal = $row['total'] / 1.18;
                        $igv = $row['total'] - $subtotal;

                        $estado = $row['estado'] == 'PENDIENTE' 
                            ? '<span class="badge badge-danger">Pendiente</span>' 
                            : '<span class="badge badge-success">Completado</span>';
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['sala']; ?></td>
                            <td><?php echo $row['num_mesa']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                            <td><?php echo number_format($subtotal, 2); ?></td>
                            <td><?php echo number_format($igv, 2); ?></td>
                            <td><?php echo $row['total']; ?></td>
                            <td><?php echo $row['usuario']; ?></td>
                            <td>
                                <a href="detalles_pedido.php?id=<?php echo $row['id']; ?>" class="btn btn-info">Ver Detalles</a>
                            </td>
                            <td><?php echo $estado; ?></td>
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
