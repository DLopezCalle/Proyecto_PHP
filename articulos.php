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
        
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Soldado Otaku</title>
        <link rel="stylesheet" type="text/css" href="css/articulos.css">
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <link rel="icon" type="image/png" href="imagenes/favicon.png">
    </head>
    <body>
        <header>
           
            <div id="logo"><img src="imagenes/logotipo.png" alt=""></div>
            
            <div id="informacion">
                
                <span id="sesion">
                   
                    <?php echo $usuario ?><br/><br/>
                    
                    <?php 
                            
                            echo '<a href="cerrarsesion.php">Cerrar sesión</a>';
                    
                    ?>   
                    
                </span>
                
            </div>
            
        </header>
        
        <form action="anadirformulario.php">
            <button>Añardir artículo</button>
        </form>
        
        <table>
            <thead>
                <tr>
                    <td>Nombre</td>
                    <td>Imagen</td>
                    <td>Precio compra</td>
                    <td>Precio venta</td> 
                    <td>Descripción</td>                   
                    <td>Stock</td>                   
                    <td>Acción</td>                   
                </tr>
            </thead>            
            <?php
        
                $consulta="select * from articulo";
                $datos=mysqli_query($conexion,$consulta);
                while ($fila=mysqli_fetch_array($datos)){ 
                   
            ?>
            
        
            <tbody>
                <tr>
                    <td><?php echo $fila['nombre']?></td>
                    <td id="tdimagen"><img class="imagen" src="data:image/*;base64,<?php echo base64_encode($fila['imagen']); ?>"/></td>
                    <td class="precio"><?php echo $fila['precioproveedor']?></td>
                    <td class="precio"><?php echo $fila['precioventa']?></td>
                    <td><?php echo $fila['descripcion']?></td>
                    <td id="stock"><?php echo $fila['stock']?></td>  
                    <td class="reducir">
                        <form action="borrararticulo.php" method="post">
                            <input type="text" name="codigo" value="<?php echo $fila['codigo']?>" hidden>
                            <input type="image" src="Imagenes/Eliminar.png" class="eliminar" title="Eliminar artículo">
                        </form>
                        <form action="modificarformulario.php" class="derecha" method="post"> 
                            <input type="text" name="codigo" value="<?php echo $fila['codigo']?>" hidden>
                            <input type="image" src="Imagenes/Modificar.png" class="modificar" title="Modificar artículo">
                        </form>                          
                    </td> 
                </tr>
            </tbody>           
            <?php 
                    
                }
            
            ?>            
        </table>
        
        <footer>
            Copyright © 2019. Todos los derechos reservados <br/>
            Aitor-Ander-Diego<br/>
            CIFP Txurdinaga LHII<br/>
        </footer>
    </body>
</html>