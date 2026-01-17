<script>
	$(document).ready(function(){
		$('#form_vehiculoconductor').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#placa').mask('aaa999');
        $('#numerotarjeta').numeric();
        
        
	/*Autocompletar para los conductores*/
	function formatconductor(conductor) {
		return conductor.numerodocumento + " - " + conductor.nombrecompleto;
	};
	$("#conductor").autocomplete("<?=site_url('conductores/data/consultarconductorlic')?>", {
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
            var fechaActual="<?=date('Y-m-d')?>";
            if(data.fechavencimiento<= fechaActual)
            {
    			$("#idconductor").attr('value','');
                $("#conductor").attr('value','');
        		alert(data.nombrecompleto+' Tiene la Licencia de Conducción Vencida');
            }
            else
            {
    			$("#idconductor").val(data.idconductor);
                $("#conductor").val(data.nombrecompleto);
                $("#placa").focus();
                //$("#placa").flushCache();
                //$("#placa").setOptions(options.extraParams, { idconductor: data.idconductor });
                abrirAjax("#grillavehiculos", "<?=site_url('parqueautomotor/data/consultarvehiculoconductorasociado')?>","idconductor="+data.idconductor);
            }
		}
	});
        
	/*Autocompletar para los vehiculos*/
	function formatvehiculo(vehiculo) {
		return vehiculo.placa+ " " + vehiculo.numerochasis;
	};
	//$("#placa").autocomplete("<?=site_url('parqueautomotor/data/consultarvehiculonoasociado/')?>", { 
	$("#placa").autocomplete("<?=site_url('parqueautomotor/data/consultarvehiculo/')?>", { 
        //extraParams:{ idconductor: 2 },
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idvehiculo,
					result: row.idvehiculo
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
            var fechaActual="<?=date('Y-m-d')?>";
            var entro=0;
            var msg="";
			/*
            if(data.vencimientosoat<= fechaActual)
            {
                msg+="SOAT, ";
                entro=1;
            }
            if(data.vencimientocontractual<= fechaActual)
            {
                msg+="Seguro Contractual, ";
                entro=1;
            }
            if(data.vencimientoextracontractual<= fechaActual)
            {
                msg+="Seguro Extracontractual, ";
                entro=1;
            }*/
            if(entro==1)
            {
    			$("#idvehiculo").attr('value','');
                $("#placa").attr('value','');
        		alert('El Vehiculo '+data.placa+' Tiene el '+msg+' Vencido');
            }
            else
            {
                $("#idvehiculo").val(data.idvehiculo);		  
                $("#placa").val(data.placa);
            }
		}
	});
        
        
});
	
</script>
<?php echo $mensaje_confirmacion; ?>
<div class="titulo-modulo">Asociar vehiculo</div>
<div class="contenido-modulo border border-radius border-shadow">
    <form method="post" name="form_vehiculoconductor" id="form_vehiculoconductor" action="<?=site_url('conductores/vehiculoconductor/registro')?>">
        <input type="hidden" name="idvehiculoconductor" id="idvehiculoconductor" value="<?php if(!empty($datoidvehiculoconductor)) echo $datoidvehiculoconductor?>" />
        <div class="form">
            <div>
                <label>Conductor:</label>
                <input type="hidden" name="idconductor" id="idconductor" value="<?php if(!empty($datoidconductor)) echo $datoidconductor?>" />
                <input type="text" name="conductor" id="conductor" required="required" title="Conductor" placeholder="Conductor" value="<?php if(!empty($datonombreconductor)) echo $datonombreconductor?>"/>
            </div>
            <div>
                <label>Placa:</label>
                <input type="hidden" name="idvehiculo" id="idvehiculo" value="<?php if(!empty($datoidvehiculo)) echo $datoidvehiculo?>" />
                <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="<?php if(!empty($datoplaca)) echo $datoplaca?>" />
            </div>
            <div>
                <label>Numero de Tarjeta:</label>
                <input type="text" name="numerotarjeta" id="numerotarjeta" required="required" title="Numero de Tarjeta" placeholder="Numero de Tarjeta" value="<?php if(!empty($datonumerotarjeta)) echo $datonumerotarjeta?>"/>
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