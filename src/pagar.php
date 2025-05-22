<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 5) {
    $id_pedido = $_GET['id'];
    include_once "includes/header.php";
?>
<div class="container mt-5">
    <h2>Pagar Pedido #<?php echo $id_pedido; ?></h2>
    <form action="procesar_pago.php" method="POST">
        <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>">
        
        <!-- Dirección de envío -->
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección de Envío</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Ingresa tu dirección">
        </div>
        
        <!-- Método de pago -->
        <div class="mb-3">
            <label for="metodo_pago" class="form-label">Método de Pago</label>
            <select class="form-select" id="metodo_pago" name="metodo_pago" required onchange="mostrarOpcionesPago()">
                <option value="">Seleccionar...</option>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
            </select>
        </div>
        
        <!-- Opciones adicionales para tarjeta -->
        <div id="opciones_tarjeta" style="display: none;">
            <div class="mb-3">
                <label for="numero_tarjeta" class="form-label">Número de Tarjeta</label>
                <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="Ingrese el número de su tarjeta">
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="Código de seguridad (CVV)">
            </div>
            <div class="mb-3">
                <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                <input type="month" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento">
            </div>
        </div>

        <!-- Confirmar compra -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Confirmar Compra</button>
        </div>
    </form>
</div>

<script>
    function mostrarOpcionesPago() {
        const metodoPago = document.getElementById('metodo_pago').value;
        const opcionesTarjeta = document.getElementById('opciones_tarjeta');

        if (metodoPago === 'tarjeta') {
            opcionesTarjeta.style.display = 'block'; // Mostrar campos adicionales
        } else {
            opcionesTarjeta.style.display = 'none'; // Ocultar campos adicionales
        }
    }
</script>

<?php
    include_once "includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>
