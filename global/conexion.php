<?php
//include "../global/config.php";

//$servidor="mysql:dbnamne=".bd.";host=".servidor;



try{

    //$pdo=new PDO($servidor,user,pass);
    	//array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8");
   // echo "<script>alert('La concexion se realizo correctamente')</script>";

	//$pdo = new PDO('mysql:host='.servidor';dbname='bd', 'root', '');
	$pdo = new PDO('mysql:host=localhost;dbname=tienda', 'root', '');
}catch(PDOException $e){
    //echo "<script>alert('Ocurrio un error al conectarse.')</script>".$e->getMessage();

}





?>