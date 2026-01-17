<?php

include('Connections/conexion.php');


$QueryVehiculos="select * from vehiculo, estado_vehiculo where vehiculo.estado=estado_vehiculo.id_estado and estado_vehiculo.nombre!='NO PAGO'";
$vehiculos=mysql_query($QueryVehiculos,$conexion);
while($row_vehiculos=mysql_fetch_assoc($vehiculos)){
         $UltimaSuspensionSql="select * from suspension_mega where vehiculo='$row_vehiculos[placa]' order by id_suspension desc limit 1";


       $UltimaSuspension=mysql_query($UltimaSuspensionSql,$link);

       $SqlUpdate="update vehiculo set estado='1'";
  	echo $row_vehiculos[placa];
}



?>