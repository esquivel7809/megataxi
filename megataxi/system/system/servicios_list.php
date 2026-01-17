<?php require_once('../Connections/conexion.php');
		include('../process/validar.php');
		include('../libraries/javascript.php');
?>
<?php
mysql_select_db($database_conexion, $conexion);

if(isset($_GET[servicio_id])){
	if($_SESSION[datos]->id_usuario){
		$servicio_sel=mysql_query("select * from servicio where servicio_id='$_GET[servicio_id]' and seleccion=0",$conexion);
		if(mysql_num_rows($servicio_sel)>0){	
			mysql_query("update servicio set seleccion=1, id_usuario='".$_SESSION[datos]->id_usuario."' where servicio_id='$_GET[servicio_id]'",$conexion);	
		}
	}
}


$query_servicios = "select servicio.*, directorio.direccion from servicio, directorio where servicio.telefono=directorio.telefono and servicio.estado=1 and servicio.id_usuario='".$_SESSION[datos]->id_usuario."' order by servicio.servicio_id desc, estado asc";
$servicios = mysql_query($query_servicios, $conexion) or die(mysql_error());
$row_servicios = mysql_fetch_assoc($servicios);
$totalRows_servicios = mysql_num_rows($servicios);
?>


<fieldset>
        <legend>Servicios</legend>


<?php

if($totalRows_servicios){

?>

<br />
<table border="1" align="center">
  <tr class="tr_title">
    <td>Telefono</td>
    <td style="max-width:200px;">Direccion</td>
    <td>Descripcion</td>	
    <td>Hora</td>
	<td>Mega</td>
	<td>Reporta</td>
	<td>Accion</td>
  </tr>
  <?php
  $i=10;
   do { 
      	$sqlReportados="select mega from reporte_mega_a_servicio where servicio_id='$row_servicios[servicio_id]' and estado=1";
		$result_Reportados=mysql_query($sqlReportados,$conexion) or die(mysql_error());
		$row_reportado=mysql_fetch_assoc($result_Reportados);
   ?>
   

   
    <tr id="servicios<?php echo $i; ?>" ondblclick="seleccionar_fila('servicios','<?php echo $i;  ?>');"<?php if($row_servicios[tipo_servicio]==1){ echo " style=\"color:#000000;\"";}else if($row_servicios[tipo_servicio]==2){  echo " style=\"color:#000C8F;\""; }else if($row_servicios[tipo_servicio]==3){ echo " style=\"color:#9F0006;\""; } ?>>
      <td><input name="servicio_id" type="hidden" id="servicio_id<?php echo $i;  ?>" value="<?php echo $row_servicios['servicio_id']; ?>" />
        
      
      
      <a target="IFrameProcess" href="../llamar.php?numero=<?php  echo $row_servicios['telefono']; ?>"><?php echo $row_servicios['telefono']; ?></a>
      
      
      
      </td>
      <td><?php echo $row_servicios['direccion']; ?></td>
      <td><?php echo $row_servicios['descripcion']; ?></td>	  
      <td><?php echo $row_servicios['dt_llamada']; ?></td>
	  <td rowspan="2">
	    <input type="text" name="mega1[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onkeypress="accion_objeto(event,'mega1','<?php echo $i; ?>');" onblur="accion_objeto_blur('mega1','<?php echo $i; ?>');" id="mega1<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" /> 
		<input type="hidden" id="megaHidden1<?php echo $i ?>" name="megaHidden1[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega2[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega2','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega2','<?php echo $i; ?>');"  id="mega2<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
		<input type="hidden" id="megaHidden2<?php echo $i ?>" name="megaHidden2[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega3[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega3','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega3','<?php echo $i; ?>');" id="mega3<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
		<input type="hidden" id="megaHidden3<?php echo $i ?>" name="megaHidden3[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
		<input type="text" name="mega4[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega4','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega4','<?php echo $i; ?>');" id="mega4<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
		<input type="hidden" id="megaHidden4<?php echo $i ?>" name="megaHidden4[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega5[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega5','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega5','<?php echo $i; ?>');" id="mega5<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
	    <input type="hidden" id="megaHidden5<?php echo $i ?>" name="megaHidden5[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega6[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega6','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega6','<?php echo $i; ?>');" id="mega6<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
	    <input type="hidden" id="megaHidden6<?php echo $i ?>" name="megaHidden6[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega7[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega7','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega7','<?php echo $i; ?>');" id="mega7<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
	    <input type="hidden" id="megaHidden7<?php echo $i ?>" name="megaHidden7[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega8[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega8','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega8','<?php echo $i; ?>');" id="mega8<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />

		<input type="hidden" id="megaHidden8<?php echo $i ?>" name="megaHidden8[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega9[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega9','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega9','<?php echo $i; ?>');" id="mega9<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
		<input type="hidden" id="megaHidden9<?php echo $i ?>" name="megaHidden9[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega10[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega10','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega10','<?php echo $i; ?>');" id="mega10<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
		<input type="hidden" id="megaHidden10<?php echo $i ?>" name="megaHidden10[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega11[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega11','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega11','<?php echo $i; ?>');" id="mega11<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
		<input type="hidden" id="megaHidden11<?php echo $i ?>" name="megaHidden11[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega12[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega12','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega12','<?php echo $i; ?>');" id="mega12<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
		<input type="hidden" id="megaHidden12<?php echo $i ?>" name="megaHidden12[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega13[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega13','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega13','<?php echo $i; ?>');" id="mega13<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
		<input type="hidden" id="megaHidden13<?php echo $i ?>" name="megaHidden13[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega14[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega14','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega14','<?php echo $i; ?>');" id="mega14<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
		<input type="hidden" id="megaHidden14<?php echo $i ?>" name="megaHidden14[]" value="<?php echo $row_reportado[mega]; ?>" />
		<?php $row_reportado=mysql_fetch_assoc($result_Reportados); ?>
	    <input type="text" name="mega15[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega15','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega15','<?php echo $i; ?>');" id="mega15<?php echo $i ?>" value="<?php echo $row_reportado[mega]; ?>" size="3" />
	    <input type="hidden" id="megaHidden15<?php echo $i ?>" name="megaHidden15[]" value="<?php echo $row_reportado[mega]; ?>" /></td>
		
		<td><input type="text" name="reporta[]" onfocus="" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onkeypress="accion_objeto(event,'reporta','<?php echo $i; ?>');" id="reporta<?php echo $i ?>" size="3" /></td>
		<td><form action="../process/servicio.process.php" method="post" target="IFrameProcess" id="CancelaServicio<?php echo $i; ?>"><input type="button" value="Cancelar" onclick="enviar('CancelaServicio<?php echo $i; ?>');" /><input type="hidden" name="servicio_id" value="<?php echo $row_servicios[servicio_id]?>" /><input type="hidden" name="modo" value="cancelar" /></form></td>
    </tr>
	<tr>
		<td style="border-top:#FFFFFF; color:#ffffff">x
		</td>
		<td style="border-top:#FFFFFF;">
		</td>
		<td style="border-top:#FFFFFF;">
		</td>
		<td style="border-top:#FFFFFF;">
		</td>	
		<td style="border-top:#FFFFFF;">
		</td>					
	</tr>
    <?php $i++;
	} while ($row_servicios = mysql_fetch_assoc($servicios)); ?>
</table>
<form id="ReporteForm" name="ReporteForm" action="" target="IFrameProcess" method="post">
	<input type="hidden" id="RServicio_idTxt" name="RServicio_idTxt" />
	<input type="hidden" id="RMegaTxt" name="RMegaTxt" />	
</form>

<?php }else if(isset($_GET[servicio_id])){

	$servicio=mysql_query("select directorio.direccion from servicio, directorio where directorio.telefono=servicio.telefono and servicio.servicio_id='$_GET[servicio_id]'",$conexion);
	$row_servicio=mysql_fetch_assoc($servicio);

	alert("El servicio para $row_servicio[direccion] ya esta en proceso por otro operador");

}else{
	echo "No hay servicios disponibles";
	
}
mysql_free_result($servicios);
?>
<table border="0" align="center">
<tr><td>
<?php
include('../forms/aplica_pago.form.php');
?>
</td>
<td>
<?php include('../forms/suspender.form.php'); ?>
</td>
</tr>
</table>
</fieldset>
