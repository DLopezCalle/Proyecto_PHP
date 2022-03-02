<?php
    
    //Establecemos la conexión
    include('conexion.php');

    //Verificación de la sesión
    if (!isset ($_SESSION['codigo'])){
        
        $_SESSION['codigo'] = 1;
        
    }
    
    $codigousuario = $_SESSION['codigo'];
    
    $consultausuario = "select * from usuario where codigo = '$codigousuario'";
    $datosusuario=mysqli_query($conexion,$consultausuario);
    $filausuario=mysqli_fetch_array($datosusuario);

    //Si viene ninguna variable post indicando que artículo que se quiero mostrar, se mostrará el ya guardado con anterioridad
    if (!isset($_POST['codigo'])) {
        
        //Nada

    }
    //Si viene una variable post llamada codigo, es porque se quiere que se muestre el artículo correspondiente a dicho código
    else {

        //La variable de sesion locindividual guardará el código del artículo que se quiere mostrar, de esta manera, si al usuario se le redirige a esta página sin que el pueda indicar que artículo desea ver, se le mostrará el último artículo que deseó ver
        $_SESSION['locindividual'] = $_POST['codigo'];
        
    }

    $carrito = $_SESSION['numcarrito'];

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Soldado Otaku</title>
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <link rel="stylesheet" type="text/css" href="css/individual.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <link rel="icon" type="image/png" href="imagenes/favicon.png">
    </head>
    <body>
       
        <header>
           
            <a href="principal.php"><div id="logo"><img src="imagenes/logotipo.png" alt=""></div></a>
            
            <div id="informacion">
                
                <?php 
                        
                        //Si no hay artículos en el carrito, no se mostrará nada
                        if($carrito == 0){
                            
                            //Nada
                            
                        }
                        //Si hay artículos en el carrito, se mostrará la imagen del carrito y un círculo que mostrará cuantos artículos hay en el carrito
                        else {
                            
                            echo '<a href="carrito.php">
                                    <img src="imagenes/carrito.png" alt="">
                                    <div id="circulo">'.$carrito.'</div>
                                </a>';
                            
                        }
                        
                ?>
                
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
        
        <?php
                
            $consulta = "select * from articulo where codigo = '".$_SESSION['locindividual']."'";
            $datos=mysqli_query($conexion,$consulta);
            $fila = mysqli_fetch_array($datos);
                    
        ?>
        <section>
           
            <article id="imagen">
                
                <!-- Mostramos los datos de cada artículo -->
                <img src="data:image/*;base64,<?php echo base64_encode($fila['imagen']); ?>"/>
                
            </article>
            
            <article>
               
                <span id="nombre"><?php echo $fila['nombre'] ?></span><br/><br/><hr><br/>              
                
                
                <?php
                
                //Aquí le asignaremos un color dependiendo de el stock de cada articulo
                if ($fila['stock'] == 0) {
                    
                    $color = 'red';
                    
                }elseif ($fila['stock'] < 6 and $fila['stock'] > 0) {
                    
                    $color = 'orange';
                    
                }else { 
                    
                    $color = 'green';               
                    
                }
                    
                            
                ?>
                
                <span id="precio"><?php echo $fila['precioventa'] ?>€</span>
                
                <!-- Creamos un span en donde añadimos un atributo style y le ponemos la variable del color que se le haya asignado antes -->
                <span id="stock" style="color: <?php echo $color ?>;">Stock: <?php echo $fila['stock'] ?></span><br/><br/>
                
                <span id="info">
                
                    Impuesto incluido. Los gastos de envío se te los pagamos nosotros. Compra! <br/><br/>
                    
                    <form action="accion.php" method="post">
                        
                        Cantidad: <input type="number" id="input" name="cantidad" value="0" min="0" max="<?php echo $fila['stock'] ?>"><br/><br/>
                        
                        <input type="text" name="precio" value="<?php echo $fila['precioventa'] ?>" hidden>
                        <input type="text" name="articulo" value="<?php echo $fila['codigo'] ?>" hidden>
                        <input type="text" name="factura" value="si" hidden>
                        <input type="submit" name="anadir" value="Añadir al carrito" class="boton" id="anadir"><br/>
                        <input type="submit" name="comprar" value="Comprar ahora" class="boton" id="comprar"><br/><br/>
                    
                    </form>
                    
                    <p>Detalles:</p><br/>
                    <?php echo $fila['descripcion'] ?>
                
                </span>
                
            </article>
            
        </section>
        
        <!-- Nuesto gran pie de página -->
        <footer>
            Copyright © 2019. Todos los derechos reservados <br/>
            Aitor-Ander-Diego<br/>
            CIFP Txurdinaga LHII<br/>
        </footer>
    </body>
</html>