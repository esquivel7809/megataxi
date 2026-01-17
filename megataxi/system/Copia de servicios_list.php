<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_servicios = "select servicio.*, directorio.direccion from servicio, directorio where servicio.telefono=directorio.telefono and servicio.estado=1 order by estado asc";
$servicios = mysql_query($query_servicios, $conexion) or die(mysql_error());
$row_servicios = mysql_fetch_assoc($servicios);
$totalRows_servicios = mysql_num_rows($servicios);
?>
<table border="1">
  <tr>
    <td>telefono</td>
    <td>direccion</td>
    <td>Hora llamada </td>
	<td>Megas</td>
	<td>Reporta</td>
  </tr>
  <?php
  $i=0;
   do { ?>
    <tr id="servicios<?php echo $i; ?>" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');">
      <td><input name="servicio_id" type="hidden" id="servicio_id" value="<?php echo $row_servicios['servicio_id']; ?>" />
      <?php echo $row_servicios['telefono']; ?></td>
      <td><?php echo $row_servicios['direccion']; ?></td>
      <td><?php echo $row_servicios['dt_llamada']; ?></td>
	  <td>
	    <input type="text" name="mega1[]" onfocus="onfocus_general();seleccionar_fila('servicios','<?php echo $i;  ?>');" onkeypress="accion_objeto(event,'mega1','<?php echo $i; ?>');" onblur="accion_objeto('blur','mega1','<?php echo $i; ?>');" id="mega1<?php echo $i ?>" value="" size="3" /> 
	    <input type="text" name="mega2[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega2','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega2','<?php echo $i; ?>');"  id="mega2<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega3[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega3','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega3','<?php echo $i; ?>');" id="mega3<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega4[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega4','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega4','<?php echo $i; ?>');" id="mega4<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega5[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega5','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega5','<?php echo $i; ?>');" id="mega5<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega6[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega6','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega6','<?php echo $i; ?>');" id="mega6<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega7[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega7','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega7','<?php echo $i; ?>');" id="mega7<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega8[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega8','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega8','<?php echo $i; ?>');" id="mega8<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega9[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega9','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega9','<?php echo $i; ?>');" id="mega9<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega10[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega10','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega10','<?php echo $i; ?>');" id="mega10<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega11[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega11','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega11','<?php echo $i; ?>');" id="mega11<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega12[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega12','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega12','<?php echo $i; ?>');" id="mega12<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega13[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega13','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega13','<?php echo $i; ?>');" id="mega13<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega14[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega14','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega14','<?php echo $i; ?>');" id="mega14<?php echo $i ?>" value="" size="3" />
	    <input type="text" name="mega15[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','mega15','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega15','<?php echo $i; ?>');" id="mega15<?php echo $i ?>" value="" size="3" /></td>
		<td><input type="text" name="reporta[]" onfocus="onfocus_general();" onblur="accion_objeto('blur','reporta','<?php echo $i; ?>');"  onkeypress="accion_objeto(event,'reporta','<?php echo $i; ?>');" id="reporta<?php echo $i ?>" size="3" /></td>
    </tr>
    <?php $i++;
	} while ($row_servicios = mysql_fetch_assoc($servicios)); ?>
</table>

<input type="text" onkeypress="return caracter_pulsado(event);" />
<?php
mysql_free_result($servicios);
?>
