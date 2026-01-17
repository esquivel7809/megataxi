<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_propietarios = "SELECT * FROM propietario";
$propietarios = mysql_query($query_propietarios, $conexion) or die(mysql_error());
$row_propietarios = mysql_fetch_assoc($propietarios);
$totalRows_propietarios = mysql_num_rows($propietarios);
?>
<h2>Propietarios Vehiculos</h2>
<table border="1" align="center">
  <tr class="tr_title">
    <td>Documento</td>
    <td>Nombre</td>
    <td>Direccion</td>
    <td>Telefono</td>
    <td>Notas</td>
	<td colspan="2">Accion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_propietarios['documento']; ?></td>
      <td><?php echo $row_propietarios['nombre']; ?></td>
      <td><?php echo $row_propietarios['direccion']; ?></td>
      <td><?php echo $row_propietarios['telefono']; ?></td>
      <td><?php echo $row_propietarios['notas']; ?></td>
	  	  <td width="24"><form id="DropPropietario<?php echo $row_propietarios['id_propietario']; ?>" action="../process/propietario.process.php" method="post" target="IFrameProcess"><div align="center"><input type="hidden" name="id_propietario" value="<?php echo $row_propietarios[id_propietario]; ?>">
	    <input name="modo" type="hidden" value="delete">
	    <img src="../images/b_drop.png" style="cursor:pointer;" alt="Borrar" onClick="enviar('DropPropietario<?php echo $row_propietarios['id_propietario']; ?>');"></div></form></td>
	  <td width="19"><img src="../images/b_edit.png" style="cursor:pointer;" onclick="abrir('/megataxi/forms/propietario.form.php','','&modo=edit&id_propietario=<?php echo $row_propietarios['id_propietario']; ?>','Edicion');ver_div_edit();" alt="Editar"></td>
	  
    </tr>
    <?php } while ($row_propietarios = mysql_fetch_assoc($propietarios)); ?>
	<tr>
		<td colspan="5"></td>
		<td colspan="2"><input name="button" type="button" onclick="abrir('/megataxi/forms/propietario.form.php','','&amp;modo=add','Edicion');ver_div_edit();" value="Nuevo" /></td>
	</tr>
</table>
<?php
mysql_free_result($propietarios);
?>
