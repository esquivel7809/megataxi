<br />
<table width="477" border="0" align="center">
	<tr>
		<td width="166">&nbsp;</td>
		<td width="172"><a style="cursor:pointer;" onclick="nuevo_servicio();">Nuevo Servicio</a></td>
		<td width="125"><a href="servicios.php">Reporte De Servicios</a></td>
	</tr>
</table>


<div id="panel_servicios">
	<?php
		include('servicios_list.php');
	?>
</div>
	<div id="ultimos">
		<div id="ultimos_eventos"><?php include('ultimos_eventos.php'); ?></div>
	</div>

<script language="javascript">

	abrir('/megataxi/system/ultimos_servicios_pedidos.php','','','ultimos_servicios');
	
	LastServices=setInterval("abrir('/megataxi/system/ultimos_eventos.php','','','ultimos');",3000);
//	LastClients=setInterval("abrir('/megataxi/system/clientes_nuevos.php','','','ultimos_clientes');",3000);

</script>
