<?php
include "../conexion.php";
$categoria = isset($_POST['categoria']) ? intval($_POST['categoria']) : 0;

// Consulta SQL con filtro por categoría
$query = ($categoria == 0) 
    ? "SELECT * FROM platos WHERE estado = 1" 
    : "SELECT * FROM platos WHERE estado = 1 AND id_categoria = $categoria";

$result = mysqli_query($conexion, $query);
if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) { ?>
        <div class="col-md-3 producto" data-categoria="<?php echo $data['id_categoria']; ?>">
            <div class="col-12">
                <img src="<?php echo ($data['imagen'] == null) ? '../assets/img/default.png' : $data['imagen']; ?>" class="product-image" alt="Product Image">
            </div>
            <h6 class="my-3"><?php echo $data['nombre']; ?></h6>
            <div class="bg-gray py-2 px-3 mt-4">
                <h2 class="mb-0">$<?php echo $data['precio']; ?></h2>
            </div>
            <div class="mt-4">
                <a class="btn btn-primary btn-block btn-flat addDetalle" href="#" data-id="<?php echo $data['id']; ?>">
                    <i class="fas fa-cart-plus mr-2"></i> Agregar
                </a>
            </div>
        </div>
    <?php }
} else {
    echo '<p>No hay productos disponibles en esta categoría.</p>';
}
?>
