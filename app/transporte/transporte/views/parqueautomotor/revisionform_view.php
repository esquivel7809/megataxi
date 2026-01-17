<script>
	$(document).ready(function(){
        $('#numerorevision').alphanumeric();
		$('#fechainicialrevision, #fechafinalrevision').mask("99/99/9999");
		
		$('#fechainicialrevision, #fechafinalrevision').live('blur', function(){
				if($(this).val()!="" && $(this).val()!="__/__/____"){
					if(!isDate($(this).val())){
						alert('Fecha Invalida');
						$(this).focus().select();
					}
				}
				if($('#fechainicialrevision').val()!="" && $('#fechafinalrevision').val()!=""){
					if(!compararFechas($('#fechainicialrevision').val(), $('#fechafinalrevision').val())){
						alert("la fecha de final no puede ser menor a la fecha de incial");
						$('#fechafinalrevision').focus().select();
					}
				}
			});
		var dates = $( "#fechainicialrevision, #fechafinalrevision" ).datepicker({
			changeYear: true,
			changeMonth: true,
            hideIfNoPrevNext : true,
			showOn: 'button',
            //maxDate: '+0d',
			buttonImage: '<?=base_url()?>img/cal.png',
			buttonImageOnly: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fechainicialrevision" ? "minDate" : "maxDate",
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
        <label>Centro de Diagnostico Automotor:</label>
        <div class="wrapper-select-form">
            <select name="idcda" id="idcda" required title="Centro de Diagnostico Automotor" >
            <?=$cda?>
            </select>
        </div>
    </div>
    <div>
        <label>Numero Certificado:</label>
        <input type="text" name="numerorevision" id="numerorevision" required= title="Número Certificado" placeholder="Número Certificado" value="<?php if(!empty($datonumerorevision)) echo $datonumerorevision?>" />
    </div>
    <div>
        <label>Fecha Inicial:</label>
        <input type="text" name="fechainicialrevision" id="fechainicialrevision" title="Fecha Inicial" placeholder="Fecha Inicial" required size="10" maxlength="10" value="<?php if(!empty($datofechainicial)) echo $datofechainicial?>" />
    </div>
    <div>
        <label>Fecha Final:</label>
        <input type="text" name="fechafinalrevision" id="fechafinalrevision" title="Fecha Final" placeholder="Fecha Final" required size="10" maxlength="10" value="<?php if(!empty($datofechafinal)) echo $datofechafinal?>" />
    </div>
