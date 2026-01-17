<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$hora_actual=date("Y-m-d h:i:s");
$query_recordatorios = sprintf("select * from recordatorio where UNIX_TIMESTAMP(NOW())>UNIX_TIMESTAMP(hora) and estado=1 limit 10");
//telefono, descripcion, hora, id_recordatorio, 
//echo $query_recordatorios;
$recordatorios = mysql_query($query_recordatorios, $conexion) or die(mysql_error());
$row_recordatorios = mysql_fetch_assoc($recordatorios);
$totalRows_recordatorios = mysql_num_rows($recordatorios);
?>
<?php if($totalRows_recordatorios>0){ ?>
<div class="panel panel-default">
<!-- Default panel contents -->
<div class="panel-heading" id="content">Recordatorios</div>

<table class="table table-bordered">
  <tr class="tr_title">
    <td>Telefono</td>
    <td width="130">Descripcion</td>
    <td>Hora</td>
    <td colspan="3">Accion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td>. 
    <a style="display:none;" href="../llamar.php?numero=<?php echo $row_recordatorios['telefono']; ?>" target="IFrameProcess" title="Click para Llamar"><?php echo $row_recordatorios['telefono']; ?>
      </a>
      </td>
      <td style="table-layout : fixed;"><?php echo $row_recordatorios['descripcion']; ?></td>
      <td><?php $array_hora=split(" ",$row_recordatorios['hora']);
	  			echo $array_hora[1];
				 ?></td>
      <td>
	  <form id="recordatorioEjecutado<?php echo $row_recordatorios['id_recordatorio']; ?>" action="../process/recordatorio.process.php" target="IFrameProcess" method="post">
		  <div style="padding:0 2px;text-align:center;">
			  <img src="../images/tick.png" style="cursor:pointer;" onClick="enviar('recordatorioEjecutado<?php echo $row_recordatorios['id_recordatorio']; ?>');">
			  <input type="hidden" name="modo" value="cancelar">
			  <input type="hidden" name="id_recordatorio" value="<?php echo $row_recordatorios[id_recordatorio]; ?>">
		  </div>
	  </form>
	  </td>
      <td><form id="lanzarRecordatorio<?php echo $row_recordatorios['id_recordatorio']; ?>" action="../process/recordatorio.process.php" target="IFrameProcess" method="post">
        <img title="Lanzar Servicio De Taxi" onClick="enviar('lanzarRecordatorio<?php echo $row_recordatorios['id_recordatorio']; ?>');" src="../images/taxi.jpg" style="cursor:pointer;">
        <input type="hidden" name="modo" value="lanzar">
        <input type="hidden" name="id_recordatorio" value="<?php echo $row_recordatorios[id_recordatorio]; ?>">
        <input type="hidden" name="telefono" value="<?php echo $row_recordatorios[telefono]; ?>">
      </form>
      </td>	  
      <td>    <a href="../llamar.php?numero=<?php echo $row_recordatorios['telefono']; ?>" target="IFrameProcess" title="Click para Llamar"> 
			<img src="../images/telefono.png" border="0" />
    	  
      </a></td>
    </tr>
    <?php } while ($row_recordatorios = mysql_fetch_assoc($recordatorios)); 	?>
</table>
</div>
<?php
	}else{
//		echo "No hay Recordatorios pendientes para esta hora";
	}
mysql_free_result($recordatorios);
?>
