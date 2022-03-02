<?php 

/*NOTA A FUTURO. AUN NO SE HA TENIDO EN CUENTA LA CANTIDAD AL SUMAR EN LA VARIABLE NUMCARRITO, NI SE HA HECHO LO DEL STOCK (LA RESTA). Esto último se debe hacer cuando se compre el artículo, no en este archivo (creo)
$restararticulo = "update articulo set stock = stock - '$cantidad' where codigo = '$codigo'";
$resta = mysqli_query($conexion,$restararticulo);*/

    //Hacemos la conexión como admin
    include('conexionadmin.php');

    //Declaramos las variables que nos vienen al darla a "añadir al carrito"
    $codigo = $_POST['articulo'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];

    $totalpedido = $precio * $cantidad;

    if($cantidad == 0){
        
        //Mensaje
        echo '<script type="text/javascript">
                    alert("No puede comprar 0 productos :v");
                    window.location.href="individual.php";
            </script>';
        die;
        
    }
    
    //Lo siguiente se hará si a la hora de darle a uno de los dos botones, se le da a el botón de AÑADIR
    if ($_POST['anadir']){
                
        //Si no existe la variable de id del carrito...
        if (!isset($_SESSION['idcarrito'])){
            
            //Para darle valor a la nueva id del carrito, contamos las ids de carritos almacenas en la base de datos
            $numfila = "select count(id) from carrito";
            $datosfila = mysqli_query($conexion,$numfila);
            $filacarrito = mysqli_fetch_array($datosfila);
            
            //Si no existe ninguna id de carrito, la nueva id será igual a 1
            if ($filacarrito['count(id)'] == null){
                
                $_SESSION['idcarrito'] = 1;
                
            }
            //Si ya existe una/s id de carrito, contemos todas las id, y la nueva id será el resultado de la cuenta + 1
            else{
                
                $_SESSION['idcarrito'] = $filacarrito['count(id)'] + 1;
                
            }                        
            
        }
        
        //Guardamos la variable de sesión de la id del carrito
        $idcarrito = $_SESSION['idcarrito'];
        
        //Consultamos todos los datos de la tabla de carrito que corresponda a la id deseada
        $consulta = "select * from carrito where id = '$idcarrito'";
        
        //Si hace bien la conexion
        if ($datos = mysqli_query($conexion,$consulta)){
            
            //Si existe una fila con esta id de carrito...
            if ($fila = mysqli_fetch_array($datos)){
                
                //Consultamos si en el carrito ya esta pedido el artículo que se desea agregar
                $consulta2 = "select * from lineacarrito where idcarrito = '$idcarrito' and codigoarticulo = '$codigo'";
                
                //Si hace bien la conexion...
                if ($datos2 = mysqli_query($conexion,$consulta2)){
                    
                    //Si ya existe el artículo...
                    if ($fila2 = mysqli_fetch_array($datos2)){
                        
                        //Comprobamos que no se esten pidiendo más unidades de las que se tienen en el stock de la tabla artículos, teniendo en cuenta la cantidad que ya podría haber pedido el usuario sobre ese mismo artículo con anterioridad                        
                        $comprobarstock = "select stock from articulo where codigo = '$codigo'";
                        
                        if ($stockdatos = mysqli_query($conexion,$comprobarstock)){
                            
                            $filastock = mysqli_fetch_array($stockdatos);
                            
                            //Sumamos las dos cantidades (la que ya esta en el carrito y la que quiere añadirse al carrito)
                            $sumacantidad = $cantidad + $fila2['cantidad'];
                            
                            //Si la suma de las dos cantidades es menor o igual al stock registrado de ese artículo en la tabla articulo
                            if($sumacantidad <= $filastock['stock']){
                                
                                //Modificamos la cantidad del artículo
                                $update = "update lineacarrito set cantidad = cantidad + '$cantidad' where codigoarticulo = '".$fila2['codigoarticulo']."'";
                        
                                //Si se realiza correctamente la actualización...
                                if ($actualizar = mysqli_query($conexion,$update)){
                            
                                    //Esta variable guarda cuantos artículos hay en el carrito
                                    $_SESSION['numcarrito'] = $_SESSION['numcarrito'] + $cantidad;
                            
                                    //Mensaje
                                    echo '<script type="text/javascript">
                                                alert("El artículo se ha añadido al carrito");
                                                window.location.href="principal.php";
                                        </script>';
                                
                                }
                        
                                //Si hace MAL la actualización de la cantidad...
                                else{
                            
                                    //Mensaje
                                    echo '<script type="text/javascript">
                                                alert("Error al actualizar la cantidad del artículo");
                                                window.location.href="principal.php";
                                        </script>';
                            
                                }
                                
                            }
                            //Si la suma de las dos cantidades es mayor al stock registrado de ese artículo en la tabla articulo
                            else{
                                
                                echo '<script type="text/javascript">
                                            alert("La cantidad solicitada de este artículo supera nuestro stock. Intentelo más tarde, disculpe las molestias");
                                            window.location.href="individual.php";
                                    </script>';
                                
                            }
                            
                        }
                        else{
                            
                            echo '<script type="text/javascript">
                                        alert("Error al comprobar el stock del artículo");
                                        window.location.href="individual.php";
                                </script>';
                            
                        }
                        
                        
                        
                        
                        
                    }
                    else{
                        
                        //Solo añadimos en la tabla línea de pedido el nuevo artículo y cantidad, además de la id del carrito
                        $insert="INSERT INTO lineacarrito VALUES ('$idcarrito','$codigo','$cantidad'); ";
                
                        //Si añade bien...
                        if($agregar = mysqli_query($conexion,$insert)){
                    
                            //Esta variable guarda cuantos artículos hay en el carrito
                            $_SESSION['numcarrito'] = $_SESSION['numcarrito'] + $cantidad;
                    
                            //Mensaje
                            echo '<script type="text/javascript">
                                        alert("Se ha añadido el artículo al carrito correctamente");
                                        window.location.href="principal.php";
                                </script>';
                    
                        }
                        else {
                    
                            //Mensaje
                            echo '<script type="text/javascript">
                                        alert("Error al agregar el artículo en la tabla línea de carrito");
                                        window.location.href="principal.php";
                                </script>';
                    
                        }
                        
                    }
                    
                }
                else{
                    
                    echo '<script type="text/javascript">
                                alert("No se a podido conectar a la base de datos");
                                window.location.href="principal.php";
                        </script>';
                    
                }               
                
            }
            
            //Si no existe una fila con la nueva id...
            else{
                
                //Aqui insertaremos tanto en la tabla carrito como en la de línea de carrito
                $insert1="INSERT INTO carrito VALUES ('$idcarrito'); ";
                $insert2="INSERT INTO lineacarrito VALUES ('$idcarrito','$codigo','$cantidad'); ";
                
                //Si añade bien a la tabla carrito
                if($agregar1 = mysqli_query($conexion,$insert1)){
            
                    //Si añade bien a la tabla de línea de carrito...
                    if($agregar2 = mysqli_query($conexion,$insert2)){
                        
                        //Esta variable guarda cuantos artículos hay en el carrito
                        $_SESSION['numcarrito'] = $_SESSION['numcarrito'] + $cantidad;
                        
                        //Mensaje
                        echo '<script type="text/javascript">
                                    alert("Se ha añadido el artículo al carrito correctamente");
                                    window.location.href="principal.php";
                            </script>';
            
                    }
                    
                    //Si NO añade bien a la tabla línea de carrito...
                    else{
                        
                        //Mensaje
                        echo '<script type="text/javascript">
                                    alert("Error al agregar el artículo en la tabla línea de carrito");
                                    window.location.href="principal.php";
                            </script>';
                        
                    }
                
                }
                
                //Si NO añade bien a la tabla carrito...
                else{
                    
                    //Mensaje
                    echo '<script type="text/javascript">
                                alert("Error al agregar el artículo en la tabla carrito");
                                window.location.href="principal.php";
                        </script>';
                    
                }
            }
            
        }
        
        //Si hace MAL la conexión
        else {
            
            //Mensaje
            echo '<script type="text/javascript">
                        alert("Error al conectar a la base de datos");
                        window.location.href="principal.php";
                </script>';
            
        }
            
    }
    
    //Lo siguiente se hará si a la hora de darle a uno de los dos botones, se le da a el botón de COMPRAR
    if ($_POST['comprar']){
        
        if($_SESSION['codigo'] == 1){
            
            //Mensaje
            echo '<script type="text/javascript">
                        alert("Inicie sesión para efectuar su compra");
                        window.location.href="login.php";
                </script>';
            
        }
        else{
                        
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
            
            //Insertamos los datos del pedido en la tabla pedido
            $pedido = "insert into pedido values ('$numpedido',NOW(),'".$_SESSION['codigo'].")')";
            $realizarpedido = mysqli_query($conexion,$pedido);
            
            //Insertamos los datos del pedido en la tabla lineapedido
            $lineapedido = "insert into lineapedido values ('$codigo','$numpedido','$precio','$cantidad','$totalpedido')";
            $realizarlineapedido = mysqli_query($conexion,$lineapedido);
            
            //Restamos el stock del artículo pedido en la tabla artículo
            $restararticulo = "update articulo set stock = stock - '$cantidad' where codigo = '$codigo'";
            $resta = mysqli_query($conexion,$restararticulo);
            
            $_SESSION['factura'] = $numpedido;
            
            //Mensaje
            echo '<script type="text/javascript">
                        alert("Se ha realizado la compra correctamente");
                        window.location.href="pdf.php";
                </script>';
            
            
        }  
        
    }

?>