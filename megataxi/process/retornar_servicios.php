<?php 
	include('../Connections/conexion.php');
	mysql_query("update servicio set id_usuario=1, seleccion=0 where estado=1",$conexion);
?>