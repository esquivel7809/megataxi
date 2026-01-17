<?php require_once('../Connections/conexion.php'); ?>
<?php


mysql_select_db($database_conexion, $conexion);

$hora_actual=date("Y-m-d h:i:s");

$query_recordatorios = sprintf("select * from recordatorio where DATE(NOW())=DATE(hora) and TIME_TO_SEC(TIME(NOW()))>TIME_TO_SEC(TIME(hora)) and estado=1 limit 10");

//echo $query_recordatorios;

$recordatorios = mysql_query($query_recordatorios, $conexion) or die(mysql_error());
$row_recordatorios = mysql_fetch_assoc($recordatorios);
$totalRows_recordatorios = mysql_num_rows($recordatorios);
?>
 <fieldset>
                                <legend>Recordatorios</legend>

<?php if($totalRows_recordatorios>0){ ?>
<table border="1">
  <tr class="tr_title">
    <td>Telefono</td>
    <td>Descripcion</td>
    <td>Hora</td>
    <td colspan="2">Accion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_recordatorios['telefono']; ?></td>
      <td><?php echo $row_recordatorios['descripcion']; ?></td>
      <td><?php echo $row_recordatorios['hora']; ?></td>
      <td><form id="recordatorioEjecutado<?php echo $row_recordatorios['id_recordatorio']; ?>" action="../process/recordatorio.process.php" target="IFrameProcess" method="post"><input type="button" onClick="enviar('recordatorioEjecutado<?php echo $row_recordatorios['id_recordatorio']; ?>');" value="Ejecutado"><input type="hidden" name="modo" value="cancelar"><input type="hidden" name="id_recordatorio" value="<?php echo $row_recordatorios[id_recordatorio]; ?>"></form></td>
      <td><form id="lanzarRecordatorio<?php echo $row_recordatorios['id_recordatorio']; ?>" action="../process/recordatorio.process.php" target="IFrameProcess" method="post">
        <input name="button" type="button" onClick="enviar('lanzarRecordatorio<?php echo $row_recordatorios['id_recordatorio']; ?>');" value="Lanzar Servicio">
        <input type="hidden" name="modo" value="lanzar">
        <input type="hidden" name="id_recordatorio" value="<?php echo $row_recordatorios[id_recordatorio]; ?>">
        <input type="hidden" name="telefono" value="<?php echo $row_recordatorios[telefono]; ?>">
      </form>
      </td>	  
    </tr>
    <?php } while ($row_recordatorios = mysql_fetch_assoc($recordatorios)); 	?>
</table>
<?php
	}else{
		echo "No hay Recordatorios pendientes para esta hora";
	}
mysql_free_result($recordatorios);
?>
</fieldset>
