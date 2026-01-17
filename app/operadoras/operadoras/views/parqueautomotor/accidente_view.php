<script>
$(document).ready(function(){
	$('#form_accidente').html5form({
		//responseDiv: '#contenido',
		messages: 'es',
		colorOn: '#6b6764',
		colorOff: '#b4b1af',
		allBrowsers: true,
		emailMessage: 'Dirección de correo inválida'
	});
	
	$('#placa').mask('aaa999');
	$('#fecha_accidente').mask("99/99/9999");
	
	$('#fecha_accidente').live('blur', function(){
		if($(this).val()!="" && $(this).val()!="__/__/____"){
			if(!isDate($(this).val())){
				alert('Fecha Invalida');
				$(this).focus().select();
			}
		}
		if($(this).val()!=""){
			var fechaactual = GetTodayDate("dd/mm/aaaa");
			if(!compararFechas($(this).val(), fechaactual )){
				alert("la fecha del accidente no puede ser mayor a la fecha de actual");
				$('#fecha_accidente').focus().select();
			}
		}
	});
	// se inicializa el calendario para la fecha de matricula
	$('#fecha_accidente').datepicker({
		changeMonth: true,
		changeYear: true,
		hideIfNoPrevNext : true,
		showOn: 'button',
		maxDate: '+0d',
		buttonText: 'Fecha de Matricula',
		buttonImage: '<?=base_url()?>img/cal.png',
		buttonImageOnly: true
		});
	
	/*Autocompletar para los vehiculos*/
	function formatvehiculo(tarjeta) {
		return tarjeta.placa+ " - " + tarjeta.numerodocumento+ " - " + tarjeta.nombrecompleto;
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
		$('#idvehiculoconductor').val(data.idvehiculoconductor);
		$('#tarjeton').val(data.nombrecompleto);
		$('#placa').val(data.placa);
	});
});
	
</script>
<?php echo $mensaje_confirmacion; ?>
<div class="titulo-modulo">Registro de Accidentes de los Vehiculos</div>
<div class="contenido-modulo border border-radius border-shadow">
    <form method="post" name="form_accidente" id="form_accidente" action="<?=site_url('parqueautomotor/accidente/registro')?>">
        <input type="hidden" name="idvehiculopropietario" id="idvehiculopropietario" value="">
        <div class="form">
            <div>
                <label>Conductor:</label>
                <input type="hidden" name="idvehiculoconductor" id="idvehiculoconductor" value="" />
                <input type="text" name="tarjeton" id="tarjeton" required="required" title="Conductor" placeholder="Digite tarjeta, cedula o placa" value=""/>
            </div>
            <div>
                <label>Placa:</label>
                <input type="text" name="placa" id="placa" class="placa ac_input" required="required" title="Placa" placeholder="Placa" value="" autocomplete="off" readonly="readonly">
            </div>
            <div>
                <label>Fecha Accidente:</label>
                <input type="text" name="fecha_accidente" id="fecha_accidente" title="Fecha Accidente" placeholder="Fecha Accidente" required="" size="10" maxlength="10" value="">
            </div>
            <div>
                <label>Descripci&oacute;n:</label>
                <textarea name="descripcion" id="descripcion" placeholder="Descripción del accidente" required="" >&nbsp;</textarea>
            </div>
            <div>
                <label>¿Hubo personas leccionadas?</label>
                <div id="privado" class="radio-section curso-edit-form-seccion-radio">
                    <span>
                        <input name="lecciones" type="radio" checked="checked" value="1">
                    </span>
                    <label class="label-radio">Ninguna</label>
                    <span>
                        <input name="lecciones" type="radio" value="2">
                    </span>
                    <label class="label-radio">Muertas</label>
                    <span>
                        <input name="lecciones" type="radio" value="3">
                    </span>
                    <label class="label-radio">Heridas</label>
                    <span>
                        <input name="lecciones" type="radio" value="4">
                    </span>
                    <label class="label-radio">Ambas</label>
                </div>
            </div>            
            <div class="botoneria">
                <?=$botoneria ?>
            </div>
        </div>
    </form>
</div>