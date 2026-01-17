<script>
function guardar_datos(form, guardar)
{
	var required = new Array();
	var emptyInput=null;
	var idvehiculo = $('#idvehiculo').val();
	var placa = $('#placa').val();
	$.each($(':input:visible:not(:button, :submit)', form), function(i) {
		if(this.getAttribute('required')!=null){
			required[i]=$(this);
		}
	});
	$(required).each(function(key, value) { 
		if(value==undefined){
			return true;
		}
		if(($(this).val()==$(this).attr('placeholder')) || ($(this).val()=='') || ($(this).val()==0)){
			emptyInput=$(this);
			alert('El campo '+$(this).attr('title')+' es requerido.');
			return false;
		}
	return emptyInput;
	});
	if(!emptyInput){ 
		var formData=$(form).serialize();
		formData+= '&Guardar=' + $(guardar).attr('id');
		formData+= '&idvehiculo=' + idvehiculo;
		formData+= '&placa=' + placa;
		$.ajax({
			url : $(form).attr('action'),
			type : $(form).attr('method'),
			data : formData,
			success : function(data){
					$('#contenido').html(data);   
			}
		});   
	}else{
		if(emptyInput){
			$(emptyInput).focus().select();              
		}
		return false;
	}
	
}
	$(document).ready(function(){
		$("#Guardar_soat").click(function(event){
			var form = $('#form_vehiculosdatos_soat');
			var guardar = $(this);
			guardar_datos(form, guardar);
			event.preventDefault();
			});		
		$("#Guardar_revision").click(function(event){
			var form = $('#form_vehiculosdatos_revision');
			var guardar = $(this);
			guardar_datos(form, guardar);
			event.preventDefault();
			});		
		$("#Guardar_tarjeta").click(function(event){
			var form = $('#form_vehiculosdatos_tarjeta');
			var guardar = $(this);
			guardar_datos(form, guardar);
			event.preventDefault();
			});		
		$("#Guardar_contra").click(function(event){
			var form = $('#form_vehiculosdatos_contra');
			var guardar = $(this);
			guardar_datos(form, guardar);
			event.preventDefault();
			});		
		$("#Guardar_extra").click(function(event){
			var form = $('#form_vehiculosdatos_extra');
			var guardar = $(this);
			guardar_datos(form, guardar);
			event.preventDefault();
			});		
        $('#placa').mask('aaa999');
		
		/*Autocompletar para los vehiculos*/
		function formatvehiculo(vehiculo) {
			return vehiculo.placa+ " " + vehiculo.numerochasis;
		};
	
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
				$("#idvehiculo").val(data.idvehiculo);		  
				$("#placa").val(data.placa);
				$("#edicion_datos").css("display","inline");
				abrirAjax("#grilla_datos", "<?=site_url('parqueautomotor/data/consultarvehiculoseguros')?>","idvehiculo="+data.idvehiculo);
			}
		});
	$('#example2').accordion();
	$("#placa").blur(function(){
		if($(this).val()==""){
			$("#edicion_datos").css("display","none");
			$("#grilla_datos").css("display","none");
		}
		if($("#idvehiculo").val()==""){
			$("#edicion_datos").css("display","none");
			$("#grilla_datos").css("display","none");
			$(this).val()="";
		}
		});
	});
