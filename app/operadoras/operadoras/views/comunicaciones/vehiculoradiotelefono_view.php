<script>
	$(document).ready(function(){
		$('#form_vehiculoradiotelefono').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#placa').mask('aaa999');
        $('#serieradio').alphanumeric();
        $('#frecuencia').numeric();
        
	/*Autocompletar para los vehiculos*/
	function formatvehiculo(vehiculo) {
		return vehiculo.placa+ " " + vehiculo.numerochasis;
	};

	$("#placa").autocomplete("<?=site_url('parqueautomotor/data/consultarvehiculocomunicacion/')?>", { 
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
            $("#idvehiculo").val(data.idvehiculo);		  
            $("#placa").val(data.placa);
		}
	});
        
	/*Autocompletar para los modelos de radiotelefonos*/
	function formatradiotelefono(idradiotelefono) {
		return idradiotelefono.serieradiotelefono+ " " + idradiotelefono.nombremarcaradio+ " " + idradiotelefono.nombremodeloradio;
	};

	$("#nombreradiotelefono").autocomplete("<?=site_url('comunicaciones/data/consultaradiotelefono/')?>", { 
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idradiotelefono,
					result: row.idradiotelefono
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatradiotelefono(item);
		}
	});
	$("#nombreradiotelefono").result(function(event, data, formatted) {
		if (data)
		{
            $("#idradiotelefono").val(data.idradiotelefono);		  
            $("#nombreradiotelefono").val(data.serieradiotelefono+" "+data.nombremarcaradio+" "+data.nombremodeloradio);
		}
	});
        
});
/*
function set_status_timeout(e){
	STATUS_TIMEOUT=setTimeout(function(){fade_out("mensaje-confirmacion")},e||8e3)
	}
function fade_out(e,t){
	return fade_in(e,t,!0)
	}
function fade_in(e,t,n){
	e=div_cache[e]||DOM.get(e)||e;
	var r=e.style,i,s=window.getComputedStyle?getComputedStyle(e,null):e.currentStyle,o=s.visibility,u;if(e.offsetWidth&&o!=="hidden"){if(window.getComputedStyle)u=Number(s.opacity);else{try{u=e.filters.item("DXImageTransform.Microsoft.Alpha").opacity}catch(a){try{u=e.filters("alpha").opacity}catch(a){u=100}}u/=100}u||(u=0)}else u=0,set_opacity(e,0);if(n&&u<.01){u&&set_opacity(e,0);return}t||(t=FADE_DURATION);var f=t*1e3,l=new Date,c;n?c=f+l.getTime():r.visibility="visible";var h=function(){var t;n?(t=u*(c-new Date)/f,t<=0&&(t=0,clearInterval(i),r.visibility="hidden")):(t=u+(1-u)*(new Date-l)/f,t>=1&&(t=1,clearInterval(i))),set_opacity(e,t)};return h(),i=setInterval(h,FADE_DELAY),i
	}
*/
</script>
<div>
    <?php echo $mensaje_confirmacion; ?>
    <div class="titulo-modulo">Asociar radiotelefonos</div>
    <div class="contenido-modulo border border-radius border-shadow">
        <form method="post" name="form_vehiculoradiotelefono" id="form_vehiculoradiotelefono" action="<?=site_url('comunicaciones/vehiculoradiotelefono/registro')?>">
            <input type="hidden" name="idvehiculoradiotelefono" id="idvehiculoradiotelefono" value="<?php if(!empty($datoidvehiculoradiotelefono)) echo $datoidvehiculoradiotelefono?>" />
            <div class="form">
                <div>
                    <label>Placa:</label>
                    <input type="hidden" name="idvehiculo" id="idvehiculo" value="<?php if(!empty($datoidvehiculo)) echo $datoidvehiculo?>" />
                    <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="<?php if(!empty($datoplaca)) echo $datoplaca?>" />
                </div>
                <div>
                    <label>Radiotelefono:</label>
                    <input type="hidden" name="idradiotelefono" id="idradiotelefono" value="<?php if(!empty($datoidradiotelefono)) echo $datoidradiotelefono?>" />
                    <input type="text" name="nombreradiotelefono" id="nombreradiotelefono" required="required" title="Modelo o serie" placeholder="Digite modelo o serie" value="<?php if(!empty($datonombreradiotelefono)) echo $datonombreradiotelefono?>"/>
                </div>
                <div class="checkbox-section" style="display:none;">
                    <label>Activo :</label>
                    <span class="unchecked">
                        <input type="checkbox" name="activo" <?php if(!empty($datoactivo)) echo $datoactivo?> />
                    </span>
                </div>
                <div class="botoneria">
                    <?php echo $botoneria; ?>
                </div>
            </div>
        </form>
    </div>
</div>
