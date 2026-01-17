<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_clientes_nuevos = "SELECT * FROM directorio WHERE estado = 0";
$clientes_nuevos = mysql_query($query_clientes_nuevos, $conexion) or die(mysql_error());
$row_clientes_nuevos = mysql_fetch_assoc($clientes_nuevos);
$totalRows_clientes_nuevos = mysql_num_rows($clientes_nuevos);
?>

<h4 align="center">Clientes Nuevos</h4>

<?php
if($totalRows_clientes_nuevos>0){
?>
<table border="1">
  <tr class="tr_title">
    <td>TELEFONO</td>
    <td>FECHA</td>
	<td>ACCION</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_clientes_nuevos['telefono']; ?></td>
      <td><?php echo $row_clientes_nuevos['fecha']; ?></td>
	  <td><a onclick="abrir('/megataxi/forms/directorio.form.php','','&telefono=<?php echo $row_clientes_nuevos[telefono]; ?>&modo=new_automatic','Edicion');ver_div_edit();">Editar</a></td>
    </tr>
    <?php } while ($row_clientes_nuevos = mysql_fetch_assoc($clientes_nuevos)); ?>
</table>
<?php
}else{

	echo "No hay Clientes Nuevos Por Editar";
	
}
mysql_free_result($clientes_nuevos);
?>
