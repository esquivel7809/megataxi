<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatsoat(datos) {
		return datos.placa+ " - " + datos.numerocontractual+" - "+datos.activo ;
	};

	$("#busquedacontractual").autocomplete("<?=site_url('parqueautomotor/data/consultarcontractual')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idcontractual,
					result: row.idcontractual
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
	$("#busquedacontractual").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('parqueautomotor/contractual')?>","idcontractual="+data.idcontractual);
            $('#busqueda').dialog('destroy');
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedacontractual" id="busquedacontractual" placeholder="Digite la Placa o el numero del seguro Contractual" size="50"/>
        </td>
    </tr>
</table>
