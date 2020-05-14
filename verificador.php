<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>

<?php
print_r($_GET);

$Login=curl_init(LINKAPI."/v1/oauth2/token");

    curl_setopt($Login,CURLOPT_RETURNTRANSFER,TRUE);
    curl_setopt($Login,CURLOPT_USERPWD,CLIENTID.":".SECRET);
    curl_setopt($Login,CURLOPT_POSTFIELDS,"grant_type=clent_credentials");

    $Respuesta=curl_exec($Login);

    
    $objetoRespuesta=json_decode($Respuesta);

    $AccessToken=$objetoRespuesta->access_token;

    print_r($AccessToken);

    $venta=curl_init(LINKAPI."/v1/payments/payment/".$_GET['paymentID']);

    curl_setopt($venta,CURLOPT_HTTPHEADER,array("Content-Type: application/json","Authorization: Bearer ",$AccessToken));

    curl_setopt($venta,CURLOPT_RETURNTRANSFER,TRUE);

    $RespuestaVenta=curl_exec($venta);

    //print_r($RespuestaVenta);

    $objDatosTransaccion=json_decode($RespuestaVenta);

    //print_r($objDatosTransaccion->payer->payer_info->email);

    $state=$objDatosTransaccion->state; 

    $email=$objDatosTransaccion->payer->payer_info->email;

    $total=$objDatosTransaccion->transaccion[0]->amount->total;

    $currency=$objDatosTransaccion->transaccion[0]->custom->currency;

    $custom=$objDatosTransaccion->transaccion[0]->custom;    

    print_r($custom);

    $clave=explode("#",$custom);

    $SSID=$clave[0];

    $claveVenta=openssl_decrypt($clave[1],COD,key); 

    print_r($claveVenta);

    curl_close($venta);
    curl_close($Login);

    //echo $claveVenta;

    if($state=="aproved"){
        $mensajePaypal="<h3>Pago aprobado</h3>";
        $sentencia=$pdo->prepare("UPDATE 'tblventas' 
        SET 'PaypalDatos' = :PaypalDatos,
        'status' = 'aprobado.' 
        WHERE 'tblventas'.'ID' = :ID;");

        $sentencia->bindParam(":ID",$claveVenta);
        $sentencia->bindParam(":PaypalDatos",$RespuestaVenta);
        $sentencia->execute();


        $sentencia=$pdo->prepare("UPDATE 'tblventas' 
        SET 'status' = 'completo' 
        WHERE ClaveTransaccion=:ClaveTransaccion
        and Total=:TOTAL
        and ID=:ID");

        $sentencia->bindParam(":ClaveTransaccion",$SSID);
        $sentencia->bindParam(":TOTAL",$total);
        $sentencia->bindParam(":ID",$claveVenta);
        $sentencia->execute();
+
        $completo=$sentencia->rowCount();

        session_destroy();
        
    }else{
        $mensajePaypal="<h3>Hubo un problema con el pago</h3>";
    }

    //echo $mensajePaypal;
?>



<div class="jumbotron">
    <h1 class="display-4">¡LISTO!</h1>

    <hr class="my-4">

    <p class="lead"><?php echo $mensajePaypal; ?></p>  

    <p>
        <?php
        if($completo>=1){

        $sentencia=$pdo->prepare("SELECT * FROM tblventas,tblproducto
        where tbldetalleventa.IDPRODUCTO=tblprodcuto.ID 
        and tbldetalleventa.IDVENTA=:ID");

        $sentencia->bindParam(":ID",$claveVenta);
        $sentencia->execute();

        $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC)            ;
        print_r($listaProductos);

        }
        ?>

        <div class="row">
            <?php foreach($listaProductos as $producto){ ?>
            <div class="col-3">
            <div class="card">

                <img class="card-img-top" src="<?php echo $producto['Imagen']; ?>" alt="">
                <div class="card-body">
                
                <p class="card-text"><?php echo $producto['Nombre']; ?></p>

                <?php if($producto['DESCARGADO']<DESCARGASPERMITIDAS){ ;?>

                    <form action="descarga.php" method="post">

                    <input type="hidden" name="IDVENTA" id="" value="<?php echo openssl_encrypt($claveVenta,COD,key);?>">
                    <input type="hidden" name="IDPRODUCTO" id="" value="<?php echo openssl_encrypt($producto['IDPRODUCTO'] ,COD,key);?>">
                    
                    <button class="btn btn-success" type="submit">Descarga</button>

                    </form>
                <?php }else{ ?>

                <button class="btn btn-success" type="button" disabled></button>
                    <?php } ?>
                </div>
            </div>
            </div>
            <?php }?>
        </div>
    </p>
</div>

<?php
include 'templates/pie.php';
?>
