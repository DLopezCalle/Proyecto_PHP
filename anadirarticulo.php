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

    $nombre = $_POST['nombre'];
    $preciocompra = $_POST['preciocompra'];
    $precioventa = $_POST['precioventa'];
    $descripcion = $_POST['descripcion'];
    $stock = $_POST['stock'];

    //Para darle valor al nuevo código de articulo, contamos los códigos de articulo almacenos en la base de datos
    $numfila = "select count(codigo) from articulo";
    $datosfila = mysqli_query($conexion,$numfila);
    $filaarticulo = mysqli_fetch_array($datosfila);
            
    //Si no existe ninguna pedido
    if ($filaarticulo['count(codigo)'] == null){
                
        //El código de este pedido será igual a 1
        $numarticulo = 1;
                
    }
    //Si ya existe un/os códigos de articulo
    else{
                
        //Contamos todos los código y el nuevo código será el resultado de la cuenta + 1
        $numarticulo = $filaarticulo['count(codigo)'] + 1;
                
    }

    /* Para la imagen... */
if((isset($_FILES['imagen'])) && ($_FILES['imagen'] !='')){
    $file = $_FILES['imagen']; //Asignamos el contenido del parametro a una variable para su mejor manejo
		
    $temName = $file['tmp_name']; //Obtenemos el directorio temporal en donde se ha almacenado el archivo;
    $fileName = $file['name']; //Obtenemos el nombre del archivo
    $fileExtension = substr(strrchr($fileName, '.'), 1); //Obtenemos la extensiÃ³n del archivo.
		
    //Comenzamos a extraer la informaciÃ³n del archivo
    $fp = fopen($temName, "rb");//abrimos el archivo con permiso de lectura
    $contenido = fread($fp, filesize($temName));//leemos el contenido del archivo
    //Una vez leido el archivo se obtiene un string con caracteres especiales.
    $contenido = addslashes($contenido);//se escapan los caracteres especiales
    fclose($fp);//Cerramos el archivo
}

    $anadir = "insert into articulo (nombre, imagen, precioproveedor, precioventa, descripcion, stock) values ('$nombre','".$contenido."','$preciocompra','$precioventa','$descripcion','$stock')";

    if($actualizar = mysqli_query($conexion,$anadir)){
        
        echo '<script type="text/javascript">
                    alert("El artículo se ha añadido correctamente");
                    window.location.href="articulos.php";
                </script>';
        
    }
    else{
        
        echo '<script type="text/javascript">
                    alert("Error al añadir el artículo");
                    window.location.href="articulos.php";
                </script>';
        
    }
    

    

?>    