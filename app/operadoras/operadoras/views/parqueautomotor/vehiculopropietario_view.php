<script>
	$(document).ready(function(){
		$('#form_vehiculopropietario').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#placa').mask('aaa999');
        $('#numerotarjeta').numeric();
        
        
	/*Autocompletar para los propietarios*/
	function formatconductor(conductor) {
		return conductor.numerodocumento + " - " + conductor.nombrecompleto;
	};
	$("#propietario").autocomplete("<?=site_url('conductores/data/consultarpropietario')?>", {
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idconductor,
					result: row.idconductor
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatconductor(item);
		}
	});
	$("#propietario").result(function(event, data, formatted) {
		if (data)
		{
			$("#idpropietario").val(data.idconductor);
            $("#propietario").val(data.nombrecompleto);
            //$("#placa").focus();
            //$("#placa").flushCache();
            //$("#placa").setOptions(options.extraParams, { idconductor: data.idconductor });
            //abrirAjax("#grillavehiculos", "<?=site_url('parqueautomotor/data/consultarvehiculoconductorasociado')?>","idconductor="+data.idconductor);
		}
	});
        
	/*Autocompletar para los vehiculos*/
	function formatvehiculo(vehiculo) {
		return vehiculo.placa+ " " + vehiculo.numerochasis;
	};
	$("#placa").autocomplete("<?=site_url('parqueautomotor/data/consultarvehiculo')?>", { 
        //extraParams:{ idconductor: 2 },
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
	$("#placa").result(function(event, data, formatted) {
		if (data)
		{
            $("#idvehiculo").val(data.idvehiculo);		  
            $("#placa").val(data.placa);
            $("#propietario").focus();
            abrirAjax("#grillapropietarios", "<?=site_url('parqueautomotor/data/consultarvehiculopropietario')?>","idvehiculo="+data.idvehiculo);
		}
	});
});
	
</script>
<?php echo $mensaje_confirmacion; ?>
<div class="titulo-modulo">Asociar Propietario</div>
<div class="contenido-modulo border border-radius border-shadow">
    <form method="post" name="form_vehiculopropietario" id="form_vehiculopropietario" action="<?=site_url('parqueautomotor/vehiculopropietario/registro')?>">
        <input type="hidden" name="idvehiculopropietario" id="idvehiculopropietario" value="<?php if(!empty($datoidvehiculopropietario)) echo $datoidvehiculopropietario?>" />
        <div class="form">
            <div>
                <label>Placa:</label>
                <input type="hidden" name="idvehiculo" id="idvehiculo" value="<?php if(!empty($datoidvehiculo)) echo $datoidvehiculo?>" />
                <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="<?php if(!empty($datoplaca)) echo $datoplaca?>" />
            </div>
            <div>
                <label>Propietario:</label>
                <input type="hidden" name="idpropietario" id="idpropietario" value="<?php if(!empty($datoidpropietario)) echo $datoidpropietario?>" />
                <input type="text" name="propietario" id="propietario" required="required" title="Digite Propietario" placeholder="Digite Propietario" value="<?php if(!empty($datonombreconductor)) echo $datonombreconductor?>"/>
            </div>
            <div class="botoneria">
                <?=$botoneria ?>
            </div>
            <div id="grillapropietarios">
                <?=$botoneria_ ?>
            </div>
        </div>
    </form>
</div>
