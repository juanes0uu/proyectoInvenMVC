<?php
//php para registrar el proveedor
$json = file_get_contents('php://input');
$datos = json_decode($json, true);

$nombreProveedor = $datos['nombreProveedor'];
$direccionProveedor = $datos['direccionProveedor'];
$telefonoProveedor = $datos['telefonoProveedor'];
$correoProveedor = $datos['correoProveedor'];


$conexion = mysqli_connect("localhost", "root", "", "login_register_db2");

if ($conexion) {
  $query = "INSERT INTO proveedor (nombreProveedor, direccionProveedor, telefonoProveedor, correoProveedor ) VALUES ('$nombreProveedor', '$direccionProveedor', '$telefonoProveedor', '$correoProveedor')";
  $resultado = mysqli_query($conexion, $query);
  
  if ($resultado) {
    echo "Proveedor creado con éxito";
  } else {
    echo "Error al crear proveedor";
  }
} else {
  echo "Error al conectar con la base de datos";
}

?>