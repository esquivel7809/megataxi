<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los conductores*/
	function formatconductor(conductor) {
		return conductor.numerodocumento + " - " + conductor.nombrecompleto;
	};

	$("#busquedaconductor").autocomplete("<?=site_url('conductores/data/consultarconductor')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idconductor,
					result: row.idconductor
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
	$("#busquedaconductor").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('conductores/refrendacion')?>","idconductor="+data.idconductor);
            $('#busqueda').dialog('destroy');
			
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedaconductor" id="busquedaconductor" placeholder="Digite cedula o nombre del conductor" size="50"/>
        </td>
    </tr>
</table>
