<?php require_once('../Connections/conexion.php'); ?>
<?php
$colname_tipo_suspension = "-1";
if (isset($_GET['id_tipo'])) {
  $colname_tipo_suspension = (get_magic_quotes_gpc()) ? $_GET['id_tipo'] : addslashes($_GET['id_tipo']);
}
mysql_select_db($database_conexion, $conexion);
$query_tipo_suspension = sprintf("SELECT * FROM tipo_suspension WHERE id_tipo = '%s'", $colname_tipo_suspension);
$tipo_suspension = mysql_query($query_tipo_suspension, $conexion) or die(mysql_error());
$row_tipo_suspension = mysql_fetch_assoc($tipo_suspension);
$totalRows_tipo_suspension = mysql_num_rows($tipo_suspension);
?>
<h2>Edicion Tipos De Suspension</h2>
<form method="post" id="tipo_suspensionForm" name="tipo_suspensionForm" action="../process/tipo_suspension.process.php" target="IFrameProcess">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right"><input type="hidden" name="id_tipo" value="<?php echo $row_tipo_suspension['id_tipo']; ?>" size="32">
      Tipo:</td>
      <td><input type="text" name="nombre" value="<?php echo utf8_decode($row_tipo_suspension['nombre']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Duracion</td>
      <td><input type="text" name="duracion" value="<?php echo utf8_decode($row_tipo_suspension['duracion']); ?>" size="10">
        <label>
        <select name="unidad">
          <option value="h">Horas</option>
          <option value="d">Dias</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="button" value="Insertar/Actualizar" onClick="enviar('tipo_suspensionForm');"></td>
    </tr>
  </table>
  <input type="hidden" name="modo" value="<?php echo $_GET[modo]; ?>">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($tipo_suspension);
?>
