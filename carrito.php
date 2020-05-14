<?php
session_start();

$mensaje="";


if(isset($_POST['btnAccion'])){
    switch($_POST['btnAccion']){

        case 'Agregar':

            if(is_numeric( openssl_decrypt($_POST['id'],COD,key))){
                $id=openssl_decrypt($_POST['id'],COD,key);
                $mensaje.="Ok, Id, correcto".$id."<br/>";    
            }else{
                $mensaje.="Upppps.. Id incorrecto".$id."<br/>";
            }

            if(is_string(openssl_decrypt($_POST['nombre'],COD,key))){
                $NOMBRE=openssl_decrypt($_POST['nombre'],COD,key);
                $mensaje.="Ok Nombre".$NOMBRE."<br/>";
            }else{
                $mensaje.="Upppp... algo pasa con el nombre ".$NOMBREe."<br/>"; break; }
            
            if(is_numeric(openssl_decrypt($_POST['cantidad'],COD,key))){
                $CANTIDAD=openssl_decrypt($_POST['cantidad'],COD,key);
                $mensaje.="Ok Cantidad".$CANTIDAD."<br/>";
            }else{
                $mensaje.="Upppppp.... algo pasa con la cantidad"."<br/>"; break; }
            
            if(is_numeric(openssl_decrypt($_POST['precio'],COD,key))){
                $PRECIO=openssl_decrypt($_POST['precio'],COD,key);
                $mensaje.="Ok Precio".$PRECIO."<br/>";
            }else{
                $mensaje.="Uppppppp.... algo pasa con el precio"."<br/>"; break; }

                if(!isset($_SESSION['CARRITO'])){
                    $producto=array(
                        'id'=>$id,
                        'nombre'=>$NOMBRE,
                        'cantidad'=>$CANTIDAD,
                        'precio'=>$PRECIO
                    );
                
    $_SESSION['CARRITO'][0]=$producto;
    $mensaje="Producto agregado al carrito";
                
    }else{
        $idProducto=array_column($_SESSION['CARRITO'],"id");
      if(in_array($id,$idProducto)){
        echo"<script>alert('El producto ya ha sido selecionado...');</Script)";
      }else{   
       
    $NumeroProducto=count($_SESSION['CARRITO']);
    $producto=array(
        'id'=>$id,
        'nombre'=>$NOMBRE,
        'cantidad'=>$CANTIDAD,
        'precio'=>$PRECIO
    );

    $_SESSION['CARRITO'][$NumeroProducto]=$producto;
    $mensaje="Producto agregado al carrito";
}
}
        //$mensaje=print_r($_SESSION,TRUE);
        

        break;


    case 'eliminar';
         if(is_numeric( openssl_decrypt($_POST['id'],COD,key))){
                $id=openssl_decrypt($_POST['id'],COD,key);
                
                foreach($_SESSION['CARRITO'] as $indice=>$producto){
                    if($producto['id']==$id){
                        unset($_SESSION['CARRITO'][$indice]);
                        echo"<scrip>alert('Elemento borrado...');</script>";
                    }
                }
                
            }else{
                $mensaje.="Upppps.. Id incorrecto".$id."<br/>";
            }
    break;

   }
}

?>