<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los conductores*/
	function formatpasadoconductor(pasadoconductor) {
		return pasadoconductor.numerocodigoconductor + " - " + pasadoconductor.numerodocumento + " - " + pasadoconductor.nombrecompleto;
	};

	$("#busquedapasadoconductor").autocomplete("<?=site_url('conductores/data/consultarpasadoconductor')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idpasadoconductor,
					result: row.idpasadoconductor
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatpasadoconductor(item);
		}
	});
	$("#busquedapasadoconductor").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('conductores/pasadoconductor')?>","idpasadoconductor="+data.idpasadoconductor);
            $('#busqueda').dialog('destroy');
			
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedapasadoconductor" id="busquedapasadoconductor" placeholder="Digite cedula del conductor" size="50"/>
        </td>
    </tr>
</table>
