<form onsubmit="document.getElementById('megaSuspender').select();" action="/megataxi/process/vehiculo.process.php" target="IFrameProcess" method="post">
	<table align="center">
		<tr class="tr_title">
			<td>Suspender</td>
			<td>
				<input type="hidden" name="modo" value="suspender" />
				<input type="text" name="placa" id="megaSuspender" onfocus="if(this.value=='digite placa'){this.value='';}" onblur="if(this.value==''){this.value='digite placa';}" value="digite placa" />
			</td>
			<td>
				<input type="image" title="Suspender" onclick="abrir('/megataxi/forms/suspension.form.php','','&stop=1&vehiculo='+document.getElementById('megaSuspender').value,'Edicion');ver_div_edit();" src="../images/cancelar.png" />
			</td>
		</tr>
	</table>
</form>