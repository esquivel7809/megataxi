<script>
	$(document).ready(function(){
		$('#form_carnetcomunicacion').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#placa').mask('aaa999');
        
	/*Autocompletar para los vehiculos*/
	function formatvehiculo(vehiculo) {
		return vehiculo.placa+ " " + vehiculo.serieradiotelefono;
	};
	$("#placa").autocomplete("<?=site_url('comunicaciones/data/consultavehiculoradiotelefono/')?>", { 
        //extraParams:{ idconductor: 2 },
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idvehiculoradiotelefono,
					result: row.idvehiculoradiotelefono
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
	$("#placa").result(function(event, data, formatted) {
		if (data)
		{
            $("#idvehiculoradiotelefono").val(data.idvehiculoradiotelefono);		  
            $("#placa").val(data.placa);
			
            $("#serieradiotelefono").val(data.serieradiotelefono);
            $("#nombremarcaradio").val(data.nombremarcaradio);
			$("#nombremodeloradio").val(data.nombremodeloradio);
			$("#nombremarcavehiculo").val(data.nombremarcavehiculo);
			$("#nombremodelo").val(data.nombremodelo);
			$("#numeromega").val(data.numeromega);
			$("#idvehiculo").val(data.idvehiculo);
			$("#idvehiculomega").val(data.idvehiculomega);
			
			abrirAjax("#contenido", "<?=site_url('comunicaciones/carnetcomun')?>","idvehiculoradiotelefono="+data.idvehiculoradiotelefono);
		}
	});
	$('#fechacarnet').mask("99/99/9999");
   	// se inicializa el calendario para la fecha de matricula
	$('#fechacarnet').datepicker({
		changeMonth: true,
		changeYear: true,
		hideIfNoPrevNext : true,
		showOn: 'button',
		maxDate: '+0d',
		buttonText: 'Fecha de Carnet',
		buttonImage: '<?=base_url()?>img/cal.png',
		buttonImageOnly: true
		});
     
});
</script>
<div>
    <?php echo $mensaje_confirmacion; ?>
    <div class="titulo-modulo">Registro de Carnet de Comunicaci&oacute;n</div>
    <div class="contenido-modulo border border-radius border-shadow">
        <form method="post" name="form_carnetcomunicacion" id="form_carnetcomunicacion" action="<?=site_url('comunicaciones/carnetcomun/registro')?>">
        	<input type="hidden" name="idcarnetcomunicacion" id="idcarnetcomunicacion" value="<?php if(!empty($datoidcarnetcomunicacion)) echo $datoidcarnetcomunicacion?>" />
            <div class="form">
                <div>
                    <label>Placa:</label>
                    <input type="hidden" name="idvehiculoradiotelefono" id="idvehiculoradiotelefono" value="<?php if(!empty($datoidvehiculoradiotelefono)) echo $datoidvehiculoradiotelefono?>" />
                    <input type="hidden" name="idvehiculo" id="idvehiculo" value="<?php if(!empty($datoidvehiculo)) echo $datoidvehiculo?>" />
                    <input type="hidden" name="idvehiculomega" id="idvehiculomega" value="<?php if(!empty($datoidvehiculomega)) echo $datoidvehiculomega?>" />
                    <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="<?php if(!empty($datoplaca)) echo $datoplaca?>" <?php if(!empty($disabled)) echo $disabled?> />
                </div>
                <div>
                    <label>N&uacute;mero Carnet: </label>
                    <input type="text" name="numerocarnet" id="numerocarnet" title="Numero de Carnet" placeholder="Numero de Carnet" value="<?php if(!empty($datonumerocarnet)) echo $datonumerocarnet; ?>" disabled='disabled' />
                </div>
                <div>
                    <label>Fecha:</label>
                    <input type="text" name="fechacarnet" id="fechacarnet" title="Digite la fecha" size="10" maxlength="10" value="<?php if(!empty($datofechacarnet)) echo $datofechacarnet; ?>" placeholder="Digite Fecha" required=""/>
                </div>
                <h2 class="subtitulo-modulo"> Datos del Vehiculo</h2>
                <div>
                    <label>N&uacute;mero Mega o EME: </label>
                    <input type="text" name="numeromega" id="numeromega" title="Numero Mega o EME" placeholder="Numero Mega o EME" value="<?php if(!empty($datonumeromega)) echo $datonumeromega; ?>" />
                </div>
                <div>
                    <label>Marca: </label>
                    <input type="text" name="nombremarcavehiculo" id="nombremarcavehiculo" title="Marca del vehiculo" placeholder="Marca del vehiculo" value="<?php if(!empty($datonombremarcavehiculo)) echo $datonombremarcavehiculo; ?>" />
                </div>
                <div>
                    <label>Modelo: </label>
                    <input type="text" name="nombremodelo" id="nombremodelo" title="Modelo del vehiculo" placeholder="Modelo del vehiculo" value="<?php if(!empty($datonombremodelo)) echo $datonombremodelo; ?>" />
                </div>
                <h2 class="subtitulo-modulo"> Datos del Radiotelefono</h2>
                <div>
                    <label>Marca: </label>
                    <input type="text" name="nombremarcaradio" id="nombremarcaradio" title="Marca del radio del vehiculo" placeholder="Marca del radio del vehiculo" value="<?php if(!empty($datonombremarcaradio)) echo $datonombremarcaradio; ?>" />
                </div>
                <div>
                    <label>Modelo: </label>
                    <input type="text" name="nombremodeloradio" id="nombremodeloradio" title="Modelo del radio del vehiculo" placeholder="Modelo del radio del vehiculo" value="<?php if(!empty($datonombremodeloradio)) echo $datonombremodeloradio; ?>" />
                </div>
                <div>
                    <label>Serie: </label>
                    <input type="text" name="serieradiotelefono" id="serieradiotelefono" title="Serie del radiotelefono" placeholder="Serie del radiotelefono" value="<?php if(!empty($datoserieradiotelefono)) echo $datoserieradiotelefono; ?>" />
                </div>
                <?php echo $propietarios; ?>
                <div class="botoneria">
                    <?php echo $botoneria; ?>
                </div>
            </div>
        </form>
    </div>
</div>