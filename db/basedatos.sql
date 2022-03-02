CREATE DATABASE reto2 DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_spanish_ci;

use reto2;

/* ------------------------------------- CREACIÓN DE TABLAS ------------------------------------- */

create table articulo
(codigo int(4) unsigned auto_increment primary key,
 nombre varchar(50) not null,
 imagen mediumblob,
 precioproveedor decimal(7,2) unsigned not null, 
 precioventa decimal(7,2) unsigned not null,
 descripcion varchar(200) not null,
 stock int(4) unsigned default 0);
 
create table carrito
(id int(4) unsigned primary key);
 
create table lineacarrito
(idcarrito int(4) unsigned,
 codigoarticulo int(4) unsigned,
 cantidad int(4) unsigned not null,
 primary key(idcarrito,codigoarticulo),
 foreign key(codigoarticulo) references articulo(codigo) on update cascade,
 foreign key(idcarrito) references carrito(id) on update cascade);
 
create table usuario
(codigo int(4) unsigned auto_increment primary key,
 nombre varchar(50) not null,
 correo varchar(100) not null,
 contrasena varchar(200) not null,
 tipo enum('usuario','admin','predeterminado') not null);

create table pedido
(codigo int(4) unsigned auto_increment primary key,
 fecha timestamp default current_timestamp,
 codigousuario int(4) unsigned not null,
 foreign key(codigousuario) references usuario(codigo) on update cascade);
 
create table lineapedido
(codigoarticulo int(4) unsigned,
 codigopedido int(4) unsigned,
 precio int(2) unsigned,
 cantidad int(4) unsigned not null,
 total decimal(7,2) unsigned,
 primary key(codigoarticulo,codigopedido),
 foreign key(codigoarticulo) references articulo(codigo) on update cascade,
 foreign key(codigopedido) references pedido(codigo) on update cascade);
 
create table rentabilidad
(codigo int(4) unsigned primary key,
 articulo varchar(50) not null,
 gastos decimal(7,2) unsigned default 0,
 cantidadcompra int(4) unsigned default 0,
 ingresos decimal(7,2) unsigned default 0,
 cantidadventa int(4) unsigned default 0,
 total decimal(7,2) unsigned default 0,
 fechadatos timestamp default current_timestamp);
  
/* ------------------------------------- TRIGGERs ------------------------------------- */
/* ------------------------------------- 1 ------------------------------------- */
delimiter //

create trigger unidadescompradas 
after update on articulo
for each row 
BEGIN
if NEW.stock > OLD.stock then
	
    update rentabilidad
    set cantidadcompra = (NEW.stock - OLD.stock) + cantidadcompra
    where codigo = OLD.codigo;
    
end if;
END//
delimiter ;

/* ------------------------------------- 2 ------------------------------------- */
delimiter //
create trigger inserciondatos
after insert on articulo
for each row 
BEGIN
	
    INSERT INTO `rentabilidad` (`codigo`, `articulo`, `fechadatos`) 
    VALUES (NEW.codigo, NEW.nombre, 'current_timestamp');
    
END//

delimiter ;




