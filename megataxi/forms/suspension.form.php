<?php require_once('../Connections/conexion.php');
		include('../process/validar.php');
 ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_suspensiones = "SELECT * FROM tipo_suspension";
$suspensiones = mysql_query($query_suspensiones, $conexion) or die(mysql_error());
$row_suspensiones = mysql_fetch_assoc($suspensiones);
$totalRows_suspensiones = mysql_num_rows($suspensiones);

?>

<h2>Suspension</h2>
<form method="post" name="suspensionForm" id="suspensionForm" action="../process/vehiculo.process.php?<?php echo $_SERVER['QUERY_STRING']; ?>" target="IFrameProcess">
  <table align="center">

	<tr>
	  <td width="90" valign="baseline">Mega:</td>
	  <td width="404">
      <input type="hidden" name="stop" id="stop" value="<?php echo $_GET[stop]; ?>" />
	  <input type="hidden" name="placa" value="<?php echo $_GET[vehiculo]; ?>">
	  <?php 
			echo $_GET[vehiculo];					
			?></td>
  </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tipo::</td>
      <td>
        <select name="id_tipo" id="id_tipo">
          <option value="0">Seleccione Tipo</option>
<?php // if($_SESSION[datos]->perfil==1){ ?>
			<option value="NO PAGO">NO PAGO</option>
<?php // }?>		  
          <?php
do {  
?>
          <option value="<?php echo $row_suspensiones['id_tipo']?>"><?php echo $row_suspensiones['nombre']." - ".$row_suspensiones[duracion]." Horas"; ?></option>
          <?php
} while ($row_suspensiones = mysql_fetch_assoc($suspensiones));
  $rows = mysql_num_rows($suspensiones);
  if($rows > 0) {
      mysql_data_seek($suspensiones, 0);
	  $row_suspensiones = mysql_fetch_assoc($suspensiones);
  }
?>
        </select>
</td>
    </tr>
    <tr>
    	<td>Fecha Y Hora:</td>
        <td>  
  <input name="fecha_suspension" type="text" id="fecha_suspension" value="<?php echo date("Y-m-d"); ?>" size="12" />
  <img src="../js/jscalendar-1.0/img.gif" alt="calendario" name="fecha_button_s" id="fecha_button" style="cursor:pointer;" onload="activar_calendario('fecha_suspension','fecha_button_s');"; /> H
  <select name="hora_suspension" id="hora_suspension">
    <?php for($i=0;$i<24;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo (date("H")==$i)?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select>
    :m
  <select name="min_suspension" id="min_suspension">
    <?php for($i=0;$i<60;$i++){ ?>
    <option value="<?php echo $i ?>" <?php echo ($i==date("i"))?"selected='selected'":""; ?>><?php echo $i ?></option>
    <?php }?>
  </select>
  
  </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="button" value="Insertar/Actualizar" onClick="enviar('suspensionForm');"></td>
    </tr>
  </table>
  <input type="hidden" name="modo" value="suspender">
</form>

<?php
mysql_free_result($suspensiones);
?>
