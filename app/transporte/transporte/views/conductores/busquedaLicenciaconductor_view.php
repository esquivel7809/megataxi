<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los conductores*/
	function formatlicenciaconductor(licenciaconductor) {
		return licenciaconductor.numerolicenciaconductor + " - " + licenciaconductor.numerodocumento + " - " + licenciaconductor.nombrecompleto;
	};

	$("#busquedalicenciaconductor").autocomplete("<?=site_url('conductores/data/consultarlicenciaconductor')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idlicenciaconductor,
					result: row.idlicenciaconductor
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatlicenciaconductor(item);
		}
	});
	$("#busquedalicenciaconductor").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('conductores/licenciaconductor')?>","idlicenciaconductor="+data.idlicenciaconductor);
            $('#busqueda').dialog('destroy');
			
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedalicenciaconductor" id="busquedalicenciaconductor" placeholder="Digite licencia o cedula del conductor" size="50"/>
        </td>
    </tr>
</table>
