<?php
//php para registrar la categoria
$json = file_get_contents('php://input');
$datos = json_decode($json, true);

$nombreCategoria = $datos['nombreCategoria'];
$descripcionCategoria = $datos['descripcionCategoria'];

$conexion = mysqli_connect("localhost", "root", "", "login_register_db2");

if ($conexion) {
  $query = "INSERT INTO categoria (nombreCategoria, descripcionCategoria) VALUES ('$nombreCategoria', '$descripcionCategoria')";
  $resultado = mysqli_query($conexion, $query);
  
  if ($resultado) {
    echo "Categoría creada con éxito";
  } else {
    echo "Error al crear categoría";
  }
} else {
  echo "Error al conectar con la base de datos";
}

?>