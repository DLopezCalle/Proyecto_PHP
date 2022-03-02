<?php 
    
    session_start();

    //Verificación de la sesión
    if (!isset ($_SESSION['codigo'])){
        
        $_SESSION['codigo'] = 1;
        $_SESSION['usuario'] = 'Invitado';
        $_SESSION['contrasena'] = '123456Aa';
        
    }

    $servername = "localhost";
    $username = $_SESSION['usuario'];
    $password = $_SESSION['contrasena'];
    $db="reto2";

    $conexion=mysqli_connect($servername,$username,$password,$db);
        
?>