<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_llamada_actual = "SELECT * FROM llamada_actual WHERE estado = 0 ORDER BY id_llamada_actual ASC limit 9";
$llamada_actual = mysql_query($query_llamada_actual, $conexion) or die(mysql_error());
$row_llamada_actual = mysql_fetch_assoc($llamada_actual);
$totalRows_llamada_actual = mysql_num_rows($llamada_actual);
?>
<p>Llamadas Actuales </p>
<table border="1">
  <tr class="tr_title">
  	<td>Fila #</td>
    <td>Telefono</td>
    <td colspan="2">Accion</td>
  </tr>
  <?php $i=1; if($totalRows_llamada_actual) {
  	do { ?>
  <tr>
	<td><?php echo $i; ?></td>	
    <td><input type="hidden" name="telefono_actual<?php echo $i; ?>" id="telefono_actual<?php echo $i; ?>" value="<?php echo $row_llamada_actual['telefono']; ?>">
        <a target="IFrameProcess" href="../llamar.php?numero=<?php  echo $row_llamada_actual['telefono']; ?>"><?php echo $row_llamada_actual['telefono']; ?></a></td>
    
	<td><img src="../images/b_usrcheck.png" style="cursor:pointer;" onclick="sel_telefono(document.getElementById('telefono_actual<?php echo $i; ?>').value);" alt="Seleccionar" width="16" height="16"></td>
   </tr>
    <?php 
		$i++; 
		} while ($row_llamada_actual = mysql_fetch_assoc($llamada_actual));
	}
		 ?>
</table>
<?php
mysql_free_result($llamada_actual);
?>