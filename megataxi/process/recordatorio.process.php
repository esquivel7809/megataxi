<?php include('../Connections/conexion.php');
	include('validar.php');
	include('../libraries/javascript.php');
	
	//print_r($_POST);
switch($_POST['modo']){

	case 'add':
		$SqlDatosTel="select telefono from directorio where telefono='".$_POST['telefono']."' ";
		$DatosTel=mysql_query($SqlDatosTel,$conexion)or die(mysql_error().$SqlDatosTel);
		if(mysql_num_rows($DatosTel)>0){
			$SqlUpdateDatosTel="update directorio set direccion='".$_POST['direccion']."' where telefono='".$_POST['telefono']."' ";
			$UpdateDatosTel=mysql_query($SqlUpdateDatosTel,$conexion)or die(mysql_error().$SqlUpdateDatosTel);
		}else{
			$SqlInsertTel="insert into directorio(telefono,direccion) values('".$_POST['telefono']."','".$_POST['direccion']."')";
			$InsertTel=mysql_query($SqlInsertTel,$conexion)or die(mysql_error().$InsertTel);
		}
		//$hora=$_POST['fecha']." ".$_POST['hora'].":".$_POST['min'].":".$_POST['seg'];
			$sql="insert into recordatorio(telefono,descripcion,hora) values('".$_POST['telefono']."','".$_POST['descripcion']."','".$_POST['fecha']." ".$_POST['hora'].":".$_POST['min'].":".$_POST['seg']."')"; 
			$result=mysql_query($sql,$conexion)or die(mysql_error());
		
		if($result){
			ejecutar("parent.accion('Se ingreso con exito el registro');parent.abrir('/megataxi/system/recordatorios_body.php','','','content');");	
		}
	
		break;
	case 'edit':
		$sql="update recordatorio set telefono='$_POST[telefono]', descripcion='$_POST[descripcion]', hora='$_POST[fecha] $_POST[hora]:$_POST[min]:$_POST[seg]' where id_recordatorio='$_POST[id_recordatorio]'";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;
	case 'lanzar':
		$numero=trim($_POST[telefono]);
		if(is_numeric($numero)){	
			$servicioSql="insert into servicio(telefono,id_usuario,estado) values('$numero','".$_SESSION[datos]->id_usuario."','1')";
			$servicio=mysql_query($servicioSql,$conexion)or die(mysql_error());
			if($servicio){
				$sql="update recordatorio set estado=2 where id_recordatorio='$_POST[id_recordatorio]'";
				$result=mysql_query($sql,$conexion)or die(mysql_error());
				if($result){
					ejecutar("parent.abrir('/megataxi/system/servicios_list.php','','','panel_servicios');");
				}else{
					alert("Error: Se lanzo el servicio pero no se pudo actualizar el recordatorio");
				}
			}else{
				alert("Error: No se pudo lanzar el servicio");
			}

		}
		break;	
	
	case 'cancelar':
		$sql="update recordatorio set estado=3 where id_recordatorio='$_POST[id_recordatorio]'";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		break;
	case 'delete':
		$sql="update recordatorio set estado=0 where id_recordatorio='$_POST[id_recordatorio]'";
		$result=mysql_query($sql,$conexion)or die(mysql_error());
		
		if($result){
			ejecutar("parent.accion('Se borr&oacute; con exito el registro');parent.abrir('/megataxi/system/recordatorios_body.php','','','content');");	
		}
				
		break;

}


?>
	