</script>
<div>
	<?php echo $mensaje_confirmacion; ?>
    <div class="titulo-modulo">Registro seguros de los vehiculos</div>
    <div class="contenido-modulo border border-radius border-shadow">
        <div class="form">
            <div>
                <label>Placa:</label>
                <input type="hidden" name="idvehiculo" id="idvehiculo" value="<?php if(!empty($datoidvehiculo)) echo $datoidvehiculo?>" />
                <input type="text" name="placa" id="placa" class="placa" required="required" title="Placa" placeholder="Placa" value="<?php if(!empty($datoplaca)) echo $datoplaca?>" />
            </div>
        </div>
        <div id="grilla_datos" class="form"><?php if(!empty($datogrilla)) echo $datogrilla?></div>
        <div class="form" id="edicion_datos" <?php if(empty($datoidvehiculo)) echo 'style="display:none;"'; ?> >
            <ul id="example2" class="accordion">
                <li class="active">
                    <h3 id="result_soat">Registro de Soat</h3>
                    <div class="panel open">
                        <form class="submit_form" method="post" name="form_vehiculosdatos_soat" id="form_vehiculosdatos_soat" action="<?=site_url('parqueautomotor/vehiculosdatos/registro')?>">
                            <div class="form">
                                <?php echo $this->load->view('parqueautomotor/soatform_view'); ?>
                                <div class="botoneria">
                                    <input style="cursor:pointer;" type="submit" id="Guardar_soat" title="Guardar" name="Guardar_soat" value="Guardar SOAT" >
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <h3>Registro de Revisi&oacute;n Tecnico-Mecanica</h3>
                    <div class="panel" style="display: none; overflow: hidden; height: 0px; margin-top: 0px; margin-bottom: 0px; padding-top: 0px; padding-bottom: 0px; opacity: 0;">
                        <form class="submit_form" method="post" name="form_vehiculosdatos_revision" id="form_vehiculosdatos_revision" action="<?=site_url('parqueautomotor/vehiculosdatos/registro')?>">
                            <div class="form">
                                <?php  $this->load->view('parqueautomotor/revisionform_view'); ?>
                                <div class="botoneria">
                                    <input style="cursor:pointer;" type="submit" id="Guardar_revision" title="Guardar" name="Guardar_revision" value="Guardar Revision" >
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <h3>Registro de Tarjetas de Operaci&oacute;n</h3>
                    <div class="panel" style="display: none; overflow: hidden; height: 0px; margin-top: 0px; margin-bottom: 0px; padding-top: 0px; padding-bottom: 0px; opacity: 0;">
                        <form method="post" name="form_vehiculosdatos_tarjeta" id="form_vehiculosdatos_tarjeta" action="<?=site_url('parqueautomotor/vehiculosdatos/registro')?>">
                            <div class="form">
                                <?php echo $this->load->view('parqueautomotor/tarjetaoperacionform_view'); ?>
                                <div class="botoneria">
                                    <input style="cursor:pointer;" type="submit" id="Guardar_tarjeta" title="Guardar" name="Guardar_tarjeta" value="Guardar Tarjeta" >
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <h3>Registro de Seg. Contractual y Extracontractual</h3>
                    <div class="panel" style="display: none; overflow: hidden; height: 0px; margin-top: 0px; margin-bottom: 0px; padding-top: 0px; padding-bottom: 0px; opacity: 0;">
                        <form method="post" name="form_vehiculosdatos_contra" id="form_vehiculosdatos_contra" action="<?=site_url('parqueautomotor/vehiculosdatos/registro')?>">
                            <div class="form">
                                <?php echo $this->load->view('parqueautomotor/contractualform_view'); ?>
                                <div class="botoneria">
                                    <input style="cursor:pointer;" type="submit" id="Guardar_contra" title="Guardar" name="Guardar_contra" value="Guardar Contractual" >
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <h3>Registro de Rev. Preventiva</h3>
                    <div class="panel" style="display: none; overflow: hidden; height: 0px; margin-top: 0px; margin-bottom: 0px; padding-top: 0px; padding-bottom: 0px; opacity: 0;">
                        <form method="post" name="form_vehiculosdatos_extra" id="form_vehiculosdatos_extra" action="<?=site_url('parqueautomotor/vehiculosdatos/registro')?>">
                            <div class="form">
                                <?php  $this->load->view('parqueautomotor/revisionform_view'); ?>
                                <div class="botoneria">
                                    <input style="cursor:pointer;" type="submit" id="Guardar_extra" title="Guardar" name="Guardar_extra" value="Guardar Extra - Contractual" >
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
