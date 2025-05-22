<?php
session_start();
include_once "includes/header.php";
include "../conexion.php";

// Verificamos el rol del usuario
$rolUsuario = $_SESSION['rol'];

// Si el usuario es administrador (rol diferente de 5)
if ($rolUsuario != 5) {
    $query1 = mysqli_query($conexion, "SELECT COUNT(id) AS total FROM salas WHERE estado = 1");
    $totalSalas = mysqli_fetch_assoc($query1);
    $query2 = mysqli_query($conexion, "SELECT COUNT(id) AS total FROM platos WHERE estado = 1");
    $totalPlatos = mysqli_fetch_assoc($query2);
    $query3 = mysqli_query($conexion, "SELECT COUNT(id) AS total FROM usuarios WHERE estado = 1");
    $totalUsuarios = mysqli_fetch_assoc($query3);
    $query4 = mysqli_query($conexion, "SELECT COUNT(id) AS total FROM pedidos WHERE estado = 1");
    $totalPedidos = mysqli_fetch_assoc($query4);
    $query5 = mysqli_query($conexion, "SELECT SUM(total) AS total FROM pedidos");
    $totalVentas = mysqli_fetch_assoc($query5);
?>
<div class="card">
    <div class="card-header text-center">
        Panel General
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Información administrativa -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-cafecito fade-in">
                    <div class="inner">
                        <h3><?php echo $totalPlatos['total']; ?></h3>
                        <p>Productos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="platos.php" class="small-box-footer">Detalles <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-brown fade-in">
                    <div class="inner">
                        <h3><?php echo $totalSalas['total']; ?></h3>
                        <p>Sedes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="salas.php" class="small-box-footer">Detalles <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-light-brown fade-in">
                    <div class="inner">
                        <h3><?php echo $totalUsuarios['total']; ?></h3>
                        <p>Usuarios</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="usuarios.php" class="small-box-footer">Detalles <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-cream fade-in">
                    <div class="inner">
                        <h3><?php echo $totalPedidos['total']; ?></h3>
                        <p>Pedidos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="lista_ventas.php" class="small-box-footer">Detalles <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Ventas</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">$<?php echo $totalVentas['total']; ?></span>
                                <span>Total</span>
                            </p>
                        </div>
                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
} else {
    // Si el usuario es cliente (rol 5)
    $idCliente = $_SESSION['idUser']; // Suponiendo que el ID del cliente está en la sesión

    // Total de pedidos del cliente
    $query1 = mysqli_query($conexion, "SELECT COUNT(id) AS total FROM pedidos WHERE id_usuario = $idCliente");
    $totalPedidos = mysqli_fetch_assoc($query1);

    // Total de ventas del cliente
    $query2 = mysqli_query($conexion, "SELECT SUM(total) AS total FROM pedidos WHERE id_usuario = $idCliente");
    $totalVentas = mysqli_fetch_assoc($query2);
?>
<div class="card">
    <div class="card-header text-center">
        Panel de Cliente
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Información consolidada del cliente -->
            <div class="col-lg-12 col-12">
                <div class="small-box bg-cafecito fade-in">
                    <div class="inner">
                        <h3><?php echo $totalPedidos['total']; ?></h3>
                        <p>Mis Pedidos</p>
                        <h4>Total Gastado: $<?php echo number_format($totalVentas['total'], 2); ?></h4>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="lista_ventas.php" class="small-box-footer">Ver detalles <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Promociones Disponibles</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promociones Disponibles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            color: #5e3a1e;
            text-align: center;
            margin-bottom: 20px;
        }
        .promo {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .promo:last-child {
            border-bottom: none;
        }
        .promo h2 {
            margin: 0;
            font-size: 18px;
            color: #5e3a1e;
        }
        .promo p {
            margin: 5px 0;
            color: #555;
        }
        .promo p.validity {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Promociones Disponibles</h1>
        <div class="promo">
            <h2>2x1 en Capuccinos</h2>
            <p>Descripción: Disfruta de un capuccino gratis al comprar otro.</p>
            <p class="validity">Válido hasta: 10-12-2024</p>
        </div>
        <div class="promo">
            <h2>Combo de café y muffin</h2>
            <p>Descripción: Por solo $5.99 disfruta de un café americano y un muffin de tu elección.</p>
            <p class="validity">Válido hasta: 15-12-2024</p>
        </div>
        <div class="promo">
            <h2>Tarde de Té</h2>
            <p>Descripción: 15% de descuento en todas las variedades de té.</p>
            <p class="validity">Válido hasta: 20-12-2024</p>
        </div>
        <div class="promo">
            <h2>Descuento en desayunos</h2>
            <p>Descripción: Obtén un 20% de descuento en desayunos hasta las 11:00 am.</p>
            <p class="validity">Válido hasta: 31-12-2024</p>
        </div>
        <div class="promo">
            <h2>Happy Hour Café</h2>
            <p>Descripción: Desde las 5 pm hasta las 7 pm, bebidas al 25% de descuento.</p>
            <p class="validity">Válido hasta: 31-12-2024</p>
        </div>
        <div class="promo">
            <h2>Regalo por tu primera compra</h2>
            <p>Descripción: Obséquiate un brownie en tu primera compra como cliente registrado.</p>
            <p class="validity">Válido hasta: 31-12-2024</p>
        </div>
    </div>
</body>
</html>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
include_once "includes/footer.php";
?>

<script src="../assets/js/dashboard.js"></script>

<!-- Agregar el CSS aquí -->
<style>
/* Reseteo básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #faf3e0; /* Fondo beige claro */
    color: #4e4b46;
    line-height: 1.6;
    margin-top: 50px;
}

/* Encabezado */
.card-header {
    background-color: #6c4f37; /* Color marrón oscuro de café */
    color: #fff;
    font-size: 1.5em;
    padding: 15px;
    text-align: center;
    border-radius: 8px 8px 0 0;
}

/* Estilo de las cajas de información */
.small-box {
    position: relative;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 30px;
    text-align: center;
}

.small-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

.small-box .inner {
    padding: 20px;
    background: #fff8e1; /* Color suave de fondo de la caja */
}

.small-box h3 {
    font-size: 2em;
    color: #6c4f37; /* Color café oscuro */
    font-weight: bold;
}

.small-box p {
    color: #6c4f37; /* Color marrón */
    font-size: 1.2em;
}

.small-box .icon {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 2.5em;
    color: #6c4f37;
}

.small-box-footer {
    display: block;
    padding: 10px;
    background: #8b5e3c; /* Color café con leche */
    color: white;
    text-decoration: none;
    font-size: 1em;
    border-top: 1px solid #ddd;
}

.small-box-footer:hover {
    background: #6c4f37;
}

/* Gráfica de ventas */
#sales-chart {
    border-radius: 10px;
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Pie de página */
footer {
    background-color: #6c4f37;
    color: white;
    padding: 10px 0;
    text-align: center;
    font-size: 0.9em;
    position: absolute;
    bottom: 0;
    width: 100%;
}

/* Estilos en pantallas grandes */
@media (min-width: 768px) {
    .col-lg-3 {
        margin-bottom: 20px;
    }
}

/* Estilos en pantallas pequeñas */
@media (max-width: 768px) {
    .small-box {
        margin-bottom: 20px;
    }
    .card-body {
        padding: 15px;
    }
}
</style>

