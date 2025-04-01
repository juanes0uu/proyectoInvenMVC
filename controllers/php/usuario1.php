<?php
// Conectar a la base de datos
include 'indexX.php';

// Obtener datos del formulario
$username = $_POST['username'];
$password = $_POST['password'];

// Encriptar contraseña
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Verificar si el usuario existe en la base de datos
$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE username = :username');
$stmt->bindParam(':username', $username);
$stmt->execute();

if ($stmt->rowCount() > 0) {
  // Usuario existe, verificar contraseña
  $usuario = $stmt->fetch();
  if (password_verify($password, $usuario['password'])) {
    // Contraseña correcta, iniciar sesión
    echo json_encode(['estado' => 'exito', 'mensaje' => 'Inicio de sesión exitoso']);
  } else {
    // Contraseña incorrecta
    echo json_encode(['estado' => 'error', 'mensaje' => 'Contraseña incorrecta']);
  }
} else {
  // Usuario no existe
  echo json_encode(['estado' => 'error', 'mensaje' => 'Usuario no existe']);
}
?>