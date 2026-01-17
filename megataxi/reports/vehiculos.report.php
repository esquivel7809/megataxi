<?php
$fecha=date("Y-m-d h:i:s");
$nombre="vehiculos";
	  
include('../Connections/conexion.php');
include('../process/validar.php');



$sqlVehiculo="select vehiculo.*, tipo_vehiculo.nombre as tipo, propietario.nombre as propietario, estado_vehiculo.nombre as estadoVehiculo from vehiculo, tipo_vehiculo, propietario, estado_vehiculo where vehiculo.id_tipo=tipo_vehiculo.id_tipo and propietario.id_propietario=vehiculo.id_propietario and estado_vehiculo.id_estado=vehiculo.estado";


if($_GET[placa]!="")
	if($_GET[comparador1]=="=")
		$sqlVehiculo.=" and placa $_GET[comparador1] '$_GET[placa]'";
	else
		$sqlVehiculo.=" and placa $_GET[comparador1] '%$_GET[placa]%'";
	
	
if($_GET[color]!=""){
	if($_GET[comparador2]=="=")
		$sqlVehiculo.=" and color $_GET[comparador2] '$_GET[color]'";
	else
		$sqlVehiculo.=" and color $_GET[comparador2] '%$_GET[color]%'";	
}

if($_GET[pasajeros]!=""){
		$sqlVehiculo.=" and pasajeros $_GET[comparador3] '$_GET[pasajeros]'";
}

if($_GET[carga]!=""){
		$sqlVehiculo.=" and carga $_GET[comparador4] '$_GET[carga]'";
}

if($_GET[tipo]!=""){
		$sqlVehiculo.=" and id_tipo $_GET[comparador5] '$_GET[tipo]'";
}

if($_GET[propietario]!=""){
		$sqlVehiculo.=" and id_propietario $_GET[comparador6] '$_GET[propietario]'";
}

if($_GET[estado]!=""){
		$sqlVehiculo.=" and estado $_GET[comparador7] '$_GET[estado]'";
}

$vehiculos=mysql_query($sqlVehiculo,$conexion) or die(mysql_error());
$row_vehiculos=mysql_fetch_assoc($vehiculos);

	  header("Content-type: application/vnd.ms-excel");
	  header("Content-Disposition:  filename=\"reporte_$nombre$fecha.XLS\";");

?>
<style type="text/css">
<!--
.Estilo2 {
	font-size: 24px;
	font-weight: bold;
}
.Estilo5 {font-size: 16px}
.Estilo7 {font-size: 18px; font-weight: bold; }
-->
</style>


<table border="1" align="center">
	<tr><td colspan="7" align="center"><span class="Estilo2">Repote De Vehiculos</span></td>
	</tr>
  <tr>
    <td width="146"><div align="center"><span class="Estilo7">Placa</span></div></td>
    <td width="169"><div align="center"><span class="Estilo7">Color</span></div></td>
    <td width="140"><div align="center"><span class="Estilo7">Pasajeros</span></div></td>
    <td width="140"><div align="center"><span class="Estilo7">Carga</span></div></td>	
    <td width="140"><div align="center"><span class="Estilo7">Tipo</span></div></td>		
    <td width="140"><div align="center"><span class="Estilo7">Propietario</span></div></td>			
    <td width="140"><div align="center"><span class="Estilo7">Estado</span></div></td>				
  </tr>
  <?php do{ ?>
    <tr>
      <td><div align="justify"><span class="Estilo5"><?php echo $row_vehiculos['placa']; ?></span></div></td>
      <td><div align="justify"><span class="Estilo5"><?php echo $row_vehiculos['color']; ?></span></div></td>
      <td><div align="justify"><span class="Estilo5"><?php echo $row_vehiculos['pasajeros']; ?></span></div></td>
      <td><div align="justify"><span class="Estilo5"><?php echo $row_vehiculos['carga']; ?></span></div></td>	  	  
      <td><div align="justify"><span class="Estilo5"><?php echo $row_vehiculos['tipo']; ?></span></div></td>	  	  	  
      <td><div align="justify"><span class="Estilo5"><?php echo $row_vehiculos['propietario']; ?></span></div></td>	  	  	  	  
      <td><div align="justify"><span class="Estilo5"><?php echo $row_vehiculos['estadoVehiculo']; ?></span></div></td>	  	  	  	  	  
    </tr>
    <?php } while ($row_vehiculos = mysql_fetch_assoc($vehiculos)); ?>
</table>
