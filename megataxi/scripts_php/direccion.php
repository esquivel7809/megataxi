<?php 

/*Busca una direccion dado un telefono e imprime un textarea con el nombre direccion*/

include('../Connections/conexion.php');

$sql="select direccion, ivr from directorio where telefono='$_GET[telefono]'";
$result=mysql_query($sql,$conexion)or die(mysql_error());

$row_direccion=mysql_fetch_assoc($result);

if(mysql_num_rows($result)==0){
	$ivr=1;
}else{
	$ivr=$row_direccion[ivr];
}


echo "<textarea name=\"direccion\" id=\"direccion\" cols=\"25\" rows=\"5\">$row_direccion[direccion]</textarea><br />";
echo "Desactivar IVR <input type=\"checkbox\" onfocus=\"(document.getElementById('descripcion').focus());\" name=\"sinIVR\" id=\"sinIVR\" value=\"1\"".(($ivr==0)?" checked=\"checked\"":"").">";

	if(mysql_num_rows($result)>0)
		echo "<input type=\"hidden\" name=\"modo\" value=\"editDirectorio\" />";
	else
		echo "<input type=\"hidden\" name=\"modo\" value=\"addDirectorio\" />";
?>