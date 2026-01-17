<form onsubmit="document.getElementById('megaQuitar').select();" action="/megataxi/process/vehiculo.process.php" target="IFrameProcess" method="post">
<table align="center">
    <tr class="tr_title">
        <td>Aplicar Pago</td>
        <td>
            <input type="hidden" name="modo" value="AplicarPago" />
            <input type="text" name="vehiculo" id="megaQuitar" onfocus="if(this.value=='digite placa'){this.value='';}" onblur="if(this.value==''){this.value='digite placa';}" value="digite placa" />
        </td>
        <td>
        	<input type="image" src="../images/tick.png" title="Aplicar Pago" />
        </td>
    </tr>
</table>
</form>