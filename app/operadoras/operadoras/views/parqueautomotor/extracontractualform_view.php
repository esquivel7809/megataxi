<script>
	$(document).ready(function(){
        $('#numeroextracontractual').alphanumeric();
		$('#fechainicialextra, #fechafinalextra').mask("99/99/9999");
		
		$('#fechainicialextra, #fechafinalextra').live('blur', function(){
				if($(this).val()!="" && $(this).val()!="__/__/____"){
					if(!isDate($(this).val())){
						alert('Fecha Invalida');
						$(this).focus().select();
					}
				}
				if($('#fechainicialextra').val()!="" && $('#fechafinalextra').val()!=""){
					if(!compararFechas($('#fechainicialextra').val(), $('#fechafinalextra').val())){
						alert("la fecha de final no puede ser menor a la fecha de incial");
						$('#fechafinalextra').focus().select();
					}
				}
			});
		var dates = $( "#fechainicialextra, #fechafinalextra" ).datepicker({
			changeYear: true,
			changeMonth: true,
            hideIfNoPrevNext : true,
			showOn: 'button',
            //maxDate: '+0d',
			buttonImage: '<?=base_url()?>img/cal.png',
			buttonImageOnly: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fechainicialextra" ? "minDate" : "maxDate",
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
            <select name="idaseguradoraextra" id="idaseguradoraextra" required="required" title="Aseguradora" >
            <?=$aseguradoras?>
            </select>
        </div>
    </div>
    <div>
        <label>Numero Seg. Extracontractual:</label>
        <input type="text" name="numeroextracontractual" id="numeroextracontractual" required="required" title="Nº Seg. Extracontractual" placeholder="Nº Seg. Extracontractual" value="<?php if(!empty($datonumeroextracontractual)) echo $datonumeroextracontractual?>" />
    </div>
    <div>
        <label>Fecha Inicial:</label>
        <input type="text" name="fechainicialextra" id="fechainicialextra" title="Fecha Inicial" placeholder="Fecha Inicial" required="" size="10" maxlength="10" value="<?php if(!empty($datofechainicial)) echo $datofechainicial?>" />
    </div>
    <div>
        <label>Fecha Final:</label>
        <input type="text" name="fechafinalextra" id="fechafinalextra" title="Fecha Final" placeholder="Fecha Final" required="" size="10" maxlength="10" value="<?php if(!empty($datofechafinal)) echo $datofechafinal?>" />
    </div>