/* ------------------------------------- INSERCIONES EN LAS TABLAS ------------------------------------- */
 
 INSERT INTO `articulo` (`codigo`, `nombre`, `imagen`, `precioproveedor`, `precioventa`, `descripcion`, `stock`) VALUES 
 (NULL, 'Pop de Spiderman ', load_file('/xampp/htdocs/reto2/imagenes/1.png'), '12', '15', 'Pop de Spiderman ', '10'), 
 (NULL, 'Amiibo de Sonic', load_file('/xampp/htdocs/reto2/imagenes/2.png'), '25', '30', 'Amiibo de Sonic', '10'), 
 (NULL, 'Mochila Mushroom Nintendo ', load_file('/xampp/htdocs/reto2/imagenes/3.png'), '40', '45', 'Mochila Mushroom Nintendo ', '10'), 
 (NULL, 'Batman: Arkham Knight', load_file('/xampp/htdocs/reto2/imagenes/4.png'), '90', '100', 'Batman: Arkham Knight Estatuia Limited Edition', '10'), 
 (NULL, 'Dizfraz Roshi Dragon Ball ', load_file('/xampp/htdocs/reto2/imagenes/5.png'), '70', '80', 'Dizfraz Roshi Dragon Ball ', '10'), 
 (NULL, 'Pop Yu Gi Oh! ', load_file('/xampp/htdocs/reto2/imagenes/6.png'), '12', '15', 'Pop Yu Gi Oh! ', '10'), 
 (NULL, 'Sudadera Naruto ', load_file('/xampp/htdocs/reto2/imagenes/7.png'), '10', '16', 'Sudadera Naruto ', '10'), 
 (NULL, 'Snorlax Puff ', load_file('/xampp/htdocs/reto2/imagenes/8.png'), '115', '130', 'Snorlax Puff ', '10'), 
 (NULL, 'Harry Potter Grageas ', load_file('/xampp/htdocs/reto2/imagenes/9.png'), '4', '6', 'Harry Potter Grageas ', '10'), 
 (NULL, 'Llave Espada KH', load_file('/xampp/htdocs/reto2/imagenes/10.png'), '115', '130', 'Llave Espada Kingdom Hearts', '10'), 
 (NULL, 'Calendario Star Wars', load_file('/xampp/htdocs/reto2/imagenes/11.png'), '6', '10', 'Calendario Star Wars Classic ', '10'), 
 (NULL, 'Mochila Zelda ', load_file('/xampp/htdocs/reto2/imagenes/12.png'), '50', '60', 'Mochila Zelda ', '10'), 
 (NULL, 'Llavero Fornite ', load_file('/xampp/htdocs/reto2/imagenes/13.png'), '6', '8', 'Llavero Fornite ', '10'), 
 (NULL, 'Potara Dragon Ball ', load_file('/xampp/htdocs/reto2/imagenes/14.png'), '15', '20', 'Pendientes Potara Dragon Ball ', '10'), 
 (NULL, 'Sombrero Luffy One Piece ', load_file('/xampp/htdocs/reto2/imagenes/15.png'), '15', '20', 'Sombrero Luffy One Piece ', '10'), 
 (NULL, 'Peluche Agumon Digimon ', load_file('/xampp/htdocs/reto2/imagenes/16.png'), '20', '25', 'Peluche Agumon Digimon ', '10'), 
 (NULL, 'Alfombrilla Raton Saitama', load_file('/xampp/htdocs/reto2/imagenes/17.png'), '10', '15', 'Alfombrilla Raton Saitama One Punch Man', '10'), 
 (NULL, 'Manga Dragon Ball Super ', load_file('/xampp/htdocs/reto2/imagenes/18.png'), '15', '20', 'Pack Manga Dragon Ball Super ', '10'), 
 (NULL, 'Estatua Boku no Hero ', load_file('/xampp/htdocs/reto2/imagenes/19.png'), '35', '40', 'Estatua Boku no Hero ', '10'), 
 (NULL, 'Taza de Creeper ', load_file('/xampp/htdocs/reto2/imagenes/20.png'), '20', '25', 'Taza de Creeper ', '10');
 
 INSERT INTO `usuario` (`codigo`, `nombre`, `correo`, `contrasena`, `tipo`) VALUES 
 (NULL, 'Invitados', 'invitado@gmail.com', '123456Aa', 'predeterminado'), 
 (NULL, 'Aitor', 'aitor@gmail.com', 'toor', 'admin'), 
 (NULL, 'Ander', 'ander@gmail.com', 'toor', 'admin'), 
 (NULL, 'Diego', 'diego@gmail.com', '123456Aa', 'usuario'), 
 (NULL, 'Elver', 'elver@gmail.com', '123456Aa', 'usuario'), 
 (NULL, 'Elena', 'elena@gmail.com', '123456Aa', 'usuario'), 
 (NULL, 'Santiago', 'santiago@gmail.com', '123456Aa', 'usuario'), 
 (NULL, 'Mikel', 'mikel@gmail.com', '132456Aa', 'usuario'), 
 (NULL, 'Andoni', 'andoni@gmail.com', '123456Aa', 'usuario'), 
 (NULL, 'Asier', 'asier@gmail.com', '123456Aa', 'usuario');


/* ------------------------------------- EVENTO ------------------------------------- */
/* ------------------------------------- PRIMERO CREAMOS EL PROCEDIMIENTO ------------------------------------- */
delimiter //

create procedure rentabilidad ()
BEGIN 

/* Declaramos las variablas que vamos a necesitar*/
declare codarticulo int(4);
declare nomarticulo varchar(40);
declare sumcompra decimal(7,2) unsigned;
declare precompra decimal(7,2) unsigned;
declare cantcompra int(4) unsigned;
declare venta decimal(7,2) unsigned;
declare cantventa int(4) unsigned;
declare renta decimal(7,2) unsigned;
declare comprobar int(4) unsigned;
declare fin bool default 0;

/* Declaramos el cursor */
declare c cursor for select l.codigoarticulo, a.nombre, a.precioproveedor
					 from  articulo a join lineapedido l on a.codigo = l.codigoarticulo join pedido p on l.codigopedido = p.codigo
                     where a.codigo = l.codigoarticulo;
declare continue handler for not found set fin = 1;
open c;
fetch c into codarticulo, nomarticulo, precompra;

/* Si NO hay artículos */
if fin = 1 then 

	select concat('No hay artículos o este artículo no ha sido pedido')Mensaje;
    
