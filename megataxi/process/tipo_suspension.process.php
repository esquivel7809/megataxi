<?php include('../Connections/conexion.php');
	include('validar.php');
	include('../libraries/javascript.php');
	
	
//	print_r($_POST);
	
	$duracion=($_POST[unidad]=='h')?$_POST[duracion]:($_POST[duracion]*24);
	
	
switch($_POST[modo]){
	case 'add':
		$sql="insert into tipo_suspension(nombre,duracion)values('$_POST[nombre]','$duracion');";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;
		
	case 'edit':
		$sql="update tipo_suspension set nombre='$_POST[nombre]' ,duracion='$duracion' where id_tipo='$_POST[id_tipo]'";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;		
		
	case 'delete':
		$sql="delete from tipo_suspension where id_tipo='$_POST[id_tipo]'";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;				
}

	if($result){
		accion("Se ha realizado correctamente la accion","parent");
		ejecutar("parent.abrir('/megataxi/system/tipo_suspension_body.php','','','content');");
	}

?>