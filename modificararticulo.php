<?php

    include('conexion.php');   

    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $preciocompra = $_POST['preciocompra'];
    $precioventa = $_POST['precioventa'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];

    $modificar="update articulo set nombre = '$nombre',precioproveedor = '$preciocompra',precioventa = '$precioventa',descripcion = '$descripcion',stock = '$stock' where codigo = '$codigo'";

    if ($actualizar=mysqli_query($conexion,$modificar)){       
        
         echo '<script type="text/javascript">
                    alert("Se ha actualizado el artículo correctamente");
                    window.location.href="articulos.php";
                </script>';   
        
    }else{
        
        echo '<script type="text/javascript">
                    alert("Error al modificar el usuario");
                    window.location.href="articulos.php";
                </script>';
        
    }

?>