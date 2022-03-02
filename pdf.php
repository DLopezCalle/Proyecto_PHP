<?php

require('fpdf/fpdf.php');
require('conexion.php');

if(!isset($_SESSION['factura'])){
    
    //Mensaje
    echo '<script type="text/javascript">
                alert("No tiene acceso a esta página");
                window.location.href="principal.php";
        </script>';
    
}

$numpedido = $_SESSION['factura'];


$consulta = "select l.cantidad, a.nombre, l.precio, DATE(p.fecha), p.codigo from articulo a join lineapedido l on a.codigo = l.codigoarticulo join pedido p on l.codigopedido = p.codigo where p.codigousuario = '".$_SESSION['codigo']."' and p.codigo = '$numpedido'";
$datos=mysqli_query($conexion,$consulta);


$consultapedido = "select DATE(fecha), codigo from pedido where codigousuario = '".$_SESSION['codigo']."' and codigo = '$numpedido'";
$datospedido=mysqli_query($conexion,$consultapedido);
$filapedido=mysqli_fetch_array($datospedido);

$fecha = $filapedido['DATE(fecha)'];
$codigopedido = $filapedido['codigo'];
//$preciototal = $fila['SUM(l.precio)'];

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('imagenes/favicon.png',170,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',22);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'FACTURA',0,0,'C');
    // Salto de línea
    $this->Ln(30);
    
    $servername = "localhost";
    $username = $_SESSION['usuario'];
    $password = $_SESSION['contrasena'];
    $db="reto2";

    $conexion=mysqli_connect($servername,$username,$password,$db);
    
    $consulta2 = "select * from usuario where codigo = '".$_SESSION['codigo']."'";
    $datos2 = mysqli_query($conexion,$consulta2);
    $fila2 = mysqli_fetch_array($datos2);
    $nombreusuario = $fila2['nombre'];
    $correo = $fila2['correo'];
    
    
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    $this->Cell(46, 7, 'Nombre Cliente: ', 0, 0, 'C',0);
    // Arial bold 15
    $this->SetFont('Arial','',12);
    $this->Cell(30, 7, $nombreusuario, 0, 1, 'C',0);
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    $this->Cell(64, 7, 'Correo: ', 0, 0, 'C',0);
    // Arial bold 15
    $this->SetFont('Arial','',12);
    $this->Cell(17, 7, $correo, 0, 1, 'C',0);
    
    
    
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}


                

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(40, 7, utf8_decode('Número de factura: '), 0, 0, 'C',0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(35, 7, $codigopedido, 0, 1, 'C',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(65, 7, 'Fecha: ', 0, 0, 'C',0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(5, 7, $fecha, 0, 0, 'C',0);
// Salto de línea
$pdf->Ln(30);
    
// Arial bold 15
$pdf->SetFont('Arial','B',16);
// Movernos a la derecha
$pdf->Cell(30);
$pdf->Cell(30, 10, 'Unidades', 0, 0, 'C',0);
$pdf->Cell(70, 10, 'Producto', 0, 0, 'C',0);
$pdf->Cell(30, 10, 'Precio Unitario', 0, 1, 'C',0);

$preciototal = 0;

while ($fila = mysqli_fetch_array($datos)){
        
    $cantidad = $fila['cantidad'];
    $nombre = $fila['nombre'];
    $precio = $fila['precio'];
    
    // Arial bold 15
    $pdf->SetFont('Arial','',12);
    // Movernos a la derecha
    $pdf->Cell(30);
    $pdf->Cell(30, 10, $cantidad, 0, 0, 'C',0);
    $pdf->Cell(70, 10, $nombre, 0, 0, 'C',0);
    $pdf->Cell(30, 10, $precio, 0, 1, 'C',0);
    
    
    $preciototal = $preciototal + $precio;
        
}
// Salto de línea
$pdf->Ln(20);

// Arial bold 15
$pdf->SetFont('Arial','B',16);
// Movernos a la derecha
$pdf->Cell(66);
$pdf->Cell(30, 10, 'Total: ', 0, 0, 'C',0);
// Arial bold 15
$pdf->SetFont('Arial','',16);
$pdf->Cell(5, 10, $preciototal, 0, 0, 'C',0);
$pdf->Cell(20, 10, 'euros', 0, 0, 'C',0);

$pdf->Output();

?>
























