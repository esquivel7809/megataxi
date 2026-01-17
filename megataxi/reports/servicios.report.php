<?php
$fecha=date("Y-m-d h:i:s");
$nombre="servicios";
	  
include('../Connections/conexion.php');
include('../process/validar.php');


$datetime1=($_GET[fecha1]?$_GET[fecha1]:date("Y-m-d"))." ".($_GET[hora1]?$_GET[hora1]:"00").":".($_GET[min1]?$_GET[min1]:"00").":".($_GET[sec1]?$_GET[sec1]:"00");
$datetime2=($_GET[fecha2]?$_GET[fecha2]:date("Y-m-d"))." ".($_GET[hora2]?$_GET[hora2]:"23").":".($_GET[min2]?$_GET[min2]:"59").":".($_GET[sec2]?$_GET[sec2]:"59");

$sqlServicios="select servicio.*, estado_servicio.nombre as estadoServicio, directorio.direccion, usuario.nombre as usuario from servicio, estado_servicio, usuario, directorio where servicio.estado=estado_servicio.estado_id and servicio.telefono=directorio.telefono and servicio.id_usuario=usuario.id_usuario and 	(dt_llamada between '$datetime1' and '$datetime2')";

if($_GET[telefono]!=""){
	if($_GET[comparador1]=="like")
		$sqlServicios.=" and servicio.telefono $_GET[comparador1] '%$_GET[telefono]%'";
	else
		$sqlServicios.=" and servicio.telefono $_GET[comparador1] '%$_GET[telefono]%'";	
		
}

if($_GET[vehiculo]!=""){
	if($_GET[comparador1]=="like")
		$sqlServicios.=" and servicio.mega $_GET[comparador2] '%$_GET[vehiculo]%'";	
	else
		$sqlServicios.=" and servicio.mega $_GET[comparador2] '$_GET[vehiculo]'";
}

if($_GET[estado]!=""){
	$sqlServicios.=" and servicio.estado $_GET[comparador3] '$_GET[estado]'";
}

if($_GET[usuario]!=""){
	$sqlServicios.=" and servicio.id_usuario $_GET[comparador4] '$_GET[usuario]'";
}

//echo $sqlServicios;
$servicios=mysql_query($sqlServicios,$conexion)or die(mysql_error());
$row_servicios=mysql_fetch_assoc($servicios);



	  header("Content-type: application/vnd.ms-excel");
	  header("Content-Disposition:  filename=\"reporte_$nombre$fecha.XLS\";");

?>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 24px;
	font-weight: bold;
}
.Estilo2 {
	font-size: 18px;
	font-weight: bold;
}
.Estilo5 {font-size: 16px; font-style: italic; }
-->
</style>





<table border="1" align="center">
	<tr><td colspan="6"><div align="center" class="Estilo1">Servicios</div></td></tr>
  <tr class="tr_title">
    <td><div align="center" class="Estilo2">Telefono</div></td>
    <td><div align="center" class="Estilo2">Vehiculo</div></td>
    <td><div align="center" class="Estilo2">Estado</div></td>
    <td><div align="center" class="Estilo2">Hora de Llamada</div></td>
    <td><div align="center" class="Estilo2">Hora de Servicio</div></td>
    <td><div align="center" class="Estilo2">Usuario</div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><span class="Estilo5"><?php echo $row_servicios['telefono']; ?></span></td>
      <td><span class="Estilo5"><?php echo $row_servicios['mega']; ?></span></td>
      <td><span class="Estilo5"><?php echo $row_servicios['estadoServicio']; ?></span></td>
      <td><span class="Estilo5"><?php echo $row_servicios['dt_llamada']; ?></span></td>
      <td><span class="Estilo5"><?php echo $row_servicios['dt_recogida']; ?></span></td>
      <td><span class="Estilo5"><?php echo $row_servicios['usuario']; ?></span></td>
    </tr>
    <?php } while ($row_servicios = mysql_fetch_assoc($servicios)); ?>
</table>
<?php
mysql_free_result($servicios);
?>
