<?php
//php para obtener los datos de categoria y proveedor
$conexion = mysqli_connect("localhost", "root", "", "login_register_db2");
if ($conexion) {
    $queryCategorias = "SELECT * FROM categoria";
    $resultadoCategorias = mysqli_query($conexion, $queryCategorias);
    $categorias = array();
    while ($fila = mysqli_fetch_assoc($resultadoCategorias)) {
    $categorias[] = $fila;
    }

    $queryProveedores = "SELECT * FROM proveedor";
    $resultadoProveedores = mysqli_query($conexion, $queryProveedores);
    $proveedores = array();
    while ($fila = mysqli_fetch_assoc($resultadoProveedores)) {
    $proveedores[] = $fila;
    }

    echo json_encode(array('categorias' => $categorias, 'proveedores' => $proveedores));
} else {
    echo "Error al conectar con la base de datos";
}
?>
