<?php
//php para obtener y enviar los datos del usuario registrado el perfil
// Inicia la sesión
session_start();

// Conecta a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "login_register_db2");

// Verifica si la conexión fue exitosa
if ($conexion) {
  // Obtiene el ID del usuario de la sesión
  $id = $_SESSION['id'];

  // Crea una consulta para obtener los datos del usuario
  $query = "SELECT nombre_completo, correo, usuario, rol FROM usuarios WHERE id = '$id'";

  // Ejecuta la consulta
  $resultado = mysqli_query($conexion, $query);

  // Obtiene los datos del usuario
  $num_registros = mysqli_fetch_assoc($resultado);
  $nombre_completo = $num_registros['nombre_completo'];
  $correo = $num_registros['correo'];
  $usuario = $num_registros['usuario'];
  $rol = $num_registros['rol'];

  // Crea un array con los datos del usuario
  $mensaje = array(
    "nombre_completo" => $nombre_completo,
    "correo" => $correo,
    "usuario" => $usuario,
    "rol" => $rol
  );

  // Envía el array como un objeto JSON
  echo json_encode($mensaje);
} else {
  // Envía un mensaje de error si la conexión no fue exitosa
  echo "Error al conectar con la base de datos.";
}
?>