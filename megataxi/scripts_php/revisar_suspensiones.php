<?php

include('../Connections/conexion.php');
include('../scripts_php/libreria.php');

$SqlSuspendidos="select * from vehiculo where estado=2";
$Suspendidos=mysql_query($SqlSuspendidos,$conexion)or die(mysql_error());

while($row_suspendidos=mysql_fetch_assoc($Suspendidos)){





}