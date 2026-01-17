<script>
	$(document).ready(function(){
        $('#numerosoat').numeric();
		$('#fechainicialsoat, #fechafinalsoat').mask("99/99/9999");
		
		$('#fechainicialsoat, #fechafinalsoat').live('blur', function(){
				if($(this).val()!="" && $(this).val()!="__/__/____"){
					if(!isDate($(this).val())){
						alert('Fecha Invalida');
						$(this).focus().select();
					}
				}
				if($('#fechainicialsoat').val()!="" && $('#fechafinalsoat').val()!=""){
					if(!compararFechas($('#fechainicialsoat').val(), $('#fechafinalsoat').val())){
						alert("la fecha de final no puede ser menor a la fecha de incial");
						$('#fechafinalsoat').focus().select();
					}
				}
			});
		var dates = $( "#fechainicialsoat, #fechafinalsoat" ).datepicker({
			changeYear: true,
			changeMonth: true,
            hideIfNoPrevNext : true,
			showOn: 'button',
            //maxDate: '+0d',
			buttonImage: '<?=base_url()?>img/cal.png',
			buttonImageOnly: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fechainicialsoat" ? "minDate" : "maxDate",
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
            <select name="idaseguradorasoat" id="idaseguradorasoat" required="required" title="Aseguradora" >
            <?=$aseguradoras?>
            </select>
        </div>
    </div>
    <div>
        <label>Numero SOAT:</label>
        <input type="text" name="numerosoat" id="numerosoat" required="required" title="Número SOAT" placeholder="Número SOAT" value="<?php if(!empty($datonumerosoat)) echo $datonumerosoat?>" />
    </div>
    <div>
        <label>Fecha Inicial:</label>
        <input type="text" name="fechainicialsoat" id="fechainicialsoat" title="Fecha Inicial" placeholder="Fecha Inicial" required="" size="10" maxlength="10" value="<?php if(!empty($datofechainicial)) echo $datofechainicial?>" />
    </div>
    <div>
        <label>Fecha Final:</label>
        <input type="text" name="fechafinalsoat" id="fechafinalsoat" title="Fecha Final" placeholder="Fecha Final" required="" size="10" maxlength="10" value="<?php if(!empty($datofechafinal)) echo $datofechafinal?>" />
    </div>
