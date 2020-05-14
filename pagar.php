<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>


<?php
if($_POST){
    $total=0;
    $SSID=session_id();
    $correo=$_POST['email'];
    $SSID=session_id();

    foreach($_SESSION['CARRITO'] as $indice=>$producto){
        $total=$total+($producto['precio']*$producto['cantidad']);
    }

    $sentecia==$pdo->prepare("INSERT INTO 'tblventa' 
    ('ID','ClaveTransaccion','PayPal','Fecha','Correo','Total','status') 
    values (null,:ClaveTransaccion,'',NOW(),:Correo,:total,'pendiente');");

    $sentecia->bindParam(":ClaveTransaccion",$SSID);
    $sentecia->bindParam(":Correo",$correo);
    $sentecia->bindParam(":total",$total);
    $sentecia->execute();
    $idVenta=$pdo->lastInsertId();

    foreach($_SESSION['CARRITO'] as $indice=>$producto){

    $sentecia==$pdo->prepare("INSER INTO 'tbldetalleventa' 
    ('ID','IDVENTA','IDPRODUCTO','PRECIOUNITARIO','CANTIDAD','DESCARGADO') 
    values (null,':IDVENTA',':IDPRODUCTO',':PRECIOUNITARIO',':CANTIDAD','0');");

    $sentecia->bindParam(":IDVENTA",$idVenta);
    $sentecia->bindParam(":IDPRODUCTO",$producto['id']);
    $sentecia->bindParam(":PRECIOUNITAROP",$producto['precio']);
    $sentecia->bindParam(":CANTIDAD",$producto['cantidad']);
    $sentecia->execute();

    }

    //echo "<h3>".$total."</h3>";
}
?>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<style>
   
    /* Media query for mobile viewport */
    @media screen and (max-width: 400px) {
        #paypal-button-container {
           width: 100%;
        }
    }
   
    /* Media query for desktop viewport */
    @media screen and (min-width: 400px) {
        #paypal-button-container {
           width: 250px;
            display: inline-block;
        }
    }
   
</style>

<div class="jumbotron text-center">
    <h1 class="display-4">¡PASO FINAL!</h1>
    <hr class="my-4">
    <p class="lead">Estas a punto de pagar con PayPal a cantidad de:
    <h4>S/.<?php echo number_format($total,2); ?></h4>
    <div id="paypal-button-container"></div>

    </p>
    <p>Los productos podran ser descargados una vez que se procese el pago <br/>
        <strong>(Para aclaraciones :scarlethuarhua@gmail.com)</strong>
    </p>
</div>


//PAYPAL

<script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        style: {
            label: 'checkout',  // checkout | credit | pay | buynow | generic
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'gold'   // gold | blue | silver | black
        },
 
        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create
 
        client: {
            sandbox:    'ARa8jsGPCmvrpGT7HE0KGsYHrlQcmNHcAJ-PNjQEAnMYEC0jMAXqRO7d4_lqhFoiQsQl7wZDV0PHQtX7',
            production: ''
        },
 
        // Wait for the PayPal button to be clicked
 
        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '<?php echo $total; ?>', currency: 'USD' },
                            description:"Compra de productos a eCommerce:<?php echo number_format($total,2);?>",
                            custom:"<?php $SSID; ?>#<?php echo openssl_encrypt($idVenta,COD,key); ?>"
                        }
                    ]
                }
            });
        },
 
        // Wait for the payment to be authorized by the customer
 
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                console.log(data);
                window.location="verificador.php?paymentToken="+data.paymentToken+"&paymentID"+data.paymentID;
            });
        }
   
    }, '#paypal-button-container');
 
</script>

<?php
include 'templates/pie.php';
?>