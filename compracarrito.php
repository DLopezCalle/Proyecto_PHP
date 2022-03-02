<?php 

    include('conexionadmin.php');
    
    $idcarrito = $_SESSION['idcarrito'];

    $consulta="select a.codigo, a.precioventa, l.cantidad from lineacarrito l join articulo a on l.codigoarticulo = a.codigo where l.idcarrito = '$idcarrito'";
    
    if($_SESSION['codigo'] == 1){
            
        //Mensaje
        echo '<script type="text/javascript">
                    alert("Inicie sesión para efectuar su compra");
                    window.location.href="login.php";
            </script>';
            
    }
    else{
        
        if($datos = mysqli_query($conexion,$consulta)){
            
                //Para darle valor a la nueva id del carrito, contamos las ids de carritos almacenas en la base de datos
                $numfila = "select count(codigo) from pedido";
                $datosfila = mysqli_query($conexion,$numfila);
                $filapedido = mysqli_fetch_array($datosfila);
            
                //Si no existe ninguna pedido
                if ($filapedido['count(codigo)'] == null){
                
                    //El código de este pedido será igual a 1
                    $numpedido = 1;
                
                }
                //Si ya existe un/os códigos de pedido
                else{
                
                    //Contamos todos los código y el nuevo código será el resultado de la cuenta + 1
                    $numpedido = $filapedido['count(codigo)'] + 1;
                
                }
            
                while ($fila= mysqli_fetch_array($datos)){
                                 
                    $codigoarticulo = $fila['codigo'];
                    $precio = $fila['precioventa'];
                    $cantidad = $fila['cantidad'];
                    
                    $totalpedido = $precio * $cantidad;
                                
                    //Insertamos los datos del pedido en la tabla pedido
                    $pedido = "insert into pedido values ('$numpedido',NOW(),'".$_SESSION['codigo'].")')";
                    $realizarpedido = mysqli_query($conexion,$pedido);
            
                    //Insertamos los datos del pedido en la tabla lineapedido
                    $lineapedido = "insert into lineapedido values ('$codigoarticulo','$numpedido','$precio','$cantidad','$totalpedido')";
                    $realizarlineapedido = mysqli_query($conexion,$lineapedido);           
                
                    //Restamos del stock de los artículos correspondientes a la compra
                    $restararticulo = "update articulo set stock = stock - $cantidad where codigo = '$codigoarticulo'";
                    $resta = mysqli_query($conexion,$restararticulo);
                    
                    //Eliminamos la información del carrito en lineapedido del usuario
                    $eliminarlineacarrito = "delete from lineacarrito where idcarrito = '$idcarrito'";
                    $realizarlineacarrito = mysqli_query($conexion,$eliminarlineacarrito);
                    
                    //Eliminamos la información del carrito en carrito del usuario
                    $eliminarcarrito = "delete from carrito where id = '$idcarrito'";
                    $realizarcarrito = mysqli_query($conexion,$eliminarcarrito);
                    
                    $_SESSION['factura'] = $numpedido;
                    
                    //A la varible de sesion que nos muestra cuantos artículos tenemos en el carrito, le daremos valor 0
                    $_SESSION['numcarrito'] = 0;
                 
                }
                
                //Mensaje
                echo '<script type="text/javascript">
                            alert("Gracias por confiar en nosotros :3");
                            window.location.href="pdf.php";
                    </script>';
                
        }
        else {
        
            //Mensaje
            echo '<script type="text/javascript">
                        alert("Error al conectar a la base de datos");
                        window.location.href="carrito.php";
                </script>';
        
        }
        
    }

    
    

?>