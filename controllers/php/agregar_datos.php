<?php
session_start();

    $conexion = mysqli_connect("localhost", "root", "", "login_register_db2");

    if($conexion){
        echo 'Conectado exitosamente a la base de datos aaaaaah';
    }else{
        echo 'No se pudo conectar a la base de datos Intente mas tarde';
    }
    
    // Verifica si se envió la acción
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $action = $_POST["action"];
    
      if ($action == "modalVerDatos") {
        // Obtiene los datos del perfil del usuario
        $query = "SELECT nombre_completo, correo, usuario, rol FROM usuarios WHERE id = " . $_SESSION['id'] . "";
        $resultado = mysqli_query($conexion, $query);
        $datos = mysqli_fetch_assoc($resultado);
    
        // Cierra la conexión
        mysqli_close($conexion);
    
        // Devuelve los datos del perfil en formato JSON
        $respuesta = array(
          "success" => true,
          "nombre_completo" => $datos["nombre_completo"],
          "correo" => $datos["correo"],
          "usuario" => $datos["usuario"],
          "rol" => $datos["rol"],
        );
    
        echo json_encode($respuesta);
      } else {
        // Devuelve un error si no se envió la acción correcta
        $respuesta = array(
          "success" => false,
          "message" => "Acción no válida"
        );
    
        echo json_encode($respuesta);
      }
    } else {
      // Devuelve un error si no se envió la solicitud POST
      $respuesta = array(
        "success" => false,
        "message" => "Método no permitido"
      );
    
      echo json_encode($respuesta);
    }
    ?>
    
