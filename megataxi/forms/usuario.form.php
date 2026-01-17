<?php include('../Connections/conexion.php'); ?>
<?php
$colname_usuarios = "-1";
if (isset($_GET['id_usuario'])) {
  $colname_usuarios = (get_magic_quotes_gpc()) ? $_GET['id_usuario'] : addslashes($_GET['id_usuario']);
}
mysql_select_db($database_conexion, $conexion);
$query_usuarios = sprintf("SELECT * FROM usuario WHERE id_usuario = %s", $colname_usuarios);
$usuarios = mysql_query($query_usuarios, $conexion) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);
?>
<?php include('../process/validar.php'); ?>

<h2>Edicion Usuario</h2>

<form method="post" name="UsuarioForm" id="UsuarioForm" action="../process/usuario.process.php" target="IFrameProcess">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre:</td>
      <td><input type="text" name="nombre" value="<?php echo utf8_decode($row_usuarios['nombre']); ?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Usuario:</td>
      <td><input type="text" name="usuario" value="<?php echo utf8_decode($row_usuarios['usuario']); ?>"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Clave:</td>
      <td><input type="text" name="clave" value="<?php echo utf8_decode($row_usuarios['clave']); ?>"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Perfil::</td>
      <td>
      <?php if($_SESSION[datos]->perfil==1){ ?>
	    <select name="perfil" id="perfil">
          <option value="0">[Seleccione Perfil]</option>
          <option value="1" <?php if($row_usuarios[perfil]==1) echo "selected=\"selected\""; ?>>Administrador</option>
          <option value="2" <?php if($row_usuarios[perfil]==2) echo "selected=\"selected\""; ?>>Usuario</option>
        </select>
	<?php }else{?>
			<input type="hidden" name="perfil" value="<?php echo $row_usuarios[perfil]; ?>" /><?php echo ($row_usuarios['perfil']==1)?"Super Administrador":"Administrador Normal"; ?>
	<?php }?>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Estado::</td>
      <td><select name="estado" id="estado">
            <option value="0">[Seleccione Perfil]</option>
            <option value="1" <?php if($row_usuarios[estado]==1) echo "selected=\"selected\""; ?>>Activo</option>
            <option value="2" <?php if($row_usuarios[estado]==0) echo "selected=\"selected\""; ?>>Inactivo</option>
          </select>
	  </td>
    </tr>	
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="button" value="Insertar/Actualizar" onclick="enviar('UsuarioForm');"></td>
    </tr>
  </table>
  <input type="hidden" name="modo" value="<?php echo $_GET[modo];?>">
  <input name="id_usuario" type="hidden" value="<?php echo $row_usuarios['id_usuario']; ?>" />
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($usuarios);
?>
