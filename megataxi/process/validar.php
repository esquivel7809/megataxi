<?php
session_start();



if($_SESSION["datos"]->usuario){
	$user=$_SESSION["datos"]->usuario;
	$pass=$_SESSION["datos"]->clave;

	$SqlValida="select * from usuario where usuario='".$user."' and clave='".$pass."' and estado='1'";

	$resultValidar=mysql_query($SqlValida,$conexion)or die(mysql_error());
	$usuario=mysql_fetch_object($resultValidar);	
	$_SESSION["datos"]=$usuario;		
	
	if(!mysql_num_rows($resultValidar)>0){
		die("Su session ha expirado o no ha iniciado ninguna session");
	}
	
}else{
	die("Usted No Ha Iniciado Ninguna Session, Sitio Restringido");
}



?>
