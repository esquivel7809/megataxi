<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_servicios = "SELECT servicio.servicio_id, servicio.telefono, direccion, servicio.dt_llamada, servicio.web FROM servicio, directorio WHERE servicio.telefono=directorio.telefono and servicio.estado=1 and servicio.seleccion=0 order by dt_llamada desc limit 5";
$servicios = mysql_query($query_servicios, $conexion) or die(mysql_error());
$row_servicios = mysql_fetch_assoc($servicios);
$totalRows_servicios = mysql_num_rows($servicios);
?>

<?php
if($totalRows_servicios>0){
?>
<div class="panel panel-default">
<!-- Default panel contents -->
<div class="panel-heading" id="content">Servicios Automáticos</div>

<table class="table table-bordered" >
  <tr >
    <td colspan="">Telefono</td>
    <td width="130">Direccion</td>
    <td>Hora</td>
	<td colspan="2">Accion</td>
  </tr>
  <?php do { ?>
    <tr <?php echo ($row_servicios["web"])?" class=\"servicio_domicilios_com\"":"";?>>
      <?php /*?><td align="right"><?php echo ($row_servicios["web"])?"<img src=\"../images/favicondomicilios.png\" height=\"16\" width=\"16\">":"";?> 
	  <a href="../llamar.php?numero=<?php echo $row_servicios['telefono']; ?>" target="IFrameProcess">
		  <?php echo $row_servicios['telefono']; ?>
      </a></td>
      <td style="table-layout : fixed;"><?php echo $row_servicios['direccion']; ?></td><?php */?>
	  <td colspan="2"><strong><?php echo $row_servicios['telefono']; ?></strong> - <?php echo $row_servicios['direccion']; ?></td>
      <td><?php $array_dt_llamada=split(" ",$row_servicios['dt_llamada']);
	  			echo $array_dt_llamada[1];  ?></td>
	  
	  <td><div title="Lanzar Servicio" style="padding:0 3px;text-align:center;"><input type="image" src="../images/tick.png" onclick="location.href='index.php?servicio_id=<?php echo $row_servicios['servicio_id']; ?>';" value="Seleccionar" />
      		</div>
       </td>
	  
    </tr>
    <?php } while ($row_servicios = mysql_fetch_assoc($servicios)); ?>
</table>
</div>
<?php
}else{

	echo "No hay servicios disponibles";

}
mysql_free_result($servicios);
?>

