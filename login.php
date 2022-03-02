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
                
                margin-top: -2%;
                
            }
            
        </style>
    </head>
    <body>
       
        <header>
           
            <a href="principal.php"><div id="logo"><img src="imagenes/logotipo.png" alt=""></div></a>  
            
            <div id="informacion">
               
                <a href="registro.php" id="registrar">Registrate aquí</a>
                
            </div>        
            
        </header>
        
        <article>
            <form id="formulario" action="validar.php" method="post">
               <ul>
                   
                   <img src="imagenes/favicon.png" alt="">
                   
                   <h2>Inicio de sesión</h2>
                               
                   <fieldset>
                        <legend align="left">Correo electrónico</legend>      
                        <li>
                            <label for="nombre"></label>
                            <input name="correo" class="superior" type="email" placeholder="" size="20" title="Introduzca su correo"  pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" autofocus autocomplete="on" required/>
                        </li>
                   </fieldset>
                   
                   <fieldset>
                       <legend align="left">Contraseña</legend>
                       <li>
                           <label for="contrasena"></label>
                           <input name="contrasena" type="password" title="Introduzca su contraseña" required/><br/><br/>
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