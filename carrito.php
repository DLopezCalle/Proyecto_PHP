<?php

    include('conexion.php');

    //Verificación de la sesión
    if (!isset ($_SESSION['codigo'])){
        
        $_SESSION['codigo'] = 1;
        
    }
    
    $codigousuario = $_SESSION['codigo'];
    
    $consultausuario = "select * from usuario where codigo = '$codigousuario'";
    $datosusuario=mysqli_query($conexion,$consultausuario);
    $filausuario=mysqli_fetch_array($datosusuario);

    if(!isset($_SESSION['idcarrito'])){
        
        echo '<script type="text/javascript">
                    alert("No tiene acceso a esta página");
                    window.location.href="principal.php";
            </script>';
        
    }

    $idcarrito = $_SESSION['idcarrito'];

?>



<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Soldado Otaku</title>
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <link rel="stylesheet" type="text/css" href="css/carrito.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <link rel="icon" type="image/png" href="imagenes/favicon.png">
    </head>
    <body>
       
        <header>
           
            <a href="principal.php"><div id="logo"><img src="imagenes/logotipo.png" alt=""></div></a>
            
            <div id="informacion">
                
                <span id="sesion">
                   
                    <?php echo $filausuario['nombre'] ?><br/><br/>
                    
                    <?php 
                                            
                        if ($filausuario['codigo'] == 1) {
                            
                            echo '<a href="login.php">Iniciar sesión</a>';
                            
                        }
                        else {
                            
                            echo '<a href="cerrarsesion.php">Cerrar sesión</a>';
                            
                        }                  
                                               
                    ?>
                    
                    
                    
                </span>
                
                
                
            </div>
            
        </header>
        <table>
            <thead>
                <tr>
                   
                    <td>Nombre</td>
                    <td>Imagen</td>
                    <td>Descripcion</td>
                    <td>Precio</td>
                    <td>Cantidad</td>
                    <td>Acción</td>
                    
                </tr>
            </thead>            
            
            <tbody>
                <?php
        
                    $preciototal = 0;
                
                    $consulta="select a.codigo, a.nombre, a.imagen, a.descripcion, a.precioventa, l.cantidad from lineacarrito l join articulo a on l.codigoarticulo = a.codigo where l.idcarrito = '$idcarrito'";
                    $datos=mysqli_query($conexion,$consulta);
                    while ($fila=mysqli_fetch_array($datos)){
                        
                        
                        
                        $precio = $fila['precioventa'] * $fila['cantidad'];
                        $preciototal = $preciototal + $precio;
                    
                ?>
                <tr>
                   
                    <td><?php echo $fila['nombre']?></td>
                    <td id="imagen"><img src="data:image/*;base64,<?php echo base64_encode($fila['imagen']); ?>"/></td>
                    <td><?php echo $fila['descripcion']?></td>
                    <td><?php echo $fila['precioventa']?>€</td>
                    <td><?php echo $fila['cantidad']?></td>
                    <td class="reducir">
                        <form action="borrarcarrito.php" method="post">
                            <input type="text" name="code" value="<?php echo $fila['codigo']?>" hidden>
                            <input type="text" name="cantidad" value="<?php echo $fila['cantidad']?>" hidden>
                            <input type="image" src="Imagenes/Eliminar.png" class="eliminar" title="Eliminar usuario">
                        </form>                         
                    </td>
                    
                </tr>
                <?php
                    }
                ?>
                <tr>
                    <td class="invisible"></td>
                </tr>
                <tr id="completo">
                    
                    <td class="invisible"></td>
                    <td class="invisible"></td>
                    <td class="invisible"></td>
                    <td class="invisible"></td>
                    <td id="total">Total</td>
                    <td><?php echo $preciototal ?>€</td>
                    
                </tr>
            </tbody>           
            
            
            
        </table>
        
        <form action="compracarrito.php" method="post" id="compra">
                
            <input type="submit" id="boton" value="Finalizar compra">
                
        </form>
            
        <footer>
            Copyright © 2019. Todos los derechos reservados <br/>
            Christiano-Juleno-Jamalo-Diego<br/>
            CIFP Txurdinaga LHII<br/>
        </footer>
    </body>
</html>