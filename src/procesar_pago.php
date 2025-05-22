<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 5) {
    require_once "../conexion.php";

    // Validar datos del formulario
    $id_pedido = isset($_POST['id_pedido']) ? intval($_POST['id_pedido']) : 0;
    $direccion = isset($_POST['direccion']) ? mysqli_real_escape_string($conexion, $_POST['direccion']) : '';
    $metodo_pago = isset($_POST['metodo_pago']) ? mysqli_real_escape_string($conexion, $_POST['metodo_pago']) : '';

    // Verificar que todos los datos estén presentes
    if ($id_pedido > 0 && !empty($direccion) && !empty($metodo_pago)) {
        // Actualizar la tabla "pedidos" con la dirección, método de pago y estado
        $query = mysqli_query($conexion, 
            "UPDATE pedidos 
             SET direccion = '$direccion', 
                 metodo_pago = '$metodo_pago', 
                 estado = 'Pagado' 
             WHERE id = $id_pedido"
        );

        // Verificar si la actualización fue exitosa
        if ($query) {
            echo "<script>alert('Pago procesado con éxito.'); window.location='lista_pedidos.php';</script>";
        } else {
            echo "<script>alert('Pago procesado con éxito.'); window.location='dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Por favor, completa todos los campos.'); window.history.back();</script>";
    }
} else {
    header('Location: permisos.php');
}
?>
