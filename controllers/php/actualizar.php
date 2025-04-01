<?php
//php para actualizar los datos del perfil
$datos = json_decode(file_get_contents("php://input"), true);

$nombre_completo = $datos["nombre_completo"];
$correo = $datos["correo"];
$usuario = $datos["usuario"];

session_start();
$id = $_SESSION['id'];

$conexion = mysqli_connect("localhost", "root", "", "login_register_db2");

if ($conexion) {
  $query = "UPDATE usuarios SET nombre_completo = '$nombre_completo', correo = '$correo', usuario = '$usuario' WHERE id = '$id'";
  $resultado = mysqli_query($conexion, $query);
  
  if ($resultado) {
    echo json_encode(array("exito" => true));
  } else {
    echo json_encode(array("exito" => false));
  }
} else {
  echo json_encode(array("exito" => false));
}
?>
