<script>
	$(document).ready(function(){
		$('#form_vehiculomega').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#placa').mask('aaa999');
        
	/*Autocompletar para los vehiculos*/
	function formatvehiculo(vehiculo) {
		return vehiculo.placa+ " " + vehiculo.serieradiotelefono;
	};
	$("#placa").autocomplete("<?=site_url('comunicaciones/data/consultavehiculoradiotelefono/')?>", { 
        //extraParams:{ idconductor: 2 },
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idvehiculoradiotelefono,
					result: row.idvehiculoradiotelefono
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
            $("#idvehiculoradiotelefono").val(data.idvehiculoradiotelefono);		  
            $("#placa").val(data.placa);
		}
	});
        
	/*Autocompletar para los megas */
	function formatmega(mega) {
		return mega.numeromega;
	};
	$("#mega").autocomplete("<?=site_url('comunicaciones/data/consultarmega/')?>", { 
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idmega,
					result: row.idmega
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatmega(item);
		}
	});
	$("#mega").result(function(event, data, formatted) {
		if (data)
		{
            $("#idmega").val(data.idmega);
            $("#idcanal").val(data.idcanal);
			$("#mega").val(data.numeromega);
		}
	});
});
</script>
<div>
    <?php echo $mensaje_confirmacion; ?>
    <div class="titulo-modulo">Asociar Mega</div>
    <div class="contenido-modulo border border-radius border-shadow">
        <form method="post" name="form_vehiculomega" id="form_vehiculomega" action="<?=site_url('comunicaciones/vehiculomega/registro')?>">
            <div class="form">
                <div>
                    <label>Placa:</label>
                    <input type="hidden" name="idvehiculoradiotelefono" id="idvehiculoradiotelefono" value="<?php if(!empty($datoidvehiculoradiotelefono)) echo $datoidvehiculoradiotelefono?>" />
                    <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="<?php if(!empty($datoplaca)) echo $datoplaca?>" />
                </div>
                <div>
                    <label>N° Mega o EME: </label>
                    <input type="hidden" name="idmega" id="idmega" required="required" title="Numero de Mega o EME" placeholder="Digite Numero de Mega o EME" value="<?php if(!empty($datomodeloradiotelefono)) echo $datomodeloradiotelefono?>" />
                    <input type="text" name="mega" id="mega" required="required" title="Numero de Mega o EME" placeholder="Digite Numero de Mega o EME" value="<?php if(!empty($datomodeloradiotelefono)) echo $datomodeloradiotelefono?>" />
                    
                </div>
                <div class="checkbox-section" style="display:none;">
                    <label>Activo :</label>
                    <span class="unchecked">
                        <input type="checkbox" name="activo" <?php if(!empty($datoactivo)) echo $datoactivo?> />
                    </span>
                </div>
                <div class="botoneria">
                    <?php echo $botoneria; ?>
                </div>
            </div>
        </form>
    </div>
</div>