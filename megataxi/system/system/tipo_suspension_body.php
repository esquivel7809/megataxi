<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_tipo_suspension = "SELECT * FROM tipo_suspension";
$tipo_suspension = mysql_query($query_tipo_suspension, $conexion) or die(mysql_error());
$row_tipo_suspension = mysql_fetch_assoc($tipo_suspension);
$totalRows_tipo_suspension = mysql_num_rows($tipo_suspension);
?>
<h2>Tipos De Suspension</h2>
<table border="1" align="center">
  <tr class="tr_title">
    <td>Tipo</td>
    <td>Duracion</td>
	<td colspan="2">Accion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_tipo_suspension['nombre']; ?></td>
      <td><?php echo $row_tipo_suspension['duracion']; ?> Horas</td>
	  	  <td width="24"><form id="Droptipo_suspension<?php echo $row_tipo_suspension['id_tipo']; ?>" action="../process/tipo_suspension.process.php" method="post" target="IFrameProcess"><div align="center"><input type="hidden" name="id_tipo" value="<?php echo $row_tipo_suspension[id_tipo]; ?>">
	    <input name="modo" type="hidden" value="delete">
	    <img src="../images/b_drop.png" style="cursor:pointer;" alt="Borrar" onClick="enviar('Droptipo_suspension<?php echo $row_tipo_suspension['id_tipo']; ?>');"></div></form></td>
	  <td width="19"><img src="../images/b_edit.png" style="cursor:pointer;" onclick="abrir('/megataxi/forms/tipo_suspension.form.php','','&modo=edit&id_tipo=<?php echo $row_tipo_suspension['id_tipo']; ?>','Edicion');ver_div_edit();" alt="Editar"></td>
    </tr>
    <?php } while ($row_tipo_suspension = mysql_fetch_assoc($tipo_suspension)); ?>
	<tr>
		<td colspan="2"></td>
		<td colspan="2"><input name="button" type="button" onclick="abrir('/megataxi/forms/tipo_suspension.form.php','','&amp;modo=add','Edicion');ver_div_edit();" value="Nuevo" /></td>
	</tr>
</table>
<?php
mysql_free_result($tipo_suspension);
?>
