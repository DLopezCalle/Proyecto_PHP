<?php 

    include('conexionadmin.php');

    $idcarrito = $_SESSION['idcarrito'];
    $codigoarticulo = $_POST['code'];
    $cantidad = $_POST['cantidad'];

    $borrarlineacarrito = "delete from lineacarrito where idcarrito = '$idcarrito' and codigoarticulo = '$codigoarticulo'";
    $aplicarlineacarrito = mysqli_query($conexion,$borrarlineacarrito);

    $_SESSION['numcarrito'] = $_SESSION['numcarrito'] - $cantidad;

    header('location:carrito.php');

?>