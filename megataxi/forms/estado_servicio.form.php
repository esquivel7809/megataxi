<?php require_once('../Connections/conexion.php'); ?>
<?php

$colname_estado_servicio = "-1";
if (isset($_GET['id_estado'])) {
  $colname_estado_servicio = (get_magic_quotes_gpc()) ? $_GET['id_estado'] : addslashes($_GET['id_estado']);
}
mysql_select_db($database_conexion, $conexion);
$query_estado_servicio = sprintf("SELECT * FROM estado_servicio WHERE id_estado = %s", $colname_estado_servicio);
$estado_servicio = mysql_query($query_estado_servicio, $conexion) or die(mysql_error());
$row_estado_servicio = mysql_fetch_assoc($estado_servicio);
$totalRows_estado_servicio = mysql_num_rows($estado_servicio);
?>

<h2>Edicion Estado Servicio</h2>

<form method="post" name="EstadoVForm" id="EstadoVForm" action="estado_servicio.process.php" target="IFrameProcess">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Id_estado:</td>
      <td><?php echo $row_estado_servicio['id_estado']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nombre:</td>
      <td><input type="text" name="nombre" value="<?php echo $row_estado_servicio['nombre']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="button" value="Insertar/Actualizar"></td>
    </tr>
  </table>
  <input type="hidden" name="modo" value="<?php echo $_GET[modo] ?>">
  <input type="hidden" name="id_estado" value="<?php echo $row_estado_servicio['id_estado']; ?>">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($estado_servicio);
?>
