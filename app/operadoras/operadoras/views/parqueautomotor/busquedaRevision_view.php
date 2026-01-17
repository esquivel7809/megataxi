<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatsoat(datos) {
		return datos.placa+ " - " + datos.numerorevision+" - "+datos.activo ;
	};

	$("#busquedarevision").autocomplete("<?=site_url('parqueautomotor/data/consultarrevision')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idrevision,
					result: row.idrevision
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
	$("#busquedarevision").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('parqueautomotor/revision')?>","idrevision="+data.idrevision);
            $('#busqueda').dialog('destroy');
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedarevision" id="busquedarevision" placeholder="Digite la Placa o el numero de Revision" size="50"/>
        </td>
    </tr>
</table>
