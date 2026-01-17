<?php require_once('../Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_vehiculos = "SELECT * FROM vehiculo WHERE estado = 1";
$vehiculos = mysql_query($query_vehiculos, $conexion) or die(mysql_error());
$row_vehiculos = mysql_fetch_assoc($vehiculos);
$totalRows_vehiculos = mysql_num_rows($vehiculos);
?>
<div align="center">
<form action="/megataxi/process/mensaje.process.php" method="post" name="FormMensaje" target="IFrameProcess">
<h2>Nuevo Mensaje</h2>
<table width="200" border="0">
  <tr>
    <td>Mensaje: </td>
    <td><label>
      <textarea name="texto" cols="30" rows="6" id="texto"></textarea>
    </label></td>
  </tr>
  <tr>
    <td>Vehiculo:</td>
    <td><label>
<?php
/*
?>
      <select name="vehiculo" id="vehiculo">
        <?php
do {  
?>
        <option value="<?php echo $row_vehiculos['placa']?>"><?php echo $row_vehiculos['placa']?></option>
        <?php
} while ($row_vehiculos = mysql_fetch_assoc($vehiculos));
  $rows = mysql_num_rows($vehiculos);
  if($rows > 0) {
      mysql_data_seek($vehiculos, 0);
	  $row_vehiculos = mysql_fetch_assoc($vehiculos);
  }
?>
      </select>
<?php */ ?>
	<input type="text" name="vehiculo" id="vehiculo" value="">
    </label></td>
  </tr>
  <tr>
    <td><input name="modo" type="hidden" id="modo" value="add"></td>
    <td><label>
      <input type="submit" name="Submit" value="Enviar">
    </label></td>
  </tr>
</table>

</form>
</div>
<?php
mysql_free_result($vehiculos);
?>
