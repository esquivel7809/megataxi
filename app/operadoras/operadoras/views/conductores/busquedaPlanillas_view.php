<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los conductores*/
	function formatconductor(conductor) {
		return conductor.numeroplanilla + " - " + conductor.placa + " - " + conductor.numerodocumento + " - " + conductor.nombrecompleto;
	};

	$("#busquedaplanilla").autocomplete("<?=site_url('conductores/data/consultarplanilla')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idplanilla,
					result: row.idplanilla
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatconductor(item);
		}
	});
	$("#busquedaplanilla").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('conductores/planilla')?>","idplanilla="+data.idplanilla);
            $('#busqueda').dialog('destroy');
			
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedaplanilla" id="busquedaplanilla" placeholder="Digite numero de planilla, placa o cedula conductor" size="50"/>
        </td>
    </tr>
</table>
