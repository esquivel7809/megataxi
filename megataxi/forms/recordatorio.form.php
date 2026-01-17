<?php require_once('../Connections/conexion.php'); ?>
<?php

$colname_recordatorio = "-1";
if (isset($_GET['id_recordatorio'])) {
  $colname_recordatorio = (get_magic_quotes_gpc()) ? $_GET['id_recordatorio'] : addslashes($_GET['id_recordatorio']);
}
mysql_select_db($database_conexion, $conexion);
$query_recordatorio = sprintf("SELECT * FROM recordatorio WHERE id_recordatorio = %s", $colname_recordatorio);
$recordatorio = mysql_query($query_recordatorio, $conexion) or die(mysql_error());
$row_recordatorio = mysql_fetch_assoc($recordatorio);
$totalRows_recordatorio = mysql_num_rows($recordatorio);
?>

<h2>Edicion Recordatorio</h2>
<form method="post" name="RecordatorioForm" id="RecordatorioForm" action="../process/recordatorio.process.php" target="IFrameProcess">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Telefono:</td>
      <td><input type="text" id="telManual" name="telefono" value="<?php echo $row_recordatorio['telefono']; ?>" onkeypress="return val_num(event);" <?php echo ($_GET[modo]!='edit')?"onKeyUp=\"buscar_direccion('telManual');\" ":""; ?>size="32"></td>
    </tr>
	<tr>
	  <td>Direccion:</td>
	  <td><div id="direccionCliente">
	  		<?php 
				$direccion=mysql_query("select direccion from directorio where telefono='$row_recordatorio[telefono]'",$conexion); 
				$row_direccion=mysql_fetch_assoc($direccion);
				echo $row_direccion['direccion'];						
			?></div></td>
  </tr>	
    <tr valign="baseline">
      <td nowrap align="right">Descripcion:</td>
      <td><textarea name="descripcion" cols="30" rows="7"><?php echo $row_recordatorio['descripcion']; ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Hora:</td>
      <td>  <?php $fecha_partida=split(" ",$row_recordatorio[hora]); ?>
  <input name="fecha" type="text" id="fecha" value="<?php echo $fecha_partida[0]; ?>" />
  <img src="../js/jscalendar-1.0/img.gif" alt="calendario" name="fecha_button" id="fecha_button" style="cursor:pointer;" onload="activar_calendario('fecha','fecha_button');"; /> H
  <?php $hora_partida=split(":",$fecha_partida[1]); ?>
  <select name="hora" id="hora">
    <?php for($i=0;$i<24;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($hora_partida[0]==$i)?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select>
    :m
  <select name="min" id="min">
    <?php for($i=0;$i<60;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($i==$hora_partida[1])?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select>
    :s
  <select name="seg" id="seg">
    <?php for($i=0;$i<60;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($i==$hora_partida[2])?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="button" value="Insertar/Actualizar" onClick="enviar('RecordatorioForm');"></td>
    </tr>
  </table>
  <input type="hidden" name="modo" value="<?php echo $_GET['modo']; ?>">
  <input type="hidden" name="id_recordatorio" value="<?php echo $row_recordatorio['id_recordatorio']; ?>">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($recordatorio);
?>
