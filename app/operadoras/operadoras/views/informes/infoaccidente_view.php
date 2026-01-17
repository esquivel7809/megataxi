<script type="text/javascript">
	$(document).ready(function(){
	   
		var dates = $( "#fechainicial, #fechafinal" ).datepicker({
			changeYear: true,
			changeMonth: true,
            hideIfNoPrevNext : true,
			showOn: 'button',
            //maxDate: '+0d',
			buttonImage: '<?=base_url()?>img/transporte/cal.png',
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
<div class="clear"></div>
<div class="grid_9">
    <fieldset>
    	<legend>Informe de Accidentes de Vehiculos</legend>
        <form target="_blank" method="post" name="form_infoaccidente" id="form_infoaccidente" action="<?=site_url('informes/infoaccidente/resultado')?>">
            <input type="hidden" name="idinfosoat" id="idinfosoat" value="<?php if(!empty($datoidinfosoat)) echo $datoidinfosoat?>" />
            <table>
                <tr>
                    <td>
                    	<fieldset ><legend>Fechas del Informe</legend>
                        	<table>
                            	<tr>
                                    <td>Fecha Inicial:<br />
                                        <input name="fechainicial" type="text"  value="<?=date('01/m/Y')?>"  id="fechainicial" size="10" maxlength="10" readonly="readonly"/>
                                    </td>
                                    <td>Fecha Final:<br />
                                        <input name="fechafinal" type="text" value="<?=date('d/m/Y')?>" id="fechafinal" size="10" maxlength="10" readonly="readonly" />
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div id="filtros">
                            <?=$filtros?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset>
                            <legend>Otros Filtros</legend>
                            <table>
                            	<tr>
                                	<td colspan="5">Incluir personas leccionadas?</td>
                                </tr>
                                <tr>
                                	<td><input name="lecciones" type="radio" checked="checked" value="all">Todo</td>
                                    <td><input name="lecciones" type="radio" value="1">Ninguna</td>
                                    <td><input name="lecciones" type="radio" value="2">Muertas</td>
                                    <td><input name="lecciones" type="radio" value="3">Heridas</td>
                                    <td><input name="lecciones" type="radio" value="4">Ambas</td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset>
                            <legend>Tipo de Reporte</legend>
                            <table>
                                <tr>
                                    <td> 
                                        <input type='radio' name='tiporeporte' value='html' id='html' title='' checked="checked" /><label for='html'>Html</label>
                                        <input type='radio' name='tiporeporte' value='excel' id='excel' title='' /><label for='excel'>Excel</label>
                                        <!-- <input type='radio' name='tiporeporte' value='pdf' id='pdf' title='' /><label for='pdf' style="display: none;">PDF</label> -->
                                    </td>
                                    <td>
                                        <input type="submit" id="enviar" name="enviar" value="Generar Informe" />
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</div>
<div class="clear"></div>