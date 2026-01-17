<?php
	include('../Connections/conexion.php');
	include('validar.php');
	include('../libraries/javascript.php');
	//echo $_POST['modo'];
	switch($_POST['modo']){
		case 'cancelar':
			$sql="update servicio set estado=3 where servicio_id='$_POST[servicio_id]'";
			$result=mysql_query($sql,$conexion)or die(mysql_error());
			if($result){
				ejecutar("parent.location.href='../system/index.php';");
			}
			break;	
		case 'manual':
			$clienteSql="select * from directorio where telefono='$_POST[telefono]'";
			$cliente=mysql_query($clienteSql,$conexion)or die(mysql_error());
			$row_cliente=mysql_fetch_assoc($cliente);
			if(mysql_num_rows($cliente)==0){
				$result_insert_cliente=mysql_query("insert into directorio(telefono,direccion,estado) values('$_POST[telefono]','".($_POST[direccion])."','$_POST[estado]')",$conexion);
			}
			if($result_insert_cliente){
				$usuario=$_SESSION[datos]->id_usuario;
				$sql="insert into servicio(telefono,seleccion,id_usuario,tipo_servicio,descripcion) values('$_POST[telefono]',1,'$usuario','$_POST[tipo_servicio]','".($_POST[descripcion])."')";
				ejecutar("alert('$sql')");
				$result=mysql_query($sql,$conexion)or die(mysql_error());
				if($result){
					$delete_llamada_actual="delete from llamada_actual where telefono='$_POST[telefono]'";
					$result_llamada_actual=mysql_query($delete_llamada_actual,$conexion)or die("Error actualizando llamada actual ".mysql_error());

					ejecutar("parent.location.href='../system/index.php';");
				}
			}
			break;

		case 'addDirectorio':
		
				$ivr=$_POST[sinIVR]?"0":"1";
				if(trim($_POST[direccion])!=""){
					$sql="insert into directorio(telefono,direccion,estado,ivr) values('".($_POST[telefono])."','".($_POST[direccion])."','2','$ivr')";
					$result=mysql_query($sql,$conexion)or die(mysql_error());
					if($result){
						$sql_servicio="insert into servicio(telefono,seleccion,id_usuario,tipo_servicio,descripcion) values('$_POST[telefono]','1','".$_SESSION[datos]->id_usuario."','$_POST[tipo_servicio]','".($_POST[descripcion])."')";
						$result_servicio=mysql_query($sql_servicio,$conexion)or die(mysql_error());
						if($result_servicio){
							$delete_llamada_actual="delete from llamada_actual where telefono='$_POST[telefono]'";
							$result_llamada_actual=mysql_query($delete_llamada_actual,$conexion)or die("Error actualizando llamada actual ".mysql_error());
						
							ejecutar("parent.location.href='../system/';");
						//exit();
						}
					}
				}else{
					alert("No se puede guardar un numero sin direccion");
				}
			break;
		case 'editDirectorio':
		
				$ivr=$_POST[sinIVR]?"0":"1";
				if(trim($_POST[direccion])!=""){
					$sql="update directorio set direccion = '".($_POST[direccion])."', estado='2', ivr='$ivr' where telefono='$_POST[telefono]'";
					$result=mysql_query($sql,$conexion)or die(mysql_error());
					if($result){
						$sql_servicio="insert into servicio(telefono,seleccion,id_usuario,tipo_servicio,descripcion) values('$_POST[telefono]','1','".$_SESSION[datos]->id_usuario."','$_POST[tipo_servicio]','".($_POST[descripcion])."')";
						$result_servicio=mysql_query($sql_servicio,$conexion)or die(mysql_error());
						if($result_servicio){
							$delete_llamada_actual="delete from llamada_actual where telefono='$_POST[telefono]'";
							$result_llamada_actual=mysql_query($delete_llamada_actual,$conexion)or die("Error actualizando llamada actual ".mysql_error());					
							ejecutar("parent.location.href='../system/';");
						}
					}				
				}else{
					alert("No se puede guardar un numero sin direccion");
				}
			break;

		case 'delete':
				$sql_servicio="delete from servicio where servicio_id='$_POST[servicio_id]' and id_usuario='".$_SESSION[datos]->id_usuario."'";
					$result_servicio=mysql_query($sql_servicio,$conexion)or die(mysql_error());
					if($result_servicio)
						ejecutar("parent.location.href='../system/servicios.php';");
				break;		
	
	}
?>