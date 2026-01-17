<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatsoat(datos) {
		return datos.placa+ " - " + datos.numerotarjetaoperacion+" - "+datos.activo ;
	};

	$("#busquedatarjeta").autocomplete("<?=site_url('parqueautomotor/data/consultartarjeta')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idtarjetaoperacion,
					result: row.idtarjetaoperacion
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatsoat(item);
		}
	});
	$("#busquedatarjeta").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('parqueautomotor/tarjetaoperacion')?>","idtarjetaoperacion="+data.idtarjetaoperacion);
            $('#busqueda').dialog('destroy');
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedatarjeta" id="busquedatarjeta" placeholder="Digite la Placa o el numero de Tarjeta" size="50"/>
        </td>
    </tr>
</table>
