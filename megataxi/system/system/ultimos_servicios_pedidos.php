<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_servicios = "SELECT servicio.servicio_id, servicio.telefono, direccion, servicio.dt_llamada FROM servicio, directorio WHERE servicio.telefono=directorio.telefono and servicio.estado=1 and servicio.seleccion=0 order by dt_llamada desc limit 5";
$servicios = mysql_query($query_servicios, $conexion) or die(mysql_error());
$row_servicios = mysql_fetch_assoc($servicios);
$totalRows_servicios = mysql_num_rows($servicios);


?>

<fieldset>
<legend>Servicios Autom&aacute;ticos</legend>
<?php
if($totalRows_servicios>0){
?>
<table border="1">
  <tr class="tr_title">
    <td>Telefono</td>
    <td style="max-width:150px;">Direccion</td>
    <td>Hora</td>
	<td colspan="2">Accion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_servicios['telefono']; ?></td>
      <td><?php echo $row_servicios['direccion']; ?></td>
      <td><?php echo $row_servicios['dt_llamada']; ?></td>
	  <td><form action="../process/servicio.process.php" method="post" target="IFrameProcess" id="CancelaServicio<?php echo $row_servicios[servicio_id]?>">
	    <input name="button" type="button" onclick="enviar('CancelaServicio<?php echo $row_servicios[servicio_id]?>');" value="Cancelar" />
	    <input type="hidden" name="servicio_id" value="<?php echo $row_servicios[servicio_id]?>" />
	    <input type="hidden" name="modo" value="cancelar" />
	    </form>
	  </td>
	  <td><input type="button" onclick="location.href='index.php?servicio_id=<?php echo $row_servicios['servicio_id']; ?>';" value="Seleccionar" /></td>
	  
    </tr>
    <?php } while ($row_servicios = mysql_fetch_assoc($servicios)); ?>
</table>

<?php
}else{

	echo "No hay servicios disponibles";

}
mysql_free_result($servicios);
?>
</fieldset>
