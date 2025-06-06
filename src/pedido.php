<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3 || $_SESSION['rol'] == 5 ) {
    include_once "includes/header.php";
?>
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Productos
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Formulario de filtro por categoría -->
                <div class="col-md-3 mb-3">
                <form method="GET" action="">
                    <label for="categoria">Filtrar por Categoría</label>
                    <select name="categoria" id="categoria" class="form-control">
                        <option value="">Todas</option>
                        <?php
                        include "../conexion.php";
                        // Consulta para obtener las categorías
                        $query_categorias = mysqli_query($conexion, "SELECT * FROM categorias");
                        while ($categoria = mysqli_fetch_assoc($query_categorias)) {
                            $selected = isset($_GET['categoria']) && $_GET['categoria'] == $categoria['id'] ? 'selected' : '';
                            echo "<option value='" . $categoria['id'] . "' $selected>" . $categoria['nombre'] . "</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="id_sala" value="<?php echo $_GET['id_sala']; ?>">
                    <input type="hidden" name="mesa" value="<?php echo $_GET['mesa']; ?>">
                    <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
                </form>
                </div>

                <div class="col-7 col-sm-9">
                    <div class="tab-content" id="vert-tabs-right-tabContent">
                        <div class="tab-pane fade show active" id="vert-tabs-right-home" role="tabpanel" aria-labelledby="vert-tabs-right-home-tab">
                        <input type="hidden" id="id_sala" value="<?php echo $_GET['id_sala'] ?>">
                        <input type="hidden" id="mesa" value="<?php echo $_GET['mesa'] ?>">

                            <div class="row">
                                <?php
                                // Filtramos los platos por categoría si es que se selecciona una
                                $categoria_filter = isset($_GET['categoria']) && $_GET['categoria'] != '' ? "AND categoria = " . (int)$_GET['categoria'] : "";
                                $query = mysqli_query($conexion, "SELECT * FROM platos WHERE estado = 1 $categoria_filter");
                                $result = mysqli_num_rows($query);
                                if ($result > 0) {
                                    while ($data = mysqli_fetch_assoc($query)) { ?>
                                        <div class="col-md-3">
                                            <div class="col-12">
                                             <img src="<?php echo ($data['imagen'] == null) ? '../imagenes/' . htmlspecialchars($data['id']) . '.jpg' : $data['imagen']; ?>" 
                         class="product-image" alt="" width="500"  >
                                              <br>
                                            </div>
                                            <h6 class="my-3"><?php echo $data['nombre']; ?></h6>

                                            <div class="bg-gray py-2 px-3 mt-4">
                                                <h2 class="mb-0">
                                                    $<?php echo $data['precio']; ?>
                                                </h2>
                                            </div>

                                            <div class="mt-4">
                                                <a class="btn btn-primary btn-block btn-flat addDetalle" href="#" data-id="<?php echo $data['id']; ?>">
                                                    <i class="fas fa-cart-plus mr-2"></i>
                                                    Agregar
                                                </a>
                                            </div>
                                        </div>
                                <?php }
                                } else {
                                    echo "<p>No hay productos disponibles para esta categoría.</p>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pedido" role="tabpanel" aria-labelledby="pedido-tab">
                            <div class="row" id="detalle_pedido"></div>
                            <hr>
                            <div class="form-group">
                                <label for="observacion">Observaciones</label>
                                <textarea id="observacion" class="form-control" rows="3" placeholder="Observaciones"></textarea>
                            </div>
                            <button class="btn btn-primary" type="button" id="realizar_pedido">Realizar pedido</button>
                        </div>
                    </div>
                </div>
                <div class="col-5 col-sm-3">
                    <div class="nav flex-column nav-tabs nav-tabs-right h-100" id="vert-tabs-right-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="vert-tabs-right-home-tab" data-toggle="pill" href="#vert-tabs-right-home" role="tab" aria-controls="vert-tabs-right-home" aria-selected="true">Platos</a>
                        <a class="nav-link" id="pedido-tab" data-toggle="pill" href="#pedido" role="tab" aria-controls="pedido" aria-selected="false">Pedido</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
<?php include_once "includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>
