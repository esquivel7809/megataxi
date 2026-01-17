<form id="NuevoServicio" target="IFrameProcess" action="../process/servicio.process.php" method="post">
<h2>Nuevo Servicio</h2>
<table align="center" border="0">
	<tr>
		<td>
			<table align="center" border="0">
				<tr>
					<td>Ingrese Numero Telef&oacute;nico</td>
					<td><input type="text" name="telefono" id="telManual" value="" onKeyUp="buscar_direccion('telManual');" onload="this.focus();" onfocus="" onblur="document.getElementById('NumeroALlamar').value=this.value;" />
				   		<img src="../images/telefono.png" width="25" height="25" alt="Llamar" onclick="
//                        alert(document.getElementById('FormLlamarCliente').action);
                        document.getElementById('FormLlamarCliente').submit();
                       " style="cursor:pointer;" />
                   </td>
				</tr>
				<tr>
				  <td>Direccion:</td>
				  <td><div id="direccionCliente"></div></td>
                </tr>
				<tr>
			      <td>Descripcion:</td>
				  <td><textarea name="descripcion" id="descripcion" cols="25" rows="5"></textarea></td>
			    </tr>
				<tr>
			      <td>Tipo Serivicio :</td>
				  <td> T <input type="radio" name="tipo_servicio" value="1" checked="checked" />
				  &nbsp;&nbsp;D <input type="radio" name="tipo_servicio" value="2" />
				  &nbsp;&nbsp;M <input type="radio" name="tipo_servicio" value="3" />&nbsp;&nbsp; </td>
			    </tr>
				<tr>
					<td></td>
					<td><input type="button" onclick="if(document.getElementById('direccion').value!=''){document.getElementById('NuevoServicio').submit();}else{ alert('No se puede guardar un numero con direccion vacia');}" value="Guardar" name="Guardar" onload="document.getElementById('telManual').focus();";></td>
     		  </tr>
			</table>
		</td>
		<td>
			<div id="div_llamadas_actuales">
				<?php include('llamadas_actuales.php'); ?>
			</div>
		</td>
	</tr>
</table>
</form>
<form id="FormLlamarCliente" action="../llamar.php" target="IFrameProcess">
	<input type="hidden" id="NumeroALlamar" name="numero" />
</form>