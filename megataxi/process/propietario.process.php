<?php include('../Connections/conexion.php');
	include('validar.php');
	include('../libraries/javascript.php');
	
	
//	print_r($_POST);
	
	
switch($_POST[modo]){
	case 'add':
		$sql="insert into propietario(documento,nombre,direccion,telefono,notas)values('$_POST[documento]','$_POST[nombre]','$_POST[direccion]','$_POST[telefono]','$_POST[notas]');";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;
		
	case 'edit':
		$sql="update propietario set documento='$_POST[documento]',nombre='$_POST[nombre]',direccion='$_POST[direccion]',telefono='$_POST[telefono]',notas='$_POST[notas]' where id_propietario='$_POST[id_propietario]'";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;		
		
	case 'delete':
		$sql="delete from propietario where id_propietario='$_POST[id_propietario]'";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;				
}

	if($result){
		accion("Se ha realizado correctamente la accion","parent");
		ejecutar("parent.abrir('/megataxi/system/propietarios_body.php','','','content');");
	}

?>