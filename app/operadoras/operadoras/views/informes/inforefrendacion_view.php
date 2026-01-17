<script type="text/javascript">
	$(document).ready(function(){
	   
		var dates = $( "#fechainicial, #fechafinal" ).datepicker({
			changeYear: true,
			changeMonth: true,
            hideIfNoPrevNext : true,
			showOn: 'button',
            maxDate: '+1m',
			buttonImage: '<?=base_url()?>img/cal.png',
			buttonImageOnly: true,
			numberOfMonths: 2,
			onSelect: function( selectedDate ) {
				var option = this.id == "fechainicial" ? "minDate" : "maxDate",
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
<div class="titulo-modulo">Informe de Refrendaci&oacute;n de Tarjeta de Control</div>
<div class="contenido-modulo contenido-informe border border-radius border-shadow">
    <form target="_blank" method="post" name="form_inforefrendacion" id="form_inforefrendacion" action="<?=site_url('informes/inforefrendacion/resultado')?>">
        <input type="hidden" name="idinforefrendacion" id="idinforefrendacion" value="<?php if(!empty($datoinforefrendacion)) echo $datoinforefrendacion?>" />
        <div class="form">
	        <h2 class="subtitulo-modulo"> Criterios de Selecci&oacute;n </h2>
	        <div id="filtros">
	            <?=$filtros?>
	        </div>
	        <h2 class="subtitulo-modulo"> Fechas del Informe </h2>
	        <div class="fechas_informes">
	        	<ul>
	            	<li>Fecha Inicial <input name="fechainicial" type="text"  value="<?=date('01/m/Y')?>"  id="fechainicial" size="10" maxlength="10" readonly="readonly"/></li>
	                <li>Fecha Final<input name="fechafinal" type="text" value="<?=date('d/m/Y')?>" id="fechafinal" size="10" maxlength="10" readonly="readonly" /></li>
	            </ul>
	        
	        </div>
	        <h2 class="subtitulo-modulo"> Tipos de Reporte </h2>
	        <div id="tiporeporte" class="botoneria">
	            <input type="submit" id="Html" name="Html" value="Pantalla" />
	            <?php /* ?><input type="submit" id="pdf" name="pdf" value="PDF" /> <?php */ ?>
	            <input type="submit" id="excel" name="excel" value="Excel" />
	        </div>
        </div>
	</form>
</div>