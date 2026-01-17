<?php require_once('../Connections/conexion.php');
		include('../process/validar.php');
		include('../libraries/javascript.php');
?>
<?php
mysql_select_db($database_conexion, $conexion);

if(isset($_GET['servicio_id'])){
	if($_SESSION['datos']->id_usuario){
		$servicio_sel=mysql_query("select * from servicio where servicio_id='$_GET[servicio_id]' and seleccion=0",$conexion);
		if(mysql_num_rows($servicio_sel)>0){	
			mysql_query("update servicio set seleccion=1, id_usuario='".$_SESSION['datos']->id_usuario."' where servicio_id='$_GET[servicio_id]'",$conexion);	
		}
	}
}

$query_servicios = "SELECT servicio.*, directorio.direccion 
					FROM servicio, directorio 
					WHERE servicio.telefono=directorio.telefono AND servicio.estado=1 
						AND servicio.id_usuario='".$_SESSION["datos"]->id_usuario."' 
					ORDER BY servicio.servicio_id DESC, estado ASC";
$servicios = mysql_query($query_servicios, $conexion) or die(mysql_error());
$row_servicios = mysql_fetch_assoc($servicios);
echo $totalRows_servicios = mysql_num_rows($servicios);

?>
<fieldset>
	<legend>Servicios </legend>
	<?php
    if($totalRows_servicios){
    ?>
    <table border="1" align="center" width="100%">
      <tr class="tr_title">
        <td>No</td>
        <td>Telefono</td>
        <td style="max-width:200px;">Direccion</td>
        <td>Descripcion</td>	
        <td>Hora</td>
        <td>Mega</td>
        <td>Reporta</td>
        <td colspan="2">Accion</td>
      </tr>
      <?php
      $i=1;
       do { 
            $sqlReportados="select mega from reporte_mega_a_servicio where servicio_id='$row_servicios[servicio_id]' and estado=1";
            $result_Reportados=mysql_query($sqlReportados,$conexion) or die(mysql_error());
            //$array_reportado=mysql_fetch_array($result_Reportados);
            //print_r($array_reportado);
            //$row_reportado=mysql_fetch_assoc($result_Reportados);
			$array_final=array("1"=>"","2"=>"","3"=>"","4"=>"","5"=>"");
			$x=1;
			$fila="";
			while ($fila = mysql_fetch_array($result_Reportados)) {
				$array_final[$x]=$fila[0];
				$x++;
			}
			//print_r($array_final);
       		?>
				<tr id="servicios<?php echo $i; ?>" ondblclick="seleccionar_fila('servicios','<?php echo $i;  ?>');"<?php if($row_servicios[tipo_servicio]==1){ echo " style=\"color:#000000;\"";}else if($row_servicios[tipo_servicio]==2){  echo " style=\"color:#000C8F;\""; }else if($row_servicios[tipo_servicio]==3){ echo " style=\"color:#9F0006;\""; } ?>>
					<td><?php echo $i; ?></td>
					<td class="ser_direccion">
						<input name="servicio_id" type="hidden" id="servicio_id<?php echo $i;  ?>" value="<?php echo $row_servicios['servicio_id']; ?>" />
						<!-- <a href="../llamar.php?numero=<?php echo $row_servicios['telefono']; ?>" target="IFrameProcess"> -->
						<a href="#">
						<?php echo $row_servicios['telefono']; ?>
						</a>
					</td>
					<td class="ser_direccion"><?php echo ($row_servicios['direccion']); ?></td>
					<td><?php echo html_entity_decode($row_servicios['descripcion']); ?></td>	  
					<td><?php
						$array_dt_llamada=split(" ",$row_servicios['dt_llamada']);
						echo $array_dt_llamada[1];
					  	?>
					</td>
					<td>
						<input type="text" name="mega1[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');" onfocus="this.select();" onkeypress="accion_objeto(event,'mega1','<?php echo $i; ?>');" onblur="accion_objeto_blur('mega1','<?php echo $i; ?>');" id="mega1<?php echo $i ?>" value="<?php echo $array_final[1]; ?>" size="3" maxlength="4" /> 
						<input type="hidden" id="megaHidden1<?php echo $i ?>" name="megaHidden1[]" value="<?php echo $array_final[1]; ?>" />
						<?php //$row_reportado=mysql_fetch_assoc($result_Reportados); ?>
						<input type="text" name="mega2[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega2','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega2','<?php echo $i; ?>');"  id="mega2<?php echo $i ?>" value="<?php echo $array_final[2]; ?>" size="3" maxlength="4"  />
						<input type="hidden" id="megaHidden2<?php echo $i ?>" name="megaHidden2[]" value="<?php echo $array_final[2]; ?>" />
						<?php //$row_reportado=mysql_fetch_assoc($result_Reportados); ?>
						<input type="text" name="mega3[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega3','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega3','<?php echo $i; ?>');" id="mega3<?php echo $i ?>" value="<?php echo $array_final[3]; ?>" size="3" maxlength="4"  />
						<input type="hidden" id="megaHidden3<?php echo $i ?>" name="megaHidden3[]" value="<?php echo $array_final[3]; ?>" />
						<?php //$row_reportado=mysql_fetch_assoc($result_Reportados); ?>
						<input type="text" name="mega4[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega4','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega4','<?php echo $i; ?>');" id="mega4<?php echo $i ?>" value="<?php echo $array_final[4]; ?>" size="3" maxlength="4"  />
						<input type="hidden" id="megaHidden4<?php echo $i ?>" name="megaHidden4[]" value="<?php echo $array_final[4]; ?>" />
						<?php //$row_reportado=mysql_fetch_assoc($result_Reportados); ?>
						<input type="text" name="mega5[]" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onfocus="this.select();" onblur="accion_objeto_blur('mega5','<?php echo $i; ?>');" onkeypress="accion_objeto(event,'mega5','<?php echo $i; ?>');" id="mega5<?php echo $i ?>" value="<?php echo $array_final[5]; ?>" size="3" maxlength="4"  />
						<input type="hidden" id="megaHidden5<?php echo $i ?>" name="megaHidden5[]" value="<?php echo $array_final[5]; ?>" />
					</td>
					<td>
						<input type="text" name="reporta[]" onfocus="" onclick="seleccionar_fila('servicios','<?php echo $i;  ?>');this.focus();" onkeypress="accion_objeto(event,'reporta','<?php echo $i; ?>');" id="reporta<?php echo $i ?>" size="3" />
					</td>
					<td>
						<form action="../process/servicio.process.php" method="post" target="IFrameProcess" id="CancelaServicio<?php echo $i; ?>">
						<input type="image" src="../images/cancelar.png" border="0" onclick="enviar('CancelaServicio<?php echo $i; ?>');" />
						<input type="hidden" name="servicio_id" value="<?php echo $row_servicios['servicio_id']?>" />
						<input type="hidden" name="modo" value="cancelar" />
						</form>
					</td>
					<td>
						<!-- <a href="../llamar.php?numero=<?php echo $row_servicios['telefono']; ?>" target="IFrameProcess" > -->
						<a href="#" >
						  <img border="0" src="../images/telefono.png" alt="Llamar" /> 
						</a>
					</td>
				</tr>
				<!--<tr>
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
				</tr>-->
        <?php $i++;
        } while ($row_servicios = mysql_fetch_assoc($servicios)); ?>
    </table>
    <form id="ReporteForm" name="ReporteForm" action="" target="IFrameProcess" method="post">
        <input type="hidden" id="RServicio_idTxt" name="RServicio_idTxt" />
        <input type="hidden" id="RMegaTxt" name="RMegaTxt" />	
    </form>
    
    <?php }else if(isset($_GET["servicio_id"])){
    
        $servicio=mysql_query("select directorio.direccion from servicio, directorio where directorio.telefono=servicio.telefono and servicio.servicio_id='$_GET[servicio_id]'",$conexion);
        $row_servicio=mysql_fetch_assoc($servicio);
    
        alert("El servicio para $row_servicio[direccion] ya esta en proceso por otro operador");
    
    }else{
        echo "No hay servicios disponibles";
        
    }
    mysql_free_result($servicios);
    ?>
    <div style="margin-top:15px">
        <table border="0" align="center">
            <tr><td>
            <?php
                if($_SESSION[datos]->perfil==1){ include('../forms/aplica_pago.form.php'); }
            ?>
            </td>
            <td>
                <?php include('../forms/suspender.form.php'); ?>
            </td>
            </tr>
    </table>
    </div>
</fieldset>