/* Si hay artículos */
else 


	while fin = 0 do
    	
        select cantidadcompra
        into comprobar
        from rentabilidad
        where codigo = codarticulo;
        
        /* Comprabamos si se han comprado unidades de un artículo, de esta manera estaremos diciendo que si no se han comprado artículos, tampoco se habrán vendido, por lo que no será necesario hacer todo el procedimiento sobre los artículos que aun no hemos comprado  */
        if comprobar > 0 or codarticulo < 0 then 
            
            /* Consultamos en lineapedido la suma de todas las compras de un artículo */
            select SUM(total), SUM(cantidad)
            into venta, cantventa
            from lineapedido
            where codigoarticulo = codarticulo
            group by codigoarticulo;

            /* Consultamos la cantidad de unidades que hemos comprado de un artíciulo */
            select cantidadcompra
            into cantcompra
            from rentabilidad
            where codigo = codarticulo;

            /* Sacamos eL precio total sacando el producto entre el precio individual con el que compramos un artículo y la cantidades que hemos comprado de dicho artículo  */
            set sumcompra = precompra * cantcompra;

            /* Guardamos en la variable renta la diferencia entre el precio total de la compra de todas las unidades de un artículo y el precio total de todas las ventas de ese artículo */
            set renta = venta - sumcompra;

            /* Actualizamos la tabla rentabilidad con los datos obtenidos */
            update rentabilidad
            set gastos = sumcompra, ingresos = venta, cantidadventa = cantventa, total = renta, fechadatos = current_timestamp
            where codigo = codarticulo;  
            
        end if;
        
        fetch c into codarticulo, nomarticulo, precompra;
        
    end while;

end if;

close c;
END//

delimiter ;

/* ------------------------------------- AHORA CREAREMOS UN EVENTO QUE LLAMA AL PROCEDIMIENTO ------------------------------------- */

create event CalcularRentabilidad
on schedule every 1 day
starts current_timestamp
do
call rentabilidad();


/* ------------------------------------- ÍNDICES ------------------------------------- */

/* Estos indices servirán para agilizar las consulta que hacemos al logear desde la sitio web, allí consultamos los datos de un usuario que coincida con el correo y contraseña que nos indica el propio usuario del sitio */

create index EmailUsu
on usuario (correo DESC);

create index PassUsu
on usuario (contrasena DESC);


/* ------------------------------------- CREACIÓN DE LOS USUARIOS EN MYSQL -------------------------------------*/

CREATE USER 'Invitado'@'%' IDENTIFIED BY '123456Aa';
CREATE USER 'Invitado'@'localhost' IDENTIFIED BY '123456Aa';
GRANT SELECT ON reto2.* TO 'Invitado'@'%';
GRANT SELECT ON reto2.* TO 'Invitado'@'localhost';

CREATE USER 'Aitor'@'%' IDENTIFIED BY 'toor';
CREATE USER 'Aitor'@'localhost' IDENTIFIED BY 'toor';
GRANT ALL PRIVILEGES ON reto2.* TO 'Aitor'@'%' with grant option;
GRANT ALL PRIVILEGES ON reto2.* TO 'Aitor'@'localhost' with grant option;

CREATE USER 'Ander'@'%' IDENTIFIED BY 'toor';
CREATE USER 'Ander'@'localhost' IDENTIFIED BY 'toor';
GRANT ALL PRIVILEGES ON *.* TO 'Ander'@'%' with grant option;
GRANT ALL PRIVILEGES ON *.* TO 'Ander'@'localhost' with grant option;

CREATE USER 'Diego'@'%' IDENTIFIED BY '123456Aa';
CREATE USER 'Diego'@'localhost' IDENTIFIED BY '123456Aa';
GRANT SELECT ON reto2.* TO 'Diego'@'%';
GRANT SELECT ON reto2.* TO 'Diego'@'localhost';

CREATE USER 'Elver'@'%' IDENTIFIED BY '123456Aa';
CREATE USER 'Elver'@'localhost' IDENTIFIED BY '123456Aa';
GRANT SELECT ON reto2.* TO 'Elver'@'%';
GRANT SELECT ON reto2.* TO 'Elver'@'localhost';

CREATE USER 'Elena'@'%' IDENTIFIED BY '123456Aa';
CREATE USER 'Elena'@'localhost' IDENTIFIED BY '123456Aa';
GRANT SELECT ON reto2.* TO 'Elena'@'%';
GRANT SELECT ON reto2.* TO 'Elena'@'localhost';

CREATE USER 'Santiago'@'%' IDENTIFIED BY '123456Aa';
CREATE USER 'Santiago'@'localhost' IDENTIFIED BY '123456Aa';
GRANT SELECT ON reto2.* TO 'Santiago'@'%';
GRANT SELECT ON reto2.* TO 'Santiago'@'localhost';

CREATE USER 'Mikel'@'%' IDENTIFIED BY '123456Aa';
CREATE USER 'Mikel'@'localhost' IDENTIFIED BY '123456Aa';
GRANT SELECT ON reto2.* TO 'Mikel'@'%';
GRANT SELECT ON reto2.* TO 'Mikel'@'localhost';

CREATE USER 'Andoni'@'%' IDENTIFIED BY '123456Aa';
CREATE USER 'Andoni'@'localhost' IDENTIFIED BY '123456Aa';
GRANT SELECT ON reto2.* TO 'Andoni'@'%';
GRANT SELECT ON reto2.* TO 'Andoni'@'localhost';

CREATE USER 'Asier'@'%' IDENTIFIED BY '123456Aa';
CREATE USER 'Asier'@'localhost' IDENTIFIED BY '123456Aa';
GRANT SELECT ON reto2.* TO 'Asier'@'%';
GRANT SELECT ON reto2.* TO 'Asier'@'localhost';







