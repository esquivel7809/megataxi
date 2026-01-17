<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatperfil(perfil) {
		return perfil.nombreperfilusuario;
	};

	$("#busquedaperfil").autocomplete("<?=site_url('administracion/data/consultarperfil')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idusuario,
					result: row.idusuario
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatperfil(item);
		}
	});
	$("#busquedaperfil").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('administracion/perfil')?>","idperfilusuario="+data.idperfilusuario);
            $('#busqueda').dialog('destroy');
			
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedaperfil" id="busquedaperfil" placeholder="Digite Nombre Perfil" size="50"/>
        </td>
    </tr>
</table>
