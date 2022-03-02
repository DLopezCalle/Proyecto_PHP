<?php

    session_start();    

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Soldado Otaku</title>
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="icon" type="image/png" href="imagenes/favicon.png">
        <style>
        
            form {
                
                margin-top: -5%;
                
            }
            footer {
                
                margin-top: 8.4%;
                
            }
            
        </style>
    </head>
    <body>
       
        <header>
           
            <a href="principal.php"><div id="logo"><img src="imagenes/logotipo.png" alt=""></div></a>  
            
            <div id="informacion">
               
                <a href="login.php" id="registrar">Iniciar sesión</a>
                
            </div>        
            
        </header>
        
        <article>
            <form id="formulario" action="agregar.php" method="post">
               <ul>
                   
                   <img src="imagenes/favicon.png" alt="">
                   
                   <h2>Datos de registro</h2>
                    
                   <fieldset>
                        <legend align="left">Correo electrónico</legend>      
                        <li>
                            <label for="nombre"></label>
                            <input class="superior" type="email" name="correo" placeholder="" size="20" title="Introduzca su correo"  pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" autofocus autocomplete="on" required/>
                        </li>
                   </fieldset>
                       
                   <fieldset>
                        <legend align="left">Nombre</legend>
                        <li>
                            <label for="nombre"></label>
                            <input type="text" name="nombre" pattern="[A-Za-z]{,}" title="Introduzca su nombre de usuario" autocomplete="on" autofocus required/>
                        </li>
                   </fieldset>
                   
                   <fieldset>
                       <legend align="left">Contraseña</legend>
                       <li>
                           <label for="contrasena"></label>
                           <input type="password" title="Introduzca su contraseña" name="contrasena" required/><br/><br/>
                       </li>
                   </fieldset>
                   <input type="submit" value="Enviar" id="boton"/> 
                   
               </ul>
            </form>
            </article>
        
        <!-- Nuesto gran pie de página -->
        <footer>
            Copyright © 2019. Todos los derechos reservados <br/>
            Aitor-Ander-Diego<br/>
            CIFP Txurdinaga LHII<br/>
        </footer>
        
    </body>
</html>