<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_usuarios = "SELECT * FROM usuario";
$usuarios = mysql_query($query_usuarios, $conexion) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);
?>
<h2>Usuarios Megataxi</h2>
<table border="1" align="center">
  <tr class="tr_title">
    <td>Usuario</td>
    <td>Nombre</td>
    <td>Perfil</td>
    <td>Estado</td>
	<td colspan="2">Accion</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_usuarios['usuario']; ?></td>
      <td><?php echo $row_usuarios['nombre']; ?></td>
      <td><?php echo (($row_usuarios['perfil']==1)?"Administrador":"Usuario"); ?></td>
      <td><?php echo (($row_usuarios['estado']==1)?"Activo":"Inactivo"); ?></td>
	  	  <td width="24"><form id="Dropusuario<?php echo $row_usuarios['id_usuario']; ?>" action="../process/usuario.process.php" method="post" target="IFrameProcess"><div align="center"><input type="hidden" name="id_usuario" value="<?php echo $row_usuarios[id_usuario]; ?>">
	    <input name="modo" type="hidden" value="delete">
	    <img src="../images/b_drop.png" style="cursor:pointer;" alt="Borrar" onClick="enviar('Dropusuario<?php echo $row_usuarios['id_usuario']; ?>');"></div></form></td>
	  <td width="19"><img src="../images/b_edit.png" style="cursor:pointer;" onclick="abrir('/megataxi/forms/usuario.form.php','','&modo=edit&id_usuario=<?php echo $row_usuarios['id_usuario']; ?>','Edicion');ver_div_edit();" alt="Editar"></td>
	  
    </tr>
    <?php } while ($row_usuarios = mysql_fetch_assoc($usuarios)); ?>
	<tr>
		<td colspan="4"></td>
		<td colspan="2"><input name="button" type="button" onclick="abrir('/megataxi/forms/usuario.form.php','','&amp;modo=add','Edicion');ver_div_edit();" value="Nuevo" /></td>
	</tr>
</table>
<?php
mysql_free_result($usuarios);
?>
