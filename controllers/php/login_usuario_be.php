<?php
    include '../../config/php/conexion_be.php';

    session_start();
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    
    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' and contrasena='$contrasena'");
    
    if(mysqli_num_rows($validar_login) > 0){
      $row = mysqli_fetch_array($validar_login);
      $_SESSION['id'] = $row['id'];
      $_SESSION['rol'] = $row['rol'];
      $nombre_completo = $row['nombre_completo']; // Obtener el nombre completo
      $correo = $row['correo']; // Obtener el correo
      
      // Guardar los valores en el localStorage y redirigir
      echo "<script>
              localStorage.setItem('nombre_completo', '$nombre_completo');
              localStorage.setItem('correo', '$correo');
              window.location.href = '../../views/html/ejer2.php';
            </script>";
      exit;
  } else {
      echo ' <script> alert("Usuario no existe, por favor verifique los datos"); window.location = "../../views/html/loginregi.html"; </script> ';
      exit;
  }
  
    ?>