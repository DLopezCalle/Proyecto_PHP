<?php 
    
    include('conexionadmin.php');

    $usuario = $_SESSION['usuario'];  
    $idcarrito = $_SESSION['idcarrito'];

    if($usuario == null) {
        echo '<script type="text/javascript">
                    alert("Para cerrar sesión, primero inicie sesión");
                    window.location.href="login.php";
              </script>';
        die();        
    }  

    //Eliminamos la información del carrito en lineapedido del usuario
    $eliminarlineacarrito = "delete from lineacarrito where idcarrito = '$idcarrito'";
    $realizarlineacarrito = mysqli_query($conexion,$eliminarlineacarrito);
                    
    //Eliminamos la información del carrito en carrito del usuario
    $eliminarcarrito = "delete from carrito where id = '$idcarrito'";
    $realizarcarrito = mysqli_query($conexion,$eliminarcarrito);
    
    echo '<script type="text/javascript">
                alert("Se ha cerrado la sesión correctamente");
                window.location.href="principal.php";
            </script>';
                
    session_destroy();

?>