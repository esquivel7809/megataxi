<?php require_once('../Connections/conexion.php'); ?>
<?php
$colname_vehiculo = "-1";
if (isset($_GET['placa'])) {
  $colname_vehiculo = (get_magic_quotes_gpc()) ? $_GET['placa'] : addslashes($_GET['placa']);
}
mysql_select_db($database_conexion, $conexion);
$query_vehiculo = sprintf("SELECT * FROM vehiculo WHERE placa = '%s'", $colname_vehiculo);
$vehiculo = mysql_query($query_vehiculo, $conexion) or die(mysql_error());
$row_vehiculo = mysql_fetch_assoc($vehiculo);
$totalRows_vehiculo = mysql_num_rows($vehiculo);
?>

<h2>Edicion Vehiculo</h2>

<form method="post" name="VehiculoForm" id="VehiculoForm" action="../process/vehiculo.process.php" target="IFrameProcess">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Placa:</td>
      <td><input type="text" name="placa" value="<?php echo utf8_decode($row_vehiculo['placa']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Color:</td>
      <td><input type="text" name="color" value="<?php echo $row_vehiculo[color]?utf8_decode($row_vehiculo['color']):"amarillo"; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Pasajeros:</td>
      <td><input type="text" name="pasajeros" value="<?php echo utf8_decode($row_vehiculo['pasajeros']); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Carga:</td>
      <td><input type="text" name="carga" value="<?php echo utf8_decode($row_vehiculo['carga']); ?>" size="32"></td>
	  <td>Toneladas</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tipo:</td>
      <td>			<?php 
				$tipos=mysql_query("select * from tipo_vehiculo",$conexion)or die(mysql_error());
			?>		
			<select name="id_tipo">
				<option value="">Seleccione Valor</option>
			<?php
				while($row_tipos=mysql_fetch_assoc($tipos)){
			?>
				<option value="<?php echo $row_tipos[id_tipo]; ?>" <?php if($row_vehiculo[id_tipo]==$row_tipos[id_tipo])echo "selected=\"selected\""; ?>><?php echo $row_tipos[nombre]; ?></option>
			<?php
				}
			?>
			</select>		</td>

    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Id_propietario:</td>
      <td><?php 
				$propietarios=mysql_query("select * from propietario",$conexion)or die(mysql_error());
			?>		
			<select name="id_propietario">
				<option value="">Seleccione Valor</option>
			<?php
				while($row_propietarios=mysql_fetch_assoc($propietarios)){
			?>
				<option value="<?php echo $row_propietarios[id_propietario]; ?>" <?php if($row_vehiculo[id_propietario]==$row_propietarios[id_propietario])echo "selected=\"selected\""; ?>><?php echo $row_propietarios[nombre]; ?></option>
			<?php
				}
			?>
			</select>
	  </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Estado:</td>
      <td>	
	  	<?php 
				$estados=mysql_query("select * from estado_vehiculo",$conexion)or die(mysql_error());
			?>		
			<select name="estado">
				<option value="">Seleccione Valor</option>			
			<?php
				while($row_estados=mysql_fetch_assoc($estados)){
			?>
				<option value="<?php echo $row_estados[id_estado]; ?>" <?php if($row_vehiculo[estado]==$row_estados[id_estado])echo "selected=\"selected\""; ?>><?php echo $row_estados[nombre]; ?></option>
			<?php
				}
			?>
			</select>
	  </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"><input type="hidden" name="modo" value="<?php echo $_GET[modo]; ?>" />
      <input type="hidden" name="placa_ant" value="<?php echo $row_vehiculo['placa']; ?>" /></td>
      <td><input type="button" onclick="enviar('VehiculoForm');" value="Insertar/Actualizar"></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($vehiculo);
?>
