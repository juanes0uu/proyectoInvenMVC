<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "login_register_db2");

// Verificar conexión
if (!$conexion) {
  die("Conexión fallida: " . mysqli_connect_error());
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data['action'] == 'cargarProveedores') {
  $query = "SELECT * FROM proveedor";
  $resultado = mysqli_query($conexion, $query);

  if (!$resultado) {
    die("Error al cargar proveedores: " . mysqli_error($conexion));
  }

  $proveedores = array();
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $proveedores[] = $fila;
  }

  echo json_encode($proveedores);
} elseif ($data['action'] == 'eliminarProveedor') {
  $idProveedor = $data['idProveedor'];

  $query = "DELETE FROM proveedor WHERE idProveedor = '$idProveedor'";
  if (mysqli_query($conexion, $query)) {
    echo json_encode(['estado' => 'exito']);
  } else {
    echo json_encode(['estado' => 'error', 'mensaje' => mysqli_error($conexion)]);
  }
} elseif ($data['action'] == 'editarProveedor') {
  $idProveedor = $data['idProveedor'];
  $nombreProveedor = $data['nombreProveedor'];
  $direccionProveedor = $data['direccionProveedor'];
  $telefonoProveedor = $data['telefonoProveedor'];
  $correoProveedor = $data['correoProveedor'];

  $query = "UPDATE proveedor SET 
            nombreProveedor = '$nombreProveedor', 
            direccionProveedor = '$direccionProveedor', 
            telefonoProveedor = '$telefonoProveedor', 
            correoProveedor = '$correoProveedor' 
            WHERE idProveedor = '$idProveedor'";

  if (mysqli_query($conexion, $query)) {
    echo json_encode(['estado' => 'exito']);
  } else {
    echo json_encode(['estado' => 'error', 'mensaje' => mysqli_error($conexion)]);
  }
}
?>