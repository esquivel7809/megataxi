<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatsoat(datos) {
		return datos.placa+ " - " + datos.numeroextracontractual+" - "+datos.activo ;
	};

	$("#busquedaextracontractual").autocomplete("<?=site_url('parqueautomotor/data/consultarextracontractual')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idextracontractual,
					result: row.idextracontractual
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
	$("#busquedaextracontractual").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('parqueautomotor/extracontractual')?>","idextracontractual="+data.idextracontractual);
            $('#busqueda').dialog('destroy');
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedaextracontractual" id="busquedaextracontractual" placeholder="Digite la Placa o el numero del seguro Extra-Contractual" size="50"/>
        </td>
    </tr>
</table>
