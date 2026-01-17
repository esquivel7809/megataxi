<?php 
session_start();
require_once('../Connections/conexion.php');
include('../libraries/javascript.php');
 ?>

<?php

if($_POST[usuario]&&$_POST[clave]){
	$user=$_POST[usuario];
	$pass=$_POST[clave]; 
	
	$SqlValida="select * from usuario where usuario='".$user."' and clave='".$pass."' and estado='1'";

	$result=mysql_query($SqlValida,$conexion)or die(mysql_error());
	if(mysql_num_rows($result)>0){
		$_SESSION[datos]=mysql_fetch_object($result);
		if($_SESSION[datos]->perfil==2){
		
			$sql_verifica_turno="select * from turno where fin like '%0000-00-00%' and id_usuario='".$_SESSION[datos]->id_usuario."'";
			$result_verifica=mysql_query($sql_verifica_turno,$conexion)or die(mysql_error());
			if(!mysql_num_rows($result_verifica)){
					$sql_turno="insert into turno(id_usuario) values('".$_SESSION[datos]->id_usuario."')";
					$result_turno=mysql_query($sql_turno,$conexion)or die(mysql_error());
			}
		}

		ejecutar("location.href='../system';");		
	}else{
		alert('Usuario y/o contraseña incorrecta o usuario inhabilitado por el administrador');
		ejecutar("location.href='../';");
	}
	
}else{
		alert('Debe escribir usuario y contraseña');
		ejecutar("location.href='../';");
}

?>