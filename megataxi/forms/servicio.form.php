<?php require_once('../Connections/conexion.php'); ?>
<?php

$colname_servicio = "-1";
if (isset($_GET['servicio_id'])) {
  $colname_servicio = (get_magic_quotes_gpc()) ? $_GET['servicio_id'] : addslashes($_GET['servicio_id']);
}
mysql_select_db($database_conexion, $conexion);
$query_servicio = sprintf("SELECT * FROM servicio WHERE servicio_id = %s", $colname_servicio);
$servicio = mysql_query($query_servicio, $conexion) or die(mysql_error());
$row_servicio = mysql_fetch_assoc($servicio);
$totalRows_servicio = mysql_num_rows($servicio);
?>
<h2>Edicion Servicio</h2>
<form method="post" name="ServicioForm" id="ServicioForm" action="../process/servicio.process.php" target="IFrameProcess">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Servicio_id:</td>
      <td><?php echo $row_servicio['servicio_id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Telefono:</td>
      <td><input type="text" name="telefono" value="<?php echo $row_servicio['telefono']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Mega:</td>
      <td><input type="text" name="mega" value="<?php echo $row_servicio['mega']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Estado:</td>
      <td><input type="text" name="estado" value="<?php echo $row_servicio['estado']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Dt_llamada:</td>
      <td><input type="text" name="dt_llamada" value="<?php echo $row_servicio['dt_llamada']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Dt_recogida:</td>
      <td><input type="text" name="dt_recogida" value="<?php echo $row_servicio['dt_recogida']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="modo" value="<?php echo $_GET[modo] ?>">
  <input type="hidden" name="servicio_id" value="<?php echo $row_servicio['servicio_id']; ?>">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($servicio);
?>
