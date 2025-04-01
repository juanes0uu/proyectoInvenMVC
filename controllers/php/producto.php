<?php

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "login_register_db2");

// Verificar conexión
if (!$conexion) {
  die("Conexión fallida: " . mysqli_connect_error());
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data['action'] == 'cargarProductos') {
  // Consulta para cargar productos
  $query = "SELECT p.idProducto, p.nombreProducto, p.descripcionProducto, p.precioProducto, p.cantidadProducto, p.imagenProducto, c.nombreCategoria, pr.nombreProveedor
              FROM producto p
              INNER JOIN categoria c ON p.idCategoria = c.idCategoria
              INNER JOIN proveedor pr ON p.idProveedor = pr.idProveedor";

  // Ejecutar consulta
  $resultado = mysqli_query($conexion, $query);

  // Verificar resultado
  if (!$resultado) {
    die("Error al cargar productos: " . mysqli_error($conexion));
  }

  // Crear array para almacenar productos
  $productos = array();

  // Recorrer resultado y almacenar productos en array
  while ($fila = mysqli_fetch_assoc($resultado)) {
    $productos[] = $fila;
  }

  // Devolver productos en formato JSON
  echo json_encode($productos);
} elseif ($data['action'] == 'eliminarProducto') {
  $idProducto = $data['idProducto'];

  // Consulta para eliminar producto
  $query = "DELETE FROM producto WHERE idProducto = '$idProducto'";

  // Ejecutar consulta
  if (mysqli_query($conexion, $query)) {
    echo json_encode(['estado' => 'exito']);
  } else {
    echo json_encode(['estado' => 'error', 'mensaje' => mysqli_error($conexion)]);
  }
} elseif ($data['action'] == 'editarProducto') {
  $idProducto = $data['idProducto'];
  $nombreProducto = $data['nombreProducto'];
  $descripcionProducto = $data['descripcionProducto'];
  $precioProducto = $data['precioProducto'];
  $cantidadProducto = $data['cantidadProducto'];

  // Consulta para editar producto
  $query = "UPDATE producto SET 
            nombreProducto = '$nombreProducto', 
            descripcionProducto = '$descripcionProducto', 
            precioProducto = '$precioProducto', 
            cantidadProducto = '$cantidadProducto' 
            WHERE idProducto = '$idProducto'";

  if (mysqli_query($conexion, $query)) {
    echo json_encode(['estado' => 'exito']);
  } else {
    echo json_encode(['estado' => 'error', 'mensaje' => mysqli_error($conexion)]);
  }
}