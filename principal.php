<?php
    
    //Llamamos a la conexión
    include('conexion.php');

    $usuario = $_SESSION['usuario'];
    $contrasena = $_SESSION['contrasena'];

    $consulta="select tipo from usuario where nombre = '$usuario' and contrasena = '$contrasena'";
    $datos=mysqli_query($conexion,$consulta);
    $fila=mysqli_fetch_array($datos);
        
    $tipo = $fila['tipo'];

    if($tipo == 'admin') {
        header('location:articulos.php');
        die();        
    }
    
    
    //------------------------PARA ORDENAR LOS ARTICULOS-------------------
    //Por si es la primera vez que inicia la página
    if(!isset($_SESSION['orden'])){
        
        $_SESSION['orden'] = "defecto";
        
    }
    //Por si actualiza la página
    else{
        
        if(!isset($_GET['ordenado'])) {
            
            $_SESSION['orden'] = "defecto";
            
        }
        
        //Por si cambia el orden de los artículos
        else {
            
            $_SESSION['orden'] = $_GET['ordenado'];
            
        }
        
    }

    if (!isset($_SESSION['numcarrito'])){
        
        $_SESSION['numcarrito'] = 0;
        
    }

    
    
    //Creamos la variable orden
    $carrito = $_SESSION['numcarrito'];
    $orden = $_SESSION['orden'];  
    
    $codigousuario = $_SESSION['codigo'];
    $usuario = $_SESSION['usuario'];
    
    
    /*$consultausuario = "select * from usuario where codigo = '$codigousuario'";
    $datosusuario=mysqli_query($conexion,$consultausuario);
    $filausuario=mysqli_fetch_array($datosusuario);*/

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Soldado Otaku</title>
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <link rel="stylesheet" type="text/css" href="css/principal.css">
        <link rel="icon" type="image/png" href="imagenes/favicon.png">
    </head>
    <body>
       
        <header>
           
            <div id="logo"><img src="imagenes/logotipo.png" alt=""></div>
            
            <div id="informacion">
                
                    <?php 
                        
                        //Si no hay artículos en el carrito, no se mostrará nada
                        if($carrito == 0){
                            
                            //Nada
                            
                        }
                        //Si hay artículos en el carrito, se mostrará la imagen del carrito y un círculo que mostrará cuantos artículos hay en el carr
                        else {
                            
                            echo '<a href="carrito.php">
                                    <img src="imagenes/carrito.png" alt="">
                                    <div id="circulo">'.$carrito.'</div>
                                </a>';
                            
                        }
                        
                    ?>
                
                <span id="sesion">
                   
                    <?php echo $usuario ?><br/><br/>
                    
                    <?php 
                                            
                        if ($codigousuario == 1) {
                            
                            echo '<a href="login.php">Iniciar sesión</a>';
                            
                        }
                        else {
                            
                            echo '<a href="cerrarsesion.php">Cerrar sesión</a>';
                            
                        }                  
                                               
                    ?>
                    
                    
                    
                </span>
                
                
                
            </div>
            
        </header>
        
        <!-- Menú desplegable para ordenar los artículos -->
        <section id="articulos">
            <section id="busqueda">
                <form method="get">
                Ordenar 
                <select name="ordenado" >
                    <option name="ordenado" value="defecto">Por defecto</option>
                    <option name="ordenado" value="nombre">Alfabéticamente</option>
                    <option name="ordenado" value="precio">Por precio</option>
                    <option name="ordenado" value="cantidad">Por cantidad disponible</option>
                </select>
                <input type="submit" value="Ordenar" id="botonordenar">
                </form>
            </section>
            
            <?php
                    
                //Consultamos todos nuestros artículos dependiendo del orden
                switch ($orden) {
                    case 'defecto':
                        $consulta="select * from articulo order by codigo";
                        break;
                    case 'nombre':
                        $consulta="select * from articulo order by nombre";
                        break;
                    case 'precio':
                        $consulta="select * from articulo order by precioventa";
                        break;
                    case 'cantidad':
                        $consulta="select * from articulo order by stock desc";
                        break;
                }
            
                $datos=mysqli_query($conexion,$consulta);
                while ($fila=mysqli_fetch_array($datos)){
                    
            ?>
            
            <article>
                
                <!-- Mostramos los datos de cada artículo -->
                <img src="data:image/*;base64,<?php echo base64_encode($fila['imagen']); ?>"/>
                <?php echo $fila['nombre'] ?><br/><br/>
                
                
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
                <span id="separar" style="color: <?php echo $color ?>;">Stock: <?php echo $fila['stock'] ?></span><br/>
                
                <!-- Formulario en donde pondremos el boton y enviaremos el codigo identificativo por metodo POST -->
                <form action="individual.php" method="post">
                    
                    <input type="text" name="codigo" value="<?php echo $fila['codigo'] ?>" hidden>
                    <input type="submit" value="Ver" id="ver"><br/><br/>
                    
                </form>
                
            </article>
            
            <?php
                
                }
                    
            ?>
            
        </section>
        
        <!-- Nuesto gran pie de página -->
        <footer>
            Copyright © 2019. Todos los derechos reservados <br/>
            Aitor-Ander-Diego<br/>
            CIFP Txurdinaga LHII<br/>
        </footer>
    </body>
</html>