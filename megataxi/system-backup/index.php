<?php
	include('../Connections/conexion.php');
        include('../process/validar.php');
	if($_SESSION[datos]->perfil==1)
		$page='servicios_body.php';
	else
		$page='registro.php';
	$title='Sistema de Control De servicios Megataxi';
	include('frame.php');
?>
