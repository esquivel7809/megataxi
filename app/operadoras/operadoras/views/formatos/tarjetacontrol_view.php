<script>
	$(document).ready(function(){
        
        $('#placa').mask('aaa999');
        $('#numerotarjeta').numeric();
        
	/*Autocompletar para los vehiculos*/
	function formatvehiculo(tarjeta) {
		return tarjeta.placa+ " - " + tarjeta.numerotarjeta+ " - " + tarjeta.numerodocumento+ " - " + tarjeta.nombrecompleto;
	};
	$("#tarjeton").autocomplete("<?=site_url('conductores/data/consultarconductorrefrendacion/')?>", { 
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
	$("#tarjeton").result(function(event, data, formatted) {
		$('#idrefrendacion').val(data.idrefrendacion);
		$('#tarjeton').val(data.numerotarjeta+" "+data.nombrecompleto);
		$('#placa').val(data.placa);
	});
        
        
});
	
</script>
<div class="titulo-modulo">Imprimir tarjeta de control</div>
<div class="contenido-modulo border border-radius border-shadow">
    <form target="_blank" method="post" name="form_vehiculoconductor" id="form_vehiculoconductor" action="<?=site_url('imprimir/tarjetacontrol/index')?>">
        <div class="form">
            <div>
                <label>Numero tarjeta:</label>
                <input type="hidden" name="idrefrendacion" id="idrefrendacion" value="<?php if(!empty($datoidconductor)) echo $datoidconductor?>" />
                <input type="text" name="tarjeton" id="tarjeton" required="required" title="Conductor" placeholder="Digite tarjeta, cedula o placa" value="<?php if(!empty($datonombreconductor)) echo $datonombreconductor?>"/>
            </div>
            <div>
                <label>Placa:</label>
                <input type="text" name="placa" id="placa" class="placa ac_input" required="required" title="Placa" placeholder="Placa" value="" autocomplete="off" readonly="readonly">
            </div>
            <div class="botoneria">
                <?php echo $botoneria; ?>
            </div>
        </div>
    </form>
</div>