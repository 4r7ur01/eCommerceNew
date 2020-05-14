<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/cabecera.php';
?>
        <br>

        <?php if($mensaje!=""){?>
        <div class="alert alert-success">
        
        <?php echo ($mensaje);?>

            <a href="mostrarCarrito.php" class="badge.succes">Ver carrito</a> 
        </div>
        <?php }?>

        <div class="row">

            <?php
            $sentencia=$pdo->prepare("SELECT * FROM tblproductos");
            $sentencia->execute();
            $listaProducto=$sentencia->fetchAll(PDO::FETCH_ASSOC);
            //print_r($listaProducto);
            ?>

            <?php foreach($listaProducto as $producto){ ?>

                <div class="col-3">
                                <div class="card">
                                    <img
                                        title="<?php echo $producto['nombre']; ?>"
                                        alt="titulo"
                                        class="card-img-top" 
                                        src="<?php echo $producto['Imagen']; ?>" 
                                        data-toggle="popover"
                                        data-trigger="hover"
                                        data-content="<?php echo $producto['Descripcion']; ?>"
                                        height="317px"
                                    >
                                <div class="card-body">
                                        <span><?php echo $producto['nombre']; ?></span>
                                        <h5 class="card-title">S/.<?php echo $producto['Precio']; ?> so</h5>
                                        <p class="card-text">Descripcion</p>

                                        <form action="" method="">

                                        <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['Id'],COD,key);?>">
                                        <input type="hidden" name="nombre" id="nombre" value="<?php echo  openssl_encrypt($producto['nombre'],COD,key);?>">
                                        <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'],COD,key);?>">
                                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1,COD,key);?>">

                                            <button 
                                            class="btn btn-primary" 
                                            name="btnAccion" 
                                            value="Agregar" 
                                            type="submit">Agregar al producto
                                        </button>
                                        </form>


                                       
                                </div>
                            </div>    
                        </div>
            <?php } ?>


            <?php foreach($listaProducto as $producto){ ?>
                <div class="col-3">
                                <div class="card">
                                    <img
                                        title="<?php echo $producto['nombre']; ?>"
                                        alt="titulo"
                                        class="card-img-top" 
                                        src="<?php echo $producto['Imagen']; ?>" 
                                        data-toggle="popover"
                                        data-trigger="hover"
                                        data-content="<?php echo $producto['Descripcion']; ?>"
                                        height="317px"
                                    >
                                <div class="card-body">
                                    <span><?php echo $producto['nombre']; ?></span>
                                        <h5 class="card-title">S/.<?php echo $producto['Precio']; ?> so</h5>
                                        <p class="card-text">Descripcion</p>

                                        <form action="" method="">

                                        <input type="hidden" name="i" id="id" value="<?php echo openssl_encrypt($producto['Id'],COD,key);?>">
                                        <input type="hidden" name="nombre" id="<?php echo  openssl_encrypt($producto['nombre'],COD,key);?>">
                                        <input type="hidden" name="precio" id="<?php echo openssl_encrypt($producto['Precio'],COD,key);?>">
                                        <input type="hidden" name="cantidad" id="<?php echo openssl_encrypt(1,COD,key);?>">


                                            <button 
                                            class="btn-principal" 
                                            name="btnAccion" 
                                            value="Agregar" 
                                            type="submit">Agregar al producto
                                        </button>
                                        </form>


                                       
                                </div>
                            </div>    
                        </div>
            <?php } ?>

            <?php foreach($listaProducto as $producto){ ?>
                <div class="col-3">
                                <div class="card">
                                    <img
                                        title="<?php echo $producto['nombre']; ?>"
                                        alt="titulo"
                                        class="card-img-top" 
                                        src="<?php echo $producto['Imagen']; ?>" 
                                        data-toggle="popover"
                                        data-trigger="hover"
                                        data-content="<?php echo $producto['Descripcion']; ?>"
                                        height="317px"
                                    >
                                <div class="card-body">
                                    <span><?php echo $producto['nombre']; ?></span>
                                        <h5 class="card-title">S/.<?php echo $producto['Precio']; ?> so</h5>
                                        <p class="card-text">Descripcion</p>

                                        <form action="" method="">

                                        <input type="hidden" name="i" id="id" value="<?php echo openssl_encrypt($producto['Id'],COD,key);?>">
                                        <input type="hidden" name="nombre" id="<?php echo  openssl_encrypt($producto['nombre'],COD,key);?>">
                                        <input type="hidden" name="precio" id="<?php echo openssl_encrypt($producto['Precio'],COD,key);?>">
                                        <input type="hidden" name="cantidad" id="<?php echo openssl_encrypt(1,COD,key);?>">


                                            <button 
                                            class="btn-principal" 
                                            name="btnAccion" 
                                            value="Agregar" 
                                            type="submit">Agregar al producto
                                        </button>
                                        </form>


                                       
                                </div>
                            </div>    
                        </div>
            <?php } ?>

            
 
            
            
    </div>  
    </div>  
<script>
    $(function () {
  $('[data-toggle="popover"]').popover()
    })
</script>


<?php
include 'templates/pie.php';
?>
