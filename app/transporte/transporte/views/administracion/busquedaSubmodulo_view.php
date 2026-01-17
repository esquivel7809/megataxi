<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatsubmodulo(submodulo) {
		return submodulo.nombresubmodulo +" - "+ submodulo.nombremodulo;
	};

	$("#busquedasubmodulo").autocomplete("<?=site_url('administracion/data/consultarsubmodulo')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idsubmodulo,
					result: row.idsubmodulo
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatsubmodulo(item);
		}
	});
	$("#busquedasubmodulo").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('administracion/submodulo')?>","idsubmodulo="+data.idsubmodulo);
            $('#busqueda').dialog('destroy');
			
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedasubmodulo" id="busquedasubmodulo" placeholder="Digite Nombre del Submodulo" size="50"/>
        </td>
    </tr>
</table>
