<?php include('../Connections/conexion.php');
	include('validar.php');
	include('../libraries/javascript.php');
	
	
//	print_r($_POST);
	
	
switch($_GET[modo]){
	case 'delete':
			//$result=mysql_query("delete from llamada_actual where telefono='$_GET[telefono]'",$conexion);
			$result=mysql_query("delete from llamada_actual where id_llamada_actual='$_GET[id_llamada_actual]'",$conexion);
			if($result){
				ejecutar("parent.abrir('/megataxi/forms/llamadas_actuales.php','','','div_llamadas_actuales');");
			}
		break;
}
?>