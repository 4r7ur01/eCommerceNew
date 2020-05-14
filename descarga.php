<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';

?>

<?php

print_r($_POST);

    $IDVENTA=openssl_encrypt($_POST['IDVENTA'],COD,key);
    $idProducto=openssl_encrypt($_POST['IDPRODUCTO'],COD,key);

    print_r($IDVENTA);
    print_r($idProducto);

    $sentencia=$pdo->prepare("SELECT * FROM 'tbldetalleventa'
    where IDVENTA=:IDVENTA
    and IDPRODUCTO=:IDPRODUCTO
    AND DESCARGADO<".DESCARGASPERMITIDAS);

    $sentencia->bindParam(":IDVENTA",$IDVENTA);
    $sentencia->bindParam(":IDPRODUCTO",$idProducto);
    $sentencia->execute();



    $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC)            ;
        print_r($listaProductos);


        if($sentencia->rowCount()>0){

            echo "Archivo en descarga...";

            $nombreArchivo="archivos/".$listaProductos[0]['IDPRODUCTO'].".pdf";

            $nuevoNombreArchivo=$_POST['IDVENTA'].$_POST['IDPRODUCTO'].".pdf";

            echo $nuevoNombreArchivo;

            header("Content-Transfer-Encoding: binary");
            header("Content-type:application/force-download");
            header("Content-Disposition: attachment; filename=$nuevoNombreArchivo");
            readfile("$nombreArchivo");



    $sentencia=$pdo->prepare("UPDATE 'tbldetalleventa' SET 
    decargado=descargado+1
    where IDVENTA=:IDVENTA
    and IDPRODUCTO=:IDPRODUCTO");

    $sentencia->bindParam(":IDVENTA",$IDVENTA);
    $sentencia->bindParam(":IDPRODUCTO",$idProducto);
    $sentencia->execute();


        }else{
            include 'templates/cabecera.php';
            echo"<br><br><br><br><br><br><h2>Tus descargas se agotaron</h2>";
            include 'templates/pie.php';
        }

?>










<?php

?>