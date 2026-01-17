<?php require_once('../Connections/conexion.php'); ?>
<?php
$fecha2_reportes = "2050-01-01 00:00:00";
if (isset($_GET[fecha2])) {
  $fecha2_reportes = (get_magic_quotes_gpc()) ? $_GET[fecha2] : addslashes($_GET[fecha2]);
}
$fecha1_reportes = "0000-00-00 00:00:00";
if (isset($_GET[fecha1])) {
  $fecha1_reportes = (get_magic_quotes_gpc()) ? $_GET[fecha1] : addslashes($_GET[fecha1]);
}
$colname_reportes = "-1";
if (isset($_GET['vehiculo'])) {
  $colname_reportes = (get_magic_quotes_gpc()) ? $_GET['vehiculo'] : addslashes($_GET['vehiculo']);
}
mysql_select_db($database_conexion, $conexion);
$query_reportes = sprintf("SELECT * FROM reporte_mega_a_servicio WHERE mega = '%s' and date(timestamp) between '%s' and '%s'", $colname_reportes,$fecha1_reportes,$fecha2_reportes);
$reportes = mysql_query($query_reportes, $conexion) or die(mysql_error());
$row_reportes = mysql_fetch_assoc($reportes);
$totalRows_reportes = mysql_num_rows($reportes);
?>

<h2>Reportes de Megas a Servicios</h2>
<table border="0" align="center">
	<tr>
		<td>Fecha 1</td>
		<td>
			<input name="fecha1" type="text" id="fecha1" value="<?php echo $_GET[fecha1]; ?>" />
			<img src="../js/jscalendar-1.0/img.gif" alt="calendario" name="fecha_button1" id="fecha_button1" style="cursor:pointer;" onload="activar_calendario('fecha1','fecha_button1');"; />
		</td>
		<td>Fecha 2</td>
		<td>
			<input name="fecha2" type="text" id="fecha2" value="<?php echo $_GET[fecha2]; ?>" />
			<img src="../js/jscalendar-1.0/img.gif" alt="calendario" name="fecha_button2" id="fecha_button2" style="cursor:pointer;" onload="activar_calendario('fecha2','fecha_button2');"; />
		</td>		
		<td>
			<input name="Buscar" value="Buscar" type="button" onclick="abrir('/megataxi/reports/reporte_vehiculos.report.php','','&fecha1='+document.getElementById('fecha1').value+'&fecha2='+document.getElementById('fecha2').value+'&vehiculo=<?php echo $_GET[vehiculo]; ?>','Edicion');" />
		</td>
	</tr>
</table>
<br />
<br />
<br />


<table border="1" align="center">
  <tr class="tr_title">
    <td>mega</td>
    <td>timestamp</td>
	<td>Realiz&oacute;?</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_reportes['mega']; ?></td>
      <td><?php echo $row_reportes['timestamp']; ?></td>
	  <td>
	  	<?php
			$servicio=mysql_query("select * from servicio where mega='$row_reportes[mega]'",$conexion)or die(mysql_error());
			if(mysql_num_rows($servicio)>0)
				echo "Si";
			else
				echo "No";
		 ?>
		</td>
    </tr>
    <?php } while ($row_reportes = mysql_fetch_assoc($reportes)); ?>
</table>
<?php
mysql_free_result($reportes);
?>
