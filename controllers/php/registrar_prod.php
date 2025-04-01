<?php
//php para guardar o registrar el producto
$conexion = mysqli_connect("localhost", "root", "", "login_register_db2");

if ($conexion) {
  $nombreProducto = $_POST['nombreProducto'];
  $descripcionProducto = $_POST['descripcionProducto'];
  $precioProducto = $_POST['precioProducto'];
  $cantidadProducto = $_POST['cantidadProducto'];
  $categoriaProducto = $_POST['categoriaProducto'];
  $proveedorProducto = $_POST['proveedorProducto'];

  $imagenProducto = $_FILES['imagenProducto'];
  $rutaImagen = "../../public/images/" . $imagenProducto['name'];
  move_uploaded_file($imagenProducto['tmp_name'], $rutaImagen);

  $query = "INSERT INTO producto (nombreProducto, descripcionProducto, precioProducto, cantidadProducto, idCategoria, idProveedor, imagenProducto) VALUES ('$nombreProducto', '$descripcionProducto', '$precioProducto', '$cantidadProducto', '$categoriaProducto', '$proveedorProducto', '$rutaImagen')";
  $resultado = mysqli_query($conexion, $query);

  if ($resultado) {
    echo "Producto creado con éxito";
  } else {
    echo "Error al crear producto:" . mysqli_error($conexion);
  }
} else {
  echo "Error al conectar con la base de datos";
}
?>
