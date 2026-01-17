<?php 

require_once("../Connections/conexion.php");

$sql="UPDATE domicilios_com_contacto set estado=1 where id_domicilios_com_contacto='$_POST[id_domicilios_com_contacto]'";
echo $sql;
$result=mysql_query($sql,$conexion)or die(mysql_error());

?>