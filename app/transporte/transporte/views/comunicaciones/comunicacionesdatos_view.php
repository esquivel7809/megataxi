<script>
	$(document).ready(function(){
		$('#form_comunicacionesdatos').html5form({
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
		return vehiculo.placa+ " " + vehiculo.numerochasis;
	};
	$("#placa").autocomplete("<?=site_url('parqueautomotor/data/consultarvehiculocomunicacion/')?>", { 
        //extraParams:{ idconductor: 2 },
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.placa,
					result: row.placa
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
			abrirAjax("#contenido", "<?=site_url('comunicaciones/comunicacionesdatos')?>","idvehiculo="+data.idvehiculo);
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

	/*Autocompletar para los megas */
	function formatmega(mega) {
		return mega.numeromega;
	};

	$("#mega").autocomplete("<?=site_url('comunicaciones/data/consultarmega/')?>", { 
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idmega,
					result: row.idmega
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatmega(item);
		}
	});
	$("#mega").result(function(event, data, formatted) {
		if (data)
		{
            $("#idmega").val(data.idmega);
            //$("#idcanal").val(data.idcanal);
			$("#mega").val(data.numeromega);
		}
	});

	/*Autocompletar para los modelos de radiotelefonos*/
	function formatmodeloradio(modeloradio) {
		return modeloradio.nombremarcaradio+ " " + modeloradio.nombremodeloradio;
	};

	$("#nombremodeloradio").autocomplete("<?=site_url('comunicaciones/data/consultarmodeloradio/')?>", { 
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idmodeloradio,
					result: row.idmodeloradio
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatmodeloradio(item);
		}
	});
	$("#nombremodeloradio").result(function(event, data, formatted) {
		if (data)
		{
            $("#idmodeloradio").val(data.idmodeloradio);		  
            $("#nombremodeloradio").val(data.nombremarcaradio+" "+data.nombremodeloradio);
		}
	});


     
});
</script>
<?php //print_r($arrayVehiProp); ?>
<div>
    <?php echo $mensaje_confirmacion; ?>
    <div class="titulo-modulo">Registro de Datos de Comunicaciones</div>
    <div class="contenido-modulo border border-radius border-shadow">
        <form method="post" name="form_comunicacionesdatos" id="form_comunicacionesdatos" action="<?=site_url('comunicaciones/comunicacionesdatos/registro')?>">
            <div class="form">
                <div>
                    <label>Placa:</label>
                    <input type="hidden" name="idvehiculo" id="idvehiculo" value="<?php if(!empty($datoidvehiculo)) echo $datoidvehiculo?>" />
                    <input type="hidden" name="idvehiculoradiotelefono" id="idvehiculoradiotelefono" value="<?php if(!empty($datoidvehiculoradiotelefono)) echo $datoidvehiculoradiotelefono?>" />
                    <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="<?php if(!empty($datoplaca)) echo $datoplaca?>" />
                </div>
                <?php 
				if(!empty($datonumerocarnet)){
					
				?>
                <h2 class="subtitulo-modulo"> Datos del Vehiculo</h2>
                <div>
                    <label>Marca: </label>
                    <input type="text" name="nombremarcavehiculo" id="nombremarcavehiculo" title="Marca del vehiculo" placeholder="Marca del vehiculo" value="<?php if(!empty($datonombremarcavehiculo)) echo $datonombremarcavehiculo; ?>" disabled='disabled' />
                </div>
                <div>
                    <label>Modelo: </label>
                    <input type="text" name="nombremodelo" id="nombremodelo" title="Modelo del vehiculo" placeholder="Modelo del vehiculo" value="<?php if(!empty($datonombremodelo)) echo $datonombremodelo; ?>" disabled='disabled' />
                </div>
                <div>
                    <label>N&uacute;mero Carnet: </label>
                    <input type="text" name="numerocarnet" id="numerocarnet" title="Numero de Carnet" placeholder="Numero de Carnet" value="<?php if(!empty($datonumerocarnet)) echo $datonumerocarnet; ?>" disabled='disabled' />
                </div>
                <div>
                    <label>Fecha:</label>
                    <input type="text" name="fechacarnet" id="fechacarnet" title="Digite la fecha" size="10" maxlength="10" value="<?php if(!empty($datofechacarnet)) echo $datofechacarnet; ?>" placeholder="Digite Fecha" required=""/>
                </div>
                <div>
                    <label>N° Mega o EME: </label>
                    <input type="hidden" name="idmega" id="idmega" required="required" title="Numero de Mega o EME" placeholder="Digite Numero de Mega o EME" value="<?php if(!empty($datomodeloradiotelefono)) echo $datomodeloradiotelefono?>" />
                    <input type="text" name="mega" id="mega" required="required" title="Numero de Mega o EME" placeholder="Digite Numero de Mega o EME" value="<?php if(!empty($datomodeloradiotelefono)) echo $datomodeloradiotelefono?>" />
                    
                </div>
                <div>
                    <label>Modelo : </label>
                    <input type="hidden" name="idmodeloradio" id="idmodeloradio" value="<?php if(!empty($datoidmodeloradio)) echo $datoidmodeloradio?>" />
                    <input type="text" name="nombremodeloradio" id="nombremodeloradio" required="required" title="Digite Modelo Radio" placeholder="Digite Modelo Radio" value="<?php if(!empty($datonombremodeloradio)) echo $datonombremodeloradio?>" size="40" />
                </div>
                <div>
                    <label>Serie : </label>
                    <input type="text" name="serieradiotelefono" id="serieradiotelefono" required="required" title="Serie" placeholder="Serie" value="<?php if(!empty($datoserieradiotelefono)) echo $datoserieradiotelefono?>" />
                </div>

                <?php
					if(!empty($arrayVehiProp))
					{
						
						$html.="<h2 class='subtitulo-modulo'> Datos de los Propietarios</h2>";
						$html.="<div>";
						
						$entrar = true;				
						foreach ($arrayVehiProp as $row)
						{
							$checked=($entrar)? 'checked="checked"' : "" ;
							$html.="<div class='nomb_prop'>".html_entity_decode($row['nombrecompleto'])."</div>
									<div class='opcion_prop'><input type='radio' name='idvehiculopropietario' id='".$row['idvehiculopropietario']."' placeholder='Propietario' tittle='Propietario' value='".$row['idvehiculopropietario']."' ".$checked." /></div>";
							$entrar=false;
						}
		
						$html.="</div>";
						echo $html;
						?>
                        <div class="botoneria">
                            <?php echo $botoneria; ?>
                        </div>
                        <?php
					}
					else
					{
						echo "<h2 class='subtitulo-modulo'> No hay Datos de los Propietarios</h2>";
					}
				}
				?>
            </div>
        </form>
    </div>
</div> 