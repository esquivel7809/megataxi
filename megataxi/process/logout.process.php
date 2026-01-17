<?php session_start();


if($_POST[salir_y_cerrar])
	include("email.reporte.servicios.php");

session_unregister('datos');
session_unset();
session_destroy();



?>

<script language="javascript">location.href="../";</script>
