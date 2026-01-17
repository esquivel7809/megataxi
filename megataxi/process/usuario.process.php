<?php include('../Connections/conexion.php');
	include('validar.php');
	include('../libraries/javascript.php');
	
	
//	print_r($_POST);
	
	
switch($_POST[modo]){
	case 'add':
		$sql="insert into usuario(usuario,clave,nombre,perfil,estado)values('$_POST[usuario]','$_POST[clave]','$_POST[nombre]','$_POST[perfil]','$_POST[estado]');";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;
		
	case 'edit':
		$sql="update usuario set usuario='$_POST[usuario]',nombre='$_POST[nombre]',clave='$_POST[clave]',perfil='$_POST[perfil]',estado='$_POST[estado]' where id_usuario='$_POST[id_usuario]'";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;		
		
	case 'delete':
		$sql="delete from usuario where id_usuario='$_POST[id_usuario]'";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;				
}

	if($result){
		accion("Se ha realizado correctamente la accion","parent");
		ejecutar("parent.abrir('/megataxi/system/usuarios_body.php','','','content');");
	}

?>