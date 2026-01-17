<script>
	$(document).ready(function(){
        $('#numerotarjetaoperacion').alphanumeric();
		$('#fechainicialopera, #fechafinalopera').mask("99/99/9999");
		
		$('#fechainicialopera, #fechafinalopera').live('blur', function(){
				if($(this).val()!="" && $(this).val()!="__/__/____"){
					if(!isDate($(this).val())){
						alert('Fecha Invalida');
						$(this).focus().select();
					}
				}
				if($('#fechainicialopera').val()!="" && $('#fechafinalopera').val()!=""){
					if(!compararFechas($('#fechainicialopera').val(), $('#fechafinalopera').val())){
						alert("la fecha de final no puede ser menor a la fecha de incial");
						$('#fechafinalopera').focus().select();
					}
				}
			});
		var dates = $( "#fechainicialopera, #fechafinalopera" ).datepicker({
			changeYear: true,
			changeMonth: true,
            hideIfNoPrevNext : true,
			showOn: 'button',
            //maxDate: '+0d',
			buttonImage: '<?=base_url()?>img/cal.png',
			buttonImageOnly: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fechainicialopera" ? "minDate" : "maxDate",
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
        <label>Numero De Tarjeta de Operaci&oacute;n:</label>
        <input type="text" name="numerotarjetaoperacion" id="numerotarjetaoperacion" required title="Número Tarjeta" placeholder="Número Tarjeta" value="<?php if(!empty($datonumerotarjetaoperacion)) echo $datonumerotarjetaoperacion?>" />                    
    </div>
    <div>
        <label>Fecha Inicial:</label>
        <input type="text" name="fechainicialopera" id="fechainicialopera" title="Fecha Inicial" placeholder="Fecha Inicial" required size="10" maxlength="10" value="<?php if(!empty($datofechainicial)) echo $datofechainicial?>" />
    </div>
    <div>
        <label>Fecha Final:</label>
        <input type="text" name="fechafinalopera" id="fechafinalopera" title="Fecha Final" placeholder="Fecha Final" required size="10" maxlength="10" value="<?php if(!empty($datofechafinal)) echo $datofechafinal?>" />
    </div>