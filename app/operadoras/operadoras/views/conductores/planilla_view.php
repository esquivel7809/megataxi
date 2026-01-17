<script type="text/javascript" src="<?=base_url()?>js/jquery.ajaxupload.js" ></script>
<script>
	$(document).ready(function(){
		$('#form_planilla').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
		$('#fechainicio, #fecharegreso').mask("99/99/9999");
		
		$('#fechainicio').live('blur', function(){
			if($(this).val()!="" && $(this).val()!="__/__/____"){
				if(!isDate($(this).val())){
					alert('Fecha Invalida');
					$(this).focus().select();
					return false;
				}
			}
		});
		$('#fecharegreso').live('blur', function(){
			if($(this).val()!="" && $(this).val()!="__/__/____"){
				if(!isDate($(this).val())){
					alert('Fecha Invalida');
					$(this).focus().select();
					return false;
				}
			}
			if($('#fechainicio').val()!="" && $('#fecharegreso').val()!=""){
				if(!compararFechas($('#fechainicio').val(), $('#fecharegreso').val())){
					alert("la fecha de regreso no puede ser menor a la fecha de inicio");
					$('#fecharegreso').focus().select();
				}
			}
		});
		
		var dates = $( "#fechainicio, #fecharegreso" ).datepicker({
			changeYear: true,
			changeMonth: true,
            hideIfNoPrevNext : true,
			showOn: 'button',
            //maxDate: '+0d',
			buttonImage: '<?=base_url()?>img/cal.png',
			buttonImageOnly: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fechainicio" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" );
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
    	/*Autocompletar para los lugares de origen y lugar de destino*/
    	function formatciudad(datos) {
    		return datos.nombremunicipio+ " - " +datos.nombredepartamento;
    	};
    
    	$("#lugarorigen_,#lugardestino_").autocomplete("<?=site_url('conductores/data/consultarmunicipio')?>", {
    		dataType: "json",
    		parse: function(data) {
    			return $.map(data, function(row) {
    				return {
    					data: row,
    					value: row.nombremunicipio+ " - "+row.nombredepartamento,
    					result: row.nombremunicipio+ " - "+row.nombredepartamento
    				}
    			});
    		},
    		width: 500,
    		delay:200,
    		selectFirst: true,
    		scroll: true,
    		formatItem: function(item) {
    			return formatciudad(item);
    		}
    	});
    	$("#lugarorigen_").result(function(event, data, formatted) {
    		if (data)
    		{
    			$("#idorigen").val(data.idmunicipio);
				$("#fechainicio").focus();
    		}
    	});
        
    	$("#lugardestino_").result(function(event, data, formatted) {
    		if (data)
    		{
    			$("#iddestino").val(data.idmunicipio);
				$("#fecharegreso").focus();
    		}
    	});
        
        $('#numerodocumento,#telefonofijo,#cantidadpasajeros').numeric();
        $('#nombrecompleto').alphanumeric({allow:" "});
        $('#direccion').alphanumeric({allow:" "});
        
        $("#lugarexpedicion").blur(function(){
            if($("#idlugarexpedicion").val()==''){
                $(this).attr('value','');
                }
        });
        
        $("#lugarnacimiento").blur(function(){
            if($("#idlugarnacimiento").val()==''){
                $(this).attr('value','');
                }
        });
        $("#numerodocumento").blur(function(){
            if($("#numerodocumento").val()!=''){
				$.getJSON( '<?=site_url('conductores/data/consultarcontratante')?>',{numerodocumento:$(this).val()},function(respuesta){
					if(respuesta.existe){
						$("#idcontratante").val(respuesta.idcontratante);
						$("#idtipodocumento").val(respuesta.idtipodocumento);
						$("#numerodocumento").val(respuesta.numerodocumento);
						$("#nombrecompleto").val(respuesta.nombrecompleto);
						$("#direccion").val(respuesta.direccion);
						$("#telefonofijo").val(respuesta.telefonofijo);
						$("#cantidadpasajeros").focus();
					}
				});
            }
        });
		
		/*Autocompletar para los vehiculos*/
		function formatvehiculo(tarjeta) {
			return tarjeta.placa+ " - " + tarjeta.numerotarjeta+ " - " + tarjeta.numerodocumento+ " - " + tarjeta.nombrecompleto;
		};
	
		$("#vehiculoconductor").autocomplete("<?=site_url('conductores/data/consultarconductorrefrendacion/')?>", { 
			dataType: "json",
			parse: function(data) {
				return $.map(data, function(row) {
					return {
						data: row,
						value: row.placa+" - "+row.nombrecompleto,
						result: row.placa+" - "+row.nombrecompleto
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
		$("#vehiculoconductor").result(function(event, data, formatted) {
			$('#idvehiculoconductor').val(data.idvehiculoconductor);
			
			//$('#tarjeton').val(data.numerotarjeta+" "+data.nombrecompleto);
			//$('#placa').val(data.placa);
		});
		
	});
</script>
<div>
    <?php echo $mensaje_confirmacion; ?>
    <div class="titulo-modulo">Registro de planillas de viaje</div>
    <div class="contenido-modulo border border-radius border-shadow">
        <form method="post" name="form_planilla" id="form_planilla" action="<?=site_url('conductores/planilla/registro')?>">
            <input type="hidden" name="idplanilla" id="idplanilla" value="<?php if(!empty($datoidplanilla)) echo $datoidplanilla?>" />
            <div class="form"> 
                <div>
                    <label>N&uacute;mero de Planilla: </label>
                    <input type="text" name="numeroplanilla" id="numeroplanilla" maxlength="10" title="Numero de Planilla" placeholder="Numero de Planilla" required="" value="<?php if(!empty($datonumeroplanilla)) echo $datonumeroplanilla; ?>" />
                </div>
                <div>
                    <label>Ciudad de Origen: </label>
                    <input type="hidden" name="idorigen" id="idorigen" required="required" value="<?php if(!empty($datoidorigen)){ echo $datoidorigen; } else{ echo "422"; }?>" /> 
                    <input type="text" name="lugarorigen" id="lugarorigen" required="required" title="Lugar de Expedicion" placeholder="Ciudad de Origen" disabled="disabled" value="<?php if(!empty($datolugarorigen)){ echo $datolugarorigen; } else{ echo "IBAGUE - Tolima"; } ?>" />
                </div>
                <div>
                    <label>Fecha de Inicio: </label>
                    <input type="text" name="fechainicio" id="fechainicio" maxlength="10" title="Fecha de Inicio" placeholder="Fecha de Inicio" required="" value="<?php if(!empty($datofechainicio)) echo $datofechainicio; ?>" />
                </div>
                <div>
                    <label>Ciudad de Destino: </label>
                    <?php /*
                    <input type="hidden" name="iddestino" id="iddestino" required="required" value="<?php if(!empty($datoiddestino)) echo $datoiddestino?>" /> 
                    <input type="text" name="lugardestino" id="lugardestino" required="required" title="Lugar de Expedicion" placeholder="Ciudad de Origen" value="<?php if(!empty($datolugardestino)) echo $datolugardestino; ?>" />
					 * se hace el cambio por solicitud de la gerente para poder digitar varias ciudades
					 */
					 ?>
                    <input type="text" name="lugardestino" id="lugardestino" required="required" title="Lugar de Expedicion" placeholder="Ciudad de Destino" value="<?php if(!empty($datolugardestino)) echo $datolugardestino; ?>" />
                </div>
                <div>
                    <label>Fecha de Regreso: </label>
                    <input type="text" name="fecharegreso" id="fecharegreso" maxlength="10" title="Fecha de Regreso" placeholder="Fecha de Regreso" required="" value="<?php if(!empty($datofecharegreso)) echo $datofecharegreso; ?>" />
                </div>
                <div>
                    <label>Cantidad de pasajeros: </label>
                    <input type="text" name="cantidadpasajeros" id="cantidadpasajeros" required="required" title="Cantidad de Pasajeros" placeholder="Digite Cantidad de Pasajeros" size="2" maxlength="2" value="<?php if(!empty($datocantidadpasajeros)) echo $datocantidadpasajeros; ?>" />
                </div>
                <h2 class="subtitulo-modulo"> Datos del Contratante </h2>
                <div>
                    <label>Tipo de Documento:</label>
                    <div class="wrapper-select-form">
                    	<input type="hidden" name="idcontratante" id="idcontratante" value="<?php if(!empty($datoidcontratante)) echo $datoidcontratante; ?>" />
                        <select name="idtipodocumento" id="idtipodocumento" required="" title="Tipo de Documento" <?php if(!empty($disabled)) echo $disabled?>>
                        <?=$tipodocumento?>
                        </select>
                    </div>
                </div>
                <div>
                    <label>N&uacute;mero de Documento: </label>
                    <input type="text" name="numerodocumento" id="numerodocumento" required="required" title="Numero Documento" placeholder="Digite Nº Documento" value="<?php if(!empty($datonumerodocumento)) echo $datonumerodocumento?>" <?php if(!empty($disabled)) echo $disabled?>/>
                </div>
                <div>
                    <label>Nombre Completo: </label>
                    <input type="text" name="nombrecompleto" id="nombrecompleto" required="required" title="Nombre Completo" placeholder="Digite Nombre Completo" value="<?php if(!empty($datonombrecompleto)) echo $datonombrecompleto?>" />
                </div>
                <div>
                    <label>Direcci&oacute;n: </label>
                    <input type="text" name="direccion" id="direccion" required="required" title="Direccion" placeholder="Digite la Direccion" value="<?php if(!empty($datodireccion)) echo $datodireccion?>" />
                </div>
                <div>
                    <label>Telefono Fijo: </label>
                    <input type="text" name="telefonofijo" id="telefonofijo" title="Telefono fijo" placeholder="Digite Telefono fijo" value="<?php if(!empty($datotelefonofijo)) echo $datotelefonofijo?>" />
                </div>
                <h2 class="subtitulo-modulo"> Datos del Conductor y el Vehiculo </h2>
                <div>
                    <label>Conductor:</label>
                    <input type="hidden" name="idvehiculoconductor" id="idvehiculoconductor" value="<?php if(!empty($datoidvehiculoconductor)) echo $datoidvehiculoconductor; ?>" />
                    <input type="text" name="vehiculoconductor" id="vehiculoconductor" required="required" title="Conductor" placeholder="Digite cedula o placa" value="<?php if(!empty($datovehiculoconductor)) echo $datovehiculoconductor; ?>"/>
                </div>
                <div class="botoneria">
                    <?php echo $botoneria; ?>
                </div>
            </div>
        </form>
    </div>
</div>