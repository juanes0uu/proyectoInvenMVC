<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "login_register_db2");

// Verificar conexióna
if (!$conexion) {
  die("Conexión fallida: " . mysqli_connect_error());
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data['action'] == 'cargarCategorias') {
  $query = "SELECT * FROM categoria";
  $resultado = mysqli_query($conexion, $query);

  if (!$resultado) {
    die("Error al cargar categorías: " . mysqli_error($conexion));
  }

  $categorias = array();
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $categorias[] = $fila;
  }

  echo json_encode($categorias);
} elseif ($data['action'] == 'eliminarCategoria') {
  $idCategoria = $data['idCategoria'];

  $query = "DELETE FROM categoria WHERE idCategoria = '$idCategoria'";
  if (mysqli_query($conexion, $query)) {
    echo json_encode(['estado' => 'exito']);
  } else {
    echo json_encode(['estado' => 'error', 'mensaje' => mysqli_error($conexion)]);
  }
} elseif ($data['action'] == 'editarCategoria') {
  $idCategoria = $data['idCategoria'];
  $nombreCategoria = $data['nombreCategoria'];
  $descripcionCategoria = $data['descripcionCategoria'];

  $query = "UPDATE categoria SET 
            nombreCategoria = '$nombreCategoria', 
            descripcionCategoria = '$descripcionCategoria' 
            WHERE idCategoria = '$idCategoria'";

  if (mysqli_query($conexion, $query)) {
    echo json_encode(['estado' => 'exito']);
  } else {
    echo json_encode(['estado' => 'error', 'mensaje' => mysqli_error($conexion)]);
  }
}
?>