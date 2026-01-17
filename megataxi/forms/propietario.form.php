<?php require_once('../Connections/conexion.php'); ?>
<?php
$colname_propietario = "-1";
if (isset($_GET['id_propietario'])) {
  $colname_propietario = (get_magic_quotes_gpc()) ? $_GET['id_propietario'] : addslashes($_GET['id_propietario']);
}
mysql_select_db($database_conexion, $conexion);
$query_propietario = sprintf("SELECT * FROM propietario WHERE id_propietario = '%s'", $colname_propietario);
$propietario = mysql_query($query_propietario, $conexion) or die(mysql_error());
$row_propietario = mysql_fetch_assoc($propietario);
$totalRows_propietario = mysql_num_rows($propietario);
?>
<h2>Edicion Propietarios</h2>
<form method="post" id="propietarioForm" name="propietarioForm" action="../process/propietario.process.php" target="IFrameProcess">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right"><input type="hidden" name="id_propietario" value="<?php echo $row_propietario['id_propietario']; ?>" size="32">
      Documento:</td>
      <td><input type="text" name="documento" value="<?php echo utf8_decode($row_propietario['documento']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nombre:</td>
      <td><input type="text" name="nombre" value="<?php echo utf8_decode($row_propietario['nombre']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Direccion:</td>
      <td><input type="text" name="direccion" value="<?php echo utf8_decode($row_propietario['direccion']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Telefono:</td>
      <td><input type="text" name="telefono" value="<?php echo utf8_decode($row_propietario['telefono']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Notas:</td>
      <td><input type="text" name="notas" value="<?php echo utf8_decode($row_propietario['notas']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="button" value="Insertar/Actualizar" onClick="enviar('propietarioForm');"></td>
    </tr>
  </table>
  <input type="hidden" name="modo" value="<?php echo $_GET[modo]; ?>">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($propietario);
?>
