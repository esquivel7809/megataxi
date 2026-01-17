<?php include('../Connections/conexion.php');
	include('validar.php');
	include('../libraries/javascript.php');
	
	
//	print_r($_POST);
	
	
switch($_POST[modo]){
	case 'add':
			$result=mysql_query(utf8_encode("insert into mensaje(texto,placa) values ('$_POST[texto]','$_POST[vehiculo]')"),$conexion);
			if($result){
				ejecutar("parent.location.href='/megataxi/system/mensajes.php';");
			}
		break;
	case 'entregado':
			$result=mysql_query("update mensaje set estado = '1' where id_mensaje='$_POST[id_mensaje]'",$conexion)or die(mysql_error());
			if($result){
				ejecutar("parent.location.href='/megataxi/system/mensajes.php';");
			}
		break;		
}
?>