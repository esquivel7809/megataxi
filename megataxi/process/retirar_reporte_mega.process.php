<?php /*
| reporte_id  | int(11)     | NO   | PRI | NULL    | auto_increment |
| mega        | varchar(10) | NO   | MUL | NULL    |                |
| servicio_id */

	include('../Connections/conexion.php');
	include('../process/validar.php');
	
	$sql="update reporte_mega_a_servicio set estado=0 where mega='$_POST[RMegaTxt]' and servicio_id='$_POST[RServicio_idTxt]'";

	$result=mysql_query($sql,$conexion) or die(mysql_error());

	if($result){
		echo "<script language='javascript'>";
		echo "alert('Se inserto el reporte correctamente');";
	}else{
		echo "alert('No se pudo insertar el cosito');";
	}
	
?>