<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatusuario(usuario) {
		return usuario.loginusuario +" - "+ usuario.nombreusuario +" - "+ usuario.numerodocumento;
	};

	$("#busquedausuario").autocomplete("<?=site_url('administracion/data/consultarusuario')?>", {
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
			return formatusuario(item);
		}
	});
	$("#busquedausuario").result(function(event, data, formatted) {
		if (data)
		{
            abrirAjax("#contenido", "<?=site_url('administracion/usuario')?>","idusuario="+data.idusuario);
            $('#busqueda').dialog('destroy');
			
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedausuario" id="busquedausuario" placeholder="Digite Nombre de Usuario" size="50"/>
        </td>
    </tr>
</table>
