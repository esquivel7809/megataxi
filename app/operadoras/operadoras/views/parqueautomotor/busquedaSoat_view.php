<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatsoat(datos) {
		return datos.placa+ " - " + datos.numerosoat+" - "+datos.activo ;
	};
	$("#busquedasoat").autocomplete("<?=site_url('parqueautomotor/data/consultarsoat')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idsoat,
					result: row.idsoat
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
	$("#busquedasoat").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('parqueautomotor/soat')?>","idsoat="+data.idsoat);
            $('#busqueda').dialog('destroy');
		}
	});
});
</script>
<table>
	<tr>
    	<td>
            <input type="text" name="busquedasoat" id="busquedasoat" placeholder="Digite la Placa o el numero de Soat" size="50"/>
        </td>
    </tr>
</table>
