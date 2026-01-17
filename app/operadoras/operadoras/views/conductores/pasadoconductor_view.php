<script>
	$(document).ready(function(){
		$('#form_pasadoconductor').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#numerocodigoconductor').numeric(); 
		$('#fechaexpedicion, #fechavencimiento').mask("99/99/9999");
		
		$('#fechaexpedicion, #fechavencimiento').live('blur', function(){
				if($(this).val()!="" && $(this).val()!="__/__/____"){
					if(!isDate($(this).val())){
						alert('Fecha Invalida');
						$(this).focus().select();
					}
				}
				if($('#fechaexpedicion').val()!="" && $('#fechavencimiento').val()!="" ){
					if(!compararFechas($('#fechaexpedicion').val(), $('#fechavencimiento').val())){
						alert("la fecha de vencimiento no puede ser menor a la fecha de expedicion");
						$('#fechavencimiento').focus().select();
					}
				}
			});
		var dates = $( "#fechaexpedicion, #fechavencimiento" ).datepicker({
			changeYear: true,
			changeMonth: true,
            hideIfNoPrevNext : true,
			showOn: 'button',
            //maxDate: '+0d',
			buttonImage: '<?=base_url()?>img/cal.png',
			buttonImageOnly: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fechaexpedicion" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" );
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
        
	/*Autocompletar para los conductores*/
	function formatconductor(conductor) {
		return conductor.numerodocumento + " - " + conductor.nombrecompleto;
	};
	$("#conductor").autocomplete("<?=site_url('conductores/data/consultarconductor')?>", {
	   extraParams:{ filtro:"1" }, 
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idconductor,
					result: row.idconductor
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatconductor(item);
		}
	});
	$("#conductor").result(function(event, data, formatted) {
		if (data)
		{
			$("#idconductor").val(data.idconductor);
            $("#conductor").val(data.nombrecompleto);
            $("#placa").focus();
            //$("#placa").flushCache();
            //$("#placa").setOptions(options.extraParams, { idconductor: data.idconductor });
            
            //abrirAjax("#grillavehiculos", "<?=site_url('parqueautomotor/data/consultarvehiculoconductorasociado')?>","idconductor="+data.idconductor);
		}
	});
});
</script>
<div>
    <?php echo $mensaje_confirmacion; ?>
    <div class="titulo-modulo">Registro de Certificados Judiciales</div>
    <div class="contenido-modulo border border-radius border-shadow">
        <form method="post" name="form_pasadoconductor" id="form_pasadoconductor" action="<?=site_url('conductores/pasadoconductor/registro')?>">
            <input type="hidden" name="idpasadoconductor" id="idpasadoconductor" value="<?php if(!empty($datoidpasadoconductor)) echo $datoidpasadoconductor?>" />
            <div class="form">
                <div>
                    <label>Conductor:</label>
                    <input type="hidden" name="idconductor" id="idconductor" value="<?php if(!empty($datoidconductor)) echo $datoidconductor?>" />
                    <input type="text" name="conductor" id="conductor" required="required" title="Digite Nombre o CC del Conductor" placeholder="Digite Nombre o CC del Conductor" value="<?php if(!empty($datonombreconductor)) echo $datonombreconductor?>" />
                </div>
                <div>
                    <label>C&oacute;digo de Verificaci&oacute;n:</label>
                    <input type="text" name="numerocodigoconductor" id="numerocodigoconductor" required="required" title="Nº Codigo de Verificación" placeholder="Digite Nº Codigo de Verificación" value="<?php if(!empty($datonumerocodigoconductor)) echo $datonumerocodigoconductor?>"/>
                </div>
                <div>
                    <label>Fecha de Expedici&oacute;n:</label>
                    <input type="text" name="fechaexpedicion" id="fechaexpedicion" title="Fecha Expedición" placeholder="Fecha Expedición" required size="10" maxlength="10" value="<?php if(!empty($datofechaexpedicion)) echo $datofechaexpedicion?>" />
                </div>
                <div>
                    <label>Fecha Vencimiento:</label>
                    <input type="text" name="fechavencimiento" id="fechavencimiento" title="Fecha Vencimiento" placeholder="Fecha Vencimiento" required size="10" maxlength="10" value="<?php if(!empty($datofechavencimiento)) echo $datofechavencimiento?>" />
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
</div>
