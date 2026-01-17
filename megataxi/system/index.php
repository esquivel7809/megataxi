<?php
	include('../Connections/conexion.php');
    include('../process/validar.php');
	//print_r($_SESSION["datos"]);
	//usuarios administrativos
	if($_SESSION["datos"]->perfil==1){
		$page='servicios_body.php';
	}
	//usuarios operativos
	else{
		$page='registro.php';
	}
	$title='Sistema de Control De servicios Megataxi';

	include('frame.php');
?>
