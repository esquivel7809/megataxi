<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatmodulo(modulo) {
		return modulo.nombremodulo;
	};

	$("#busquedamodulo").autocomplete("<?=site_url('administracion/data/consultarmodulo')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idmodulo,
					result: row.idmodulo
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatmodulo(item);
		}
	});
	$("#busquedamodulo").result(function(event, data, formatted) {
		if (data)
		{
		  /*
			$("#idpacientereclamacion").val(data.idpaciente);
			$("#idtipodocumento_").val(data.idtipodocumento);
			$("#nombrepaciente_").val(data.nombrepaciente);
			$("#fechanacimiento_").val(data.fechanacimiento);
			$("#edadpaciente_").val(data.edad);
            */
            
            //alert(data.idvehiculo);
            abrirAjax("#contenido", "<?=site_url('administracion/modulo')?>","idmodulo="+data.idmodulo);
            $('#busqueda').dialog('destroy');
			
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedamodulo" id="busquedamodulo" placeholder="Digite Nombre del Modulo" size="50"/>
        </td>
    </tr>
</table>
