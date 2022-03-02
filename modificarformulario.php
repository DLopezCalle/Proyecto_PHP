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

    $consulta="select * from articulo where codigo = '$codigo'";
    $datos=mysqli_query($conexion,$consulta);
    $fila=mysqli_fetch_array($datos);

    $nombre = $fila['nombre'];
    $precioproveedor = $fila['precioproveedor'];
    $precioventa = $fila['precioventa'];
    $descripcion = $fila['descripcion'];
    $stock = $fila['stock'];
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Soldado Otaku</title>
        <link rel="stylesheet" type="text/css" href="css/formulario.css">
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <link rel="icon" type="image/png" href="imagenes/favicon.png">
    </head>
    <body>
        <header>
           
            <div id="logo"><a href="articulos.php"><img src="imagenes/logotipo.png" alt=""></a></div>
            
            <div id="informacion">
                
                <span id="sesion">
                   
                    <?php echo $usuario ?><br/><br/>
                    
                    <?php 
                            
                            echo '<a href="cerrarsesion.php">Cerrar sesión</a>';
                    
                    ?>   
                    
                </span>
                
            </div>
            
        </header>
        
        <form enctype="multipart/form-data" action="modificararticulo.php" method="post">
            <ul>
                <h2>Añadir artículo</h2><br/>  
                <fieldset>
                        <legend align="left">Nombre</legend>   
                <li>                                             
                    <label for="nombre"></label>
                    <input type="text" name="nombre" placeholder="" value="<?php echo $nombre ?>" pattern="[A-Za-z]{,}" title="Introduzca su nombre de usuario" autocomplete="off" autofocus required/>
                </li>
                </fieldset>
                <fieldset>
                        <legend align="left">Imagen del artículo</legend>     
                <li>
                    <label for="imagen"></label>
                    <img src="data:image/*;base64,<?php echo base64_encode($fila['imagen']); ?>"/>
                    <input class="inferior" type="file" value="" title="Inserte la imagen del artículo" name="imagen" required/><br/><br/>
                </li> 
                </fieldset> 
                <fieldset>
                        <legend align="left">Precio de compra</legend> 
                <li>
                    <label for="precioproveedor"></label>
                    <input type="number" placeholder="" value="<?php echo $precioproveedor ?>" title="Inserte el precio de compra" name="preciocompra" required/><br/><br/>
                </li>
                </fieldset>
                <fieldset>
                        <legend align="left">Precio de venta</legend> 
                <li>
                    <label for="precioventa"></label>
                    <input type="number" placeholder="" value="<?php echo $precioventa ?>" title="Inserte el precio de venta" name="precioventa" required/><br/><br/>
                </li>
                </fieldset>
                <fieldset>
                        <legend align="left">Descripción del artículo</legend> 
                <li>
                    <label for="descripcion"></label>
                    <input type="text" placeholder="" value="<?php echo $descripcion ?>" title="Inserte descripción" name="descripcion" required/><br/><br/>
                </li>
                </fieldset>
                <fieldset>
                        <legend align="left">Stock del artículo</legend> 
                <li>
                    <label for="stock"></label>
                    <input type="number" placeholder="" value="<?php echo $stock ?>" title="Inserte el stock actual" name="stock" required/><br/><br/>
                </li>
                </fieldset>
                <span id="nota">Nota: Es necesario resubir la imagen. Si no tiene dicha imagen, puede descargar la que se le da a su disposición</span>
                <input type="text" name="codigo" value="<?php echo $fila['codigo'] ?>" hidden>
                <input type="submit" value="Enviar" id="boton"/>
            </ul>
        </form>    
        
        <footer>
            Copyright © 2019. Todos los derechos reservados <br/>
            Aitor-Ander-Diego<br/>
            CIFP Txurdinaga LHII<br/>
        </footer>
    </body>
</html>