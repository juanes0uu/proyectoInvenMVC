<?php
    include '../../config/php/conexion_be.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nombre_completo = $_POST['nombre_completo'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        $rol = $_POST['rol'];

        $query = "INSERT INTO usuarios(nombre_completo, correo, usuario, contrasena, rol) values('$nombre_completo','$correo', '$usuario', '$contrasena', '$rol')";
    
        $ejecutar = mysqli_query($conexion, $query);

        if($ejecutar){
            echo ' <script> alert("Registrado exitosamente"); window.location = "../../views/html/loginregi.html"; </script> ';
        }else{
            echo "Error al registrar";
        }
    }

?>