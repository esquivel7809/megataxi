<script>
	$(document).ready(function(){
        
	/*Autocompletar para los vehiculos*/
	function format(dato) {
		return dato.placa+ " - " + dato.numeroplanilla+ " - " + dato.numerodocumento+ " - " + dato.nombrecompleto;
	};

	$("#numeroplanilla").autocomplete("<?=site_url('conductores/data/consultarplanilla/')?>", { 
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idplanilla,
					result: row.idplanilla
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
	$("#numeroplanilla").result(function(event, data, formatted) {
		$('#idplanilla').val(data.idplanilla);
		$('#placa').val(data.placa);
	});
        
        
});
	
</script>
<div class="titulo-modulo">Imprimir Planilla</div>
<div class="contenido-modulo border border-radius border-shadow">
    <form target="_blank" method="post" name="form_planilla" id="form_planilla" action="<?=site_url('imprimir/planilla/index')?>">
        <div class="form">
            <div>
                <label>Numero de Planilla:</label>
                <input type="hidden" name="idplanilla" id="idplanilla" value="" />
                <input type="text" name="numeroplanilla" id="numeroplanilla" required="required" title="Conductor" placeholder="Digite No. planilla o placa" value=""/>
            </div>
            <div>
                <label>Placa:</label>
                <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="" autocomplete="off" readonly="readonly">
            </div>
            <div class="botoneria">
                <?php echo $botoneria; ?>
            </div>
        </div>
    </form>
</div>