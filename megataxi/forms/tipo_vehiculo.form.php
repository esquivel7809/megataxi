<?php require_once('../Connections/conexion.php'); ?>
<?php

$colname_tipo_vehiculo = "-1";
if (isset($_GET['id_tipo'])) {
  $colname_tipo_vehiculo = (get_magic_quotes_gpc()) ? $_GET['id_tipo'] : addslashes($_GET['id_tipo']);
}
mysql_select_db($database_conexion, $conexion);
$query_tipo_vehiculo = sprintf("SELECT * FROM tipo_vehiculo WHERE id_tipo = %s", $colname_tipo_vehiculo);
$tipo_vehiculo = mysql_query($query_tipo_vehiculo, $conexion) or die(mysql_error());
$row_tipo_vehiculo = mysql_fetch_assoc($tipo_vehiculo);
$totalRows_tipo_vehiculo = mysql_num_rows($tipo_vehiculo);
?>

<h2>Edicion Tipo Vehiculo</h2>
<form method="post" name="TipoVehiculoForm" id="TipoVehiculoForm" action="../process/tipo_vehiculo.process.php" target="IFrameProcess">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Id_tipo:</td>
      <td><?php echo $row_tipo_vehiculo['id_tipo']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nombre:</td>
      <td><input type="text" name="nombre" value="<?php echo utf8_decode($row_tipo_vehiculo['nombre']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="button" value="Insertar/Actualizar"></td>
    </tr>
  </table>
  <input type="hidden" name="modo" value="<?php echo $_GET[modo]; ?>">
  <input type="hidden" name="id_tipo" value="<?php echo $row_tipo_vehiculo['id_tipo']; ?>">
</form>
<?php
mysql_free_result($tipo_vehiculo);
?>
