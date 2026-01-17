<script>
	$(document).ready(function(){
		$('#form_vehiculos').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
	$('#fechamatricula').mask("99/99/9999");
	
	$('#fechamatricula').live('blur', function(){
		if($(this).val()!="" && $(this).val()!="__/__/____"){
			if(!isDate($(this).val())){
				alert('Fecha Invalida');
				$(this).focus().select();
			}
		}
		if($(this).val()!=""){
			var fechaactual = GetTodayDate("dd/mm/aaaa");
			if(!compararFechas($(this).val(), fechaactual )){
				alert("la fecha de la matricula no puede ser mayor a la fecha de actual");
				$('#fechamatricula').focus().select();
			}
		}
	});

	// se inicializa el calendario para la fecha de matricula
	$('#fechamatricula').datepicker({
		changeMonth: true,
		changeYear: true,
		hideIfNoPrevNext : true,
		showOn: 'button',
		maxDate: '+0d',
		buttonText: 'Fecha de Matricula',
		buttonImage: '<?=base_url()?>img/cal.png',
		buttonImageOnly: true
		});
	$('#placa').mask('aaa999');
	$('#cilindraje,#numerointerno,#numeromega').numeric();
	$('#numerochasis,#numeromotor,#numerolicencia').alphanumeric();
	
});
	
</script>
<?php
?>
<div>
	<?php echo $mensaje_confirmacion; ?>
    <div class="titulo-modulo">Registro de vehiculos</div>
    <div class="contenido-modulo border border-radius border-shadow">
        <form method="post" name="form_vehiculos" id="form_vehiculos" action="<?=site_url('parqueautomotor/vehiculos/registro')?>">
            <input type="hidden" name="idvehiculo" id="idvehiculo" value="<?php if(!empty($datoidvehiculo)) echo $datoidvehiculo?>" />
            <div class="form">
                <div>
                    <label>Placa:</label>
                    <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="<?php if(!empty($datoplaca)) echo $datoplaca?>" <?php if(!empty($disabled)) echo $disabled?>/>
                </div>
                <div>
                    <label>Marca:</label>
                    <div class="wrapper-select-form">
                        <select name="idmarcavehiculo" id="idmarcavehiculo" required="" title="Marca" >
                        <?=$marcas?>
                        </select>
                    </div>
                </div>
                <div>
                    <label>Modelo:</label>
                    <div class="wrapper-select-form">
                        <select name="idmodelo" id="idmodelo" required="" title="Modelo" >
                        <?=$modelos?>
                        </select>
                    </div>
                </div>
                <div>
                    <label>Cilindraje:</label>
                    <input type="text" name="cilindraje" id="cilindraje" required="" title="Digite el cilindraje" value="<?php if(!empty($datocilindraje)) echo $datocilindraje?>" placeholder="Digite Cilindraje" size="15"/>
                </div>
                <div>
                    <label>Chasis Nº:</label>
                    <input type="text" name="numerochasis" id="numerochasis" required="" title="Digite el numero de chasis" value="<?php if(!empty($datonumerochasis)) echo $datonumerochasis?>" placeholder="Digite Nº de chasis" size="21"/>
                </div>
                <div>
                    <label>Motor Nº:</label>
                    <input type="text" name="numeromotor" id="numeromotor" required="" title="Digite el numero de motor" value="<?php if(!empty($datonumeromotor)) echo $datonumeromotor?>" placeholder="Digite Nº de Motor" size="21"/>
                </div>
                <div>
                    <label>Licencia Nº:</label>
                    <input type="text" name="numerolicencia" id="numerolicencia" required="" title="Digite el numero de licencia" value="<?php if(!empty($datonumerolicencia)) echo $datonumerolicencia?>" placeholder="Digite Nº de licencia" size="15"/>
                </div>
                <div>
                    <label>Fecha de matricula:</label>
                    <input type="text" name="fechamatricula" id="fechamatricula" title="Digite la fecha de matricula" size="10" maxlength="10" value="<?php if(!empty($datofechamatricula)) echo $datofechamatricula?>" placeholder="Digite Fecha Matricula" required=""/>
                </div>
                <div>
                    <label>Revisado:</label>
                    <div class="wrapper-select-form">
                        <select name="idrevisado" id="idrevisado" class="required" >
                        <?=$meses?>
                        </select>
                    </div>
                </div>
                <div>
                    <label>Numero interno:</label>
                    <input type="text" name="numerointerno" id="numerointerno" required="required" title="Digite el numero interno" value="<?php if(!empty($datonumerointerno)) echo $datonumerointerno?>" placeholder="Digite Nº Interno"/>
                </div>
                <div>
                    <label>Clase de Vehiculo:</label>
                    <div class="wrapper-select-form">
                        <select name="idtipovehiculo" id="idtipovehiculo" class="required" >
                        <?=$tipovehiculo?>
                        </select>
                    </div>
                </div>
                <div>
                    <label>Autorizaci&oacute;n para Conduce:</label>
                    <input type="checkbox" name="conduce" style="cursor:pointer;" <?php if(!empty($datoconduce)) echo $datoconduce?>/>
                </div>
                <div>
                    <label>Asociado:</label>
                    <input type="checkbox" name="asociado" style="cursor:pointer;" <?php if(!empty($datoasociado)) echo $datoasociado?>/>
                </div>
                <div>
                    <label>Afil. Rodamiento:</label>
                    <input type="checkbox" name="empresa" style="cursor:pointer;" <?php if(!empty($datoempresa)) echo $datoempresa?> />
                </div>
                <div>
                    <label>Afil. Comunicaci&oacute;n:</label>
                    <input type="checkbox" name="comunicacion" style="cursor:pointer;" <?php if(!empty($datocomunicacion)) echo $datocomunicacion?> />
                </div>
                <div>
                    <label>Activo:</label>
                    <input type="checkbox" name="activo" style="cursor:pointer;" <?php if(!empty($datoactivo)){ echo $datoactivo; }else{ echo "checked='checked'";}?> />
                </div>
                <div class="botoneria">
                    <?=$botoneria ?>
                </div>
            </div>
        </form>
    </div>
</div>