<script>
	$(document).ready(function(){
		$('#form_contractual').html5form({
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
		return vehiculo.placa+ " " + vehiculo.numerochasis;
	};
	$("#placa").autocomplete("<?=site_url('parqueautomotor/data/consultarvehiculo/')?>", { 
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
		}
	});
});
	
</script>
<?php echo $mensaje_confirmacion; ?>
<div class="titulo-modulo">Registro de Seg. Contractual</div>
<div class="contenido-modulo border border-radius border-shadow">
    <form method="post" name="form_contractual" id="form_contractual" action="<?=site_url('parqueautomotor/contractual/registro')?>">
        <input type="hidden" name="idcontractual" id="idcontractual" value="<?php if(!empty($datoidcontractual)) echo $datoidcontractual?>" />
        <div class="form">
            <div>
                <label>Placa:</label>
                <input type="hidden" name="idvehiculo" id="idvehiculo" value="<?php if(!empty($datoidvehiculo)) echo $datoidvehiculo?>" />
                <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="<?php if(!empty($datoplaca)) echo $datoplaca?>"  <?php if(!empty($disabled)) echo $disabled?>/>
            </div>
            <?php echo $this->load->view('parqueautomotor/contractualform_view'); ?>
            <div>
                <label>Activo:</label>
                <input type="checkbox" name="activo" style="cursor:pointer;" <?php if(!empty($datoactivo)){ echo $datoactivo; }else{ echo "checked='checked'";}?> />
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