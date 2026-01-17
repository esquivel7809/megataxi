<?php require_once('../Connections/conexion.php'); ?>
<script language="javascript">
/*function ponerDireccion(e){
	
    tecl = (document.all) ? e.keyCode : e.which;
	
	if(tecl==13){
		document.getElementById('EnviarFormDirectorio').focus();
	}else{
	
		var barrio=document.getElementById('barrio');
		var direccion=document.getElementById('direccion');
		var dirTxt='';
	
	
		var indiceBarrio=barrio.selectedIndex;
		indiceBarrio=parseInt(indiceBarrio);
		if(indiceBarrio==0){
			barrio.focus();
		}else{
			dirTxt=barrio.options[indiceBarrio].value+' ';
		}
	
		var i=0;
		var elemento,indice,valor;
		for(i=1;i<7;i++){
			elemento=document.getElementById('convencion'+i);
			indice=elemento.selectedIndex;
			indice=parseInt(indice);
			valor=document.getElementById('txtC'+i).value;
			if(indice!=0){
				dirTxt+=elemento.options[indice].value+' '+valor+' ';
			}
		}
	
		direccion.value=dirTxt;	
	}
}
*/</script>
<?php


$colname_directorio = "-1";
if (isset($_GET['telefono'])) {
  $colname_directorio = (get_magic_quotes_gpc()) ? $_GET['telefono'] : addslashes($_GET['telefono']);
}
mysql_select_db($database_conexion, $conexion);
$query_directorio = sprintf("SELECT * FROM directorio WHERE telefono = '%s'", $colname_directorio);
$directorio = mysql_query($query_directorio, $conexion) or die(mysql_error());
$row_directorio = mysql_fetch_assoc($directorio);
$totalRows_directorio = mysql_num_rows($directorio);
?>

<h2>Edicion Directorio</h2>

<form method="post" name="DirectorioProcess" id="DirectorioProcess" action="../process/directorio.process.php" target="IFrameProcess">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Telefono:</td>
      <td><input type="text" name="telefono" value="<?php echo $row_directorio['telefono']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Direccion:</td>
      <td>
	<?php 
		$barrios=mysql_query("select * from barrios",$conexion);
	?>
	<select name="barrio" id="barrio" onchange="ponerDireccion();">
		<option value="0">[Seleccione Barrio]</option>
		<?php
			while($row_barrios=mysql_fetch_assoc($barrios)){
		?>	
			<option value="<?php echo $row_barrios[barrio]; ?>"><?php echo $row_barrios[barrio]; ?></option>
		<?php
			}
		?>	</select>
	<br />
	
	<?php
		$convenciones=mysql_query("select * from convencion",$conexion);
	?>
	<select name="convencion1" id="convencion1" onchange="ponerDireccion();">
		<option value="0">[Seleccione Convencion]</option>
		<?php while($row_convencion=mysql_fetch_assoc($convenciones)){ ?>
			<option value="<?php echo $row_convencion[convencion]; ?>"><?php echo $row_convencion[convencion]?></option>
		<?php }	mysql_data_seek($convenciones,0); ?>
	</select>
	<input type="text" name="txtC1" id="txtC1" size="5" onblur="ponerDireccion();" /><br />

	<select name="convencion2" id="convencion2" onchange="ponerDireccion();">
      <option value="0">[Seleccione Convencion]</option>
		<?php while($row_convencion=mysql_fetch_assoc($convenciones)){ ?>
			<option value="<?php echo $row_convencion[convencion]; ?>"><?php echo $row_convencion[convencion]?></option>
		<?php }	mysql_data_seek($convenciones,0); ?>
	</select>
	<input type="text" name="txtC2" id="txtC2" size="5" onblur="ponerDireccion();" /><br />

	<select name="convencion3" id="convencion3" onchange="ponerDireccion();">
      <option value="0">[Seleccione Convencion]</option>
		<?php while($row_convencion=mysql_fetch_assoc($convenciones)){ ?>
			<option value="<?php echo $row_convencion[convencion]; ?>"><?php echo $row_convencion[convencion]?></option>
		<?php }	mysql_data_seek($convenciones,0); ?>
	</select><input type="text" name="txtC3" id="txtC3" size="5" onblur="ponerDireccion();" /><br />

	<select name="convencion4" id="convencion4" onchange="ponerDireccion();">
      <option value="0">[Seleccione Convencion]</option>
	  <?php while($row_convencion=mysql_fetch_assoc($convenciones)){ ?>
			<option value="<?php echo $row_convencion[convencion]; ?>"><?php echo $row_convencion[convencion]?></option>
		<?php }	mysql_data_seek($convenciones,0); ?>	
	</select><input type="text" name="txtC4" id="txtC4" size="5" onblur="ponerDireccion();" /><br />

	<select name="convencion5" id="convencion5" onchange="ponerDireccion();">
      <option value="0">[Seleccione Convencion]</option>
	  <?php while($row_convencion=mysql_fetch_assoc($convenciones)){ ?>
			<option value="<?php echo $row_convencion[convencion]; ?>"><?php echo $row_convencion[convencion]?></option>
		<?php }	mysql_data_seek($convenciones,0); ?>	
	</select>
	<input type="text" name="txtC5" id="txtC5" size="5" onblur="ponerDireccion();" /><br />

	<select name="convencion6" id="convencion6" onchange="ponerDireccion();">
      <option value="0">[Seleccione Convencion]</option>
	  <?php while($row_convencion=mysql_fetch_assoc($convenciones)){ ?>
			<option value="<?php echo $row_convencion[convencion]; ?>"><?php echo $row_convencion[convencion]?></option>
		<?php }	mysql_data_seek($convenciones,0); ?>
	</select>
	<input type="text" name="txtC6" id="txtC6" size="5" onblur="ponerDireccion();" /><br />

    <textarea id="direccion" name="direccion" rows="7" cols="30"><?php echo $row_directorio['direccion']; ?></textarea><br />
Dir Anterior: <?php echo $row_directorio[direccion]; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Estado:</td>
	  <td>
      <select name="estado">
	  	<option value="0" <?php echo ($row_directorio['estado']==0)?"selected=\"selected\"":"";?>>Estado 1</option>
	  	<option value="1" <?php echo ($row_directorio['estado']==1)?"selected=\"selected\"":"";?>>Estado 2</option>
	  	<option value="2" <?php echo ($row_directorio['estado']==2)?"selected=\"selected\"":"";?>>Estado 3</option>				
	  </select>
	  </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="button" id="EnviarFormDirectorio" value="Insertar/Actualizar" onClick="enviar('DirectorioProcess');"></td>
    </tr>
  </table>
  <input type="hidden" name="modo" value="<?php echo $_GET[modo];?>">
  <input type="hidden" name="telefono_ant" value="<?php echo $row_directorio['telefono']; ?>">
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($directorio);
?>

