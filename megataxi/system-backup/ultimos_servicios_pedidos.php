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

<fieldset>
<legend>Servicios Autom&aacute;ticos</legend>

<table border="0" cellspacing="0" class="tablita">
  <tr class="tr_title">
    <td colspan="">Telefono</td>
    <td width="130">Direccion</td>
    <td>Hora</td>
	<td colspan="2">Accion</td>
  </tr>
  <?php do { ?>
    <tr<?php echo ($row_servicios[web])?" class=\"servicio_domicilios_com\"":"";?>>
      <td align="right"><?php echo ($row_servicios[web])?"<img src=\"../images/favicondomicilios.png\" height=\"16\" width=\"16\">":"";?> 
	  <a href="../llamar.php?numero=<?php echo $row_servicios['telefono']; ?>" target="IFrameProcess">
		  <?php echo $row_servicios['telefono']; ?>
      </a></td>
      <td style="table-layout : fixed;"><?php echo $row_servicios['direccion']; ?></td>
      <td><?php $array_dt_llamada=split(" ",$row_servicios['dt_llamada']);
	  			echo $array_dt_llamada[1];  ?></td>
	  <td><div title="Cancelar Servicio" style="padding:0 3px;text-align:center;"><form action="../process/servicio.process.php" method="post" target="IFrameProcess" id="CancelaServicio<?php echo $row_servicios[servicio_id]?>">
	    <input name="button" type="image" onclick="enviar('CancelaServicio<?php echo $row_servicios[servicio_id]?>');" src="../images/cancelar.png"/>
	    <input type="hidden" name="servicio_id" value="<?php echo $row_servicios[servicio_id]?>" />
	    <input type="hidden" name="modo" value="cancelar" />
	    </form>
        </div>
	  </td>
	  <td><div title="Lanzar Servicio" style="padding:0 3px;text-align:center;"><input type="image" src="../images/tick.png" onclick="location.href='index.php?servicio_id=<?php echo $row_servicios['servicio_id']; ?>';" value="Seleccionar" />
      		</div>
       </td>
	  
    </tr>
    <?php } while ($row_servicios = mysql_fetch_assoc($servicios)); ?>
</table>
</fieldset>
<?php
}else{

//	echo "No hay servicios disponibles";

}
mysql_free_result($servicios);
?>
<br />

