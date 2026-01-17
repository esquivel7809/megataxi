<script type="text/javascript">
$(document).ready(function(){
	/*Autocompletar para los vehiculos*/
	function formatvehiculo(vehiculo) {
		return vehiculo.idvehiculo + " - " + vehiculo.placa+ " " + vehiculo.numerochasis;
	};

	$("#busquedavehiculo").autocomplete("<?=site_url('parqueautomotor/data/consultarvehiculo')?>", {
		//extraParams:{ nombreTabla:'medico' },
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idvehiculo,
					result: row.idvehiculo
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatvehiculo(item);
		}
	});
	$("#busquedavehiculo").result(function(event, data, formatted) {
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
            abrirAjax("#contenido", "<?=site_url('parqueautomotor/vehiculos')?>","idvehiculo="+data.idvehiculo);
            $('#busqueda').dialog('destroy');
			
		}
	});

});
</script>

<table>
	<tr>
    	<td>
            <input type="text" name="busquedavehiculo" id="busquedavehiculo" placeholder="Digite la Placa el vehiculo" size="50"/>
        </td>
    </tr>
</table>
