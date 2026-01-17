<?php 
	include('../libraries/javascript.php');
	include('../Connections/conexion.php');
	include('../process/validar.php');
	$sql="update servicio set mega='$_POST[RMegaTxt]', id_usuario='".$_SESSION['datos']->id_usuario."', estado=2, dt_recogida='".date("Y-m-d h:i:s")."' where servicio_id='$_POST[RServicio_idTxt]';";
	$result=mysql_query($sql,$conexion) or die(mysql_error());
	if($result){
		$direccion=mysql_query("select directorio.direccion from directorio, servicio where servicio.telefono=directorio.telefono and servicio.servicio_id='$_POST[RServicio_idTxt]'",$conexion);
		$row_direccion=mysql_fetch_assoc($direccion);
		//alert("El mega $_POST[RMegaTxt] ha recogido el pasajero de $row_direccion[direccion]");
		ejecutar("parent.location.href='../system/index.php';");
//		ejecutar("parent.abrir('/megataxi/system/servicios_list.php','','','panel_servicios');");	
		mysql_free_result($direccion);	
	}
	mysql_free_result($result);
?>