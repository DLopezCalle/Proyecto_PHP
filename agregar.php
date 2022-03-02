<?php

    include('conexionadmin.php');

    //Asignamos variables a los datos que nos vienen del formulario del archivo registro.php
    $correo = $_POST['correo']; 
    $nombre = $_POST['nombre'];
    $contrasena = $_POST['contrasena'];

    //Consultamos si existe un usuario con el correo enviado
    $consulta="select * from usuario where correo = '$correo'";

    //Si hace bien la conexión...
    if ($datos=mysqli_query($conexion,$consulta)){
        
        //Si existen usuarios con los datos pasados con método post...
        if ($fila=mysqli_fetch_array($datos)){
            
            //Mensaje
            echo '<script type="text/javascript">
                        alert("Ya existe un usuario con estos datos. Por favor vuelva a intentarlo");
                        window.location.href="registro.php";
                </script>';
            
        }
        else{
            
            $insert="INSERT INTO usuario VALUES (NULL, '$nombre', '$correo', '$contrasena', 'usuario'); ";        
            
            //Si hace bien la inserción en nuestra base de datos (reto2)...
            if($agregar = mysqli_query($conexion,$insert)){
                
                //Creamos el usuario sql
                $usersql1="CREATE USER '$nombre'@'%' IDENTIFIED BY '$contrasena';";
                $usersql2="CREATE USER '$nombre'@'localhost' IDENTIFIED BY '$contrasena';";
                $crear1=mysqli_query($conexion,$usersql1);
                $crear2=mysqli_query($conexion,$usersql2);
                
                //Asignamos los permisos de vista a el usuario creado
                $grantsql1="GRANT SELECT ON reto2.* TO '$nombre'@'%';";
                $grantsql2="GRANT SELECT ON reto2.* TO '$nombre'@'localhost';";
                $permiso1=mysqli_query($conexion,$grantsql1);
                $permiso2=mysqli_query($conexion,$grantsql2);
                
                //Actualizamos los permisos para que no hayan problemas
                $refrescar="flush privileges;";
                $refrescame=mysqli_query($conexion,$refrescar);
                
                //Mensaje
                echo '<script type="text/javascript">
                            alert("El usuario se ha creado correctamente. Ahora puedes iniciar sesión :3");
                            window.location.href="login.php";
                    </script>';
                
            }
            else {
                
                //Mensaje
                echo '<script type="text/javascript">
                            alert("Error al agregar el usuario. Intentelo más tarde");
                            window.location.href="registro.php";
                    </script>';
                
            }
            
        }
        
    }
    else{
        
        //Mensaje
        echo '<script type="text/javascript">
                    alert("Error al conectar a la base de datos");
                    window.location.href="registro.php";
              </script>';
        
    } 

?>  