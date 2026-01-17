<script>
	$(document).ready(function(){
        $('#numerocontractual').alphanumeric();
		$('#fechainicialcontra, #fechafinalcontra').mask("99/99/9999");
		
		$('#fechainicialcontra, #fechafinalcontra').live('blur', function(){
				if($(this).val()!="" && $(this).val()!="__/__/____"){
					if(!isDate($(this).val())){
						alert('Fecha Invalida');
						$(this).focus().select();
					}
				}
				if($('#fechainicialcontra').val()!="" && $('#fechafinalcontra').val()!=""){
					if(!compararFechas($('#fechainicialcontra').val(), $('#fechafinalcontra').val())){
						alert("la fecha de final no puede ser menor a la fecha de incial");
						$('#fechafinalcontra').focus().select();
					}
				}
			});
		var dates = $( "#fechainicialcontra, #fechafinalcontra" ).datepicker({
			changeYear: true,
			changeMonth: true,
            hideIfNoPrevNext : true,
			showOn: 'button',
            //maxDate: '+0d',
			buttonImage: '<?=base_url()?>img/cal.png',
			buttonImageOnly: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fechainicialcontra" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" );
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
</script>
    <div>
        <label>Aseguradora:</label>
        <div class="wrapper-select-form">
            <select name="idaseguradoracontra" id="idaseguradoracontra" required="required" title="Aseguradora" >
            <?=$aseguradoras?>
            </select>
        </div>
    </div>
    <div>
        <label>Numero Seg. Contractual:</label>
        <input type="text" name="numerocontractual" id="numerocontractual" required="required" title="Nº Seg. Contractual" placeholder="Nº Seg. Contractual" value="<?php if(!empty($datonumerocontractual)) echo $datonumerocontractual?>" />
    </div>
    <div>
        <label>Fecha Inicial:</label>
        <input type="text" name="fechainicialcontra" id="fechainicialcontra" title="Fecha Inicial" placeholder="Fecha Inicial" required="" size="10" maxlength="10" value="<?php if(!empty($datofechainicial)) echo $datofechainicial?>" />
    </div>
    <div>
        <label>Fecha Final:</label>
        <input type="text" name="fechafinalcontra" id="fechafinalcontra" title="Fecha Final" placeholder="Fecha Final" required="" size="10" maxlength="10" value="<?php if(!empty($datofechafinal)) echo $datofechafinal?>" />
    </div>