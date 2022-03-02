<?php 

    include('conexion.php');

    $correo = $_POST['correo'];
	$contrasena = $_POST['contrasena'];

    $consulta="select * from usuario where correo = '$correo' and contrasena = '$contrasena'";
    if ($datos=mysqli_query($conexion,$consulta)) {
        
        if ($fila=mysqli_fetch_array($datos)){
            
        //$tipo = $fila['tipo'];

        
            $_SESSION['correo'] = $correo;
            $_SESSION['contrasena'] = $contrasena;
            $_SESSION['usuario'] = $fila['nombre'];
            $_SESSION['codigo'] = $fila['codigo'];
            //session_write_close();
            
            if ($_SESSION['usuario'] != "'or'1'='1" and $_SESSION['contrasena'] != "'or'1'='1" ){
                      
            }
            else{
                echo '<script type="text/javascript">
                        alert("Deja de hackear payaso");
                        window.location.href="login.php";
                    </script>';
            }
            
            header('location:principal.php');
            
        }else{
            echo '<script type="text/javascript">
                    alert("No existe este usuario");
                    window.location.href="login.php";
                </script>';
        }
            
        }
    else{
            
        echo '<script type="text/javascript">
                alert("Error al conectar a la base de datos");
                window.location.href="login.php";
            </script>';
        }    

?>