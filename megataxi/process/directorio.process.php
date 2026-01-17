<?php include('../Connections/conexion.php');
	include('validar.php');
	include('../libraries/javascript.php');
	
	
//	print_r($_POST);
	
	
switch($_POST[modo]){
	case 'add':
			$result=mysql_query("insert into directorio(telefono,direccion,estado) values('$_POST[telefono]','$_POST[direccion]','$_POST[estado]')",$conexion)or die(mysql_error());
		break;
	case 'new_automatic':
			$sqlDirectorio="update directorio set direccion='$_POST[direccion]', estado='$_POST[estado]' where telefono = '$_POST[telefono]'";
			echo $sqlDirectorio;
			$result=mysql_query($sqlDirectorio,$conexion)or die(mysql_error());
			
			
			if($result){
				$sqlServicio="insert into servicio(telefono) values('$_POST[telefono]')";
				echo $sqlServicio;
				$result_servicio=mysql_query($sqlServicio,$conexion)or die(mysql_error());
				if($result_servicio){
					ejecutar("parent.cerrar_edicion();");
				}
			}
		break;
	case 'edit':
		$result=mysql_query("update directorio set telefono='$_POST[telefono]', direccion='$_POST[direccion]' where telefono='$_POST[telefono_ant]'",$conexion);	
		break;
	case 'delete':
			$result=mysql_query("delete from directorio where telefono='$_POST[telefono]'",$conexion);
		break;
}
?>