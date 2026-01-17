<script>
	$(document).ready(function(){
        
	/*Autocompletar para los vehiculos*/
	function format(dato) {
		return dato.placa+ " - " + dato.numerocarnet+ " - " + dato.numerodocumento+ " - " + dato.nombrecompleto;
	};

	$("#carnetcomunicacion").autocomplete("<?=site_url('comunicaciones/data/consultacarnetcomunicacion/')?>", { 
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.numerocarnet,
					result: row.numerocarnet
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return format(item);
		}
	});
	$("#carnetcomunicacion").result(function(event, data, formatted) {
		$('#idcarnetcomunicacion').val(data.idcarnetcomunicacion);
		$('#placa').val(data.placa);
	});
        
        
});
	
</script>
<div class="titulo-modulo">Imprimir Carnet de Comunicaciones</div>
<div class="contenido-modulo border border-radius border-shadow">
    <form target="_blank" method="post" name="form_vehiculoconductor" id="form_vehiculoconductor" action="<?=site_url('imprimir/carnetcomun/index')?>">
        <div class="form">
            <div>
                <label>Numero de Carnet:</label>
                <input type="hidden" name="idcarnetcomunicacion" id="idcarnetcomunicacion" value="<?php if(!empty($datoidcarnetcomunicacion)) echo $datoidcarnetcomunicacion?>" />
                <input type="text" name="carnetcomunicacion" id="carnetcomunicacion" required="required" title="Conductor" placeholder="Digite placa, No. carnet, cedula o Nombre " value="<?php if(!empty($datocarnet)) echo $datocarnet?>"/>
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