<?php    

	include('conexion.php');

    $usuario = $_SESSION['usuario'];
    $contrasena = $_SESSION['contrasena'];

    $consulta="select tipo from usuario where nombre = '$usuario' and contrasena = '$contrasena'";
    $datos=mysqli_query($conexion,$consulta);
    $fila=mysqli_fetch_array($datos);
        
    $tipo = $fila['tipo'];

    if($tipo != 'admin' || $usuario == null) {
        echo '<script type="text/javascript">
                    alert("Usted no tiene acceso a esta página. Inicie sesión como administrador");
                    window.location.href="login.php";
              </script>';
        die();        
    }

    $codigo = $_POST['codigo'];

    $borrar="delete from articulo where codigo = '$codigo'";  

    if ($eliminar=mysqli_query($conexion,$borrar)){       
        
        header("location:articulos.php");
        
    }
    else{
        echo '<script type="text/javascript">
                    alert("Error al eliminar el artículo");
                    window.location.href="articulos.php";
                </script>';
    }

?>