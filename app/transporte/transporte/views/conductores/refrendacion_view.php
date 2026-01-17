<div class="clear"></div>
<?php
?>
<script type="text/javascript">
	$(document).ready(function($) {
    	jQuery("ul.firmas-tarjeta-control > li.no-refrendado_").live("click",function(e){
			e.preventDefault();
			if(confirm("Esta Seguro Que Desea Refrendar")){
				id = $(this).attr("id");
				$.ajax({
				  url: "<?php echo site_url('conductores/refrendacion/registro'); ?>",
				  type: "POST",
				  data: { id_puesto : id, Guardar : "Guardar" },
				  success: function(data) { console.log(data);
					  if(data){
						  $("#"+id).removeClass().addClass('refrendado');
						  alert("Registro almacenado con exito");
						  //$("#tarjeton").dialog("destroy").remove();
					  }else{
						  alert("No se pudo almacenar el Registro");
					  }
				  }
				});
				//$.facebox.close();
				//$('div[id=facebox]:hidden').remove();
			}
    	});
	});
</script>
<div class="titulo-modulo">Refrendación de tarjeta de control</div>
<div class="contenido-modulo">
    <fieldset>
        <legend>Datos del Conductor</legend>
        <div class="foto">
            <?php if(!empty($datorutafoto)){?>
            <img src='<?php echo base_url(); ?>img/conductores/<?php echo $datorutafoto."?".date("hms");?>' />
            <?php }else{?>
            <img src='<?php echo base_url(); ?>img/conductores/sin_imagen.jpg' />
            <?php }?>
        </div>
        <div class="nombre">
            <?php if(!empty($datonombrecompleto)) echo $datonombrecompleto?>&nbsp;
        </div>
        <div class="otros-datos">
            <label>
                Identificaci&oacute;n:
            </label>
            <p><?php if(!empty($tipodocumento)) echo $tipodocumento?> <?php if(!empty($datonumerodocumento)) echo $datonumerodocumento?>&nbsp;</p>
            <label>
                Direcci&oacute;n:
            </label>
            <p><?php if(!empty($datodireccion)) echo $datodireccion?> &nbsp;</p>
            <label>
                Telefono:
            </label>
            <p><?php if(!empty($datotelefonofijo)) echo $datotelefonofijo?> <?php if(!empty($datocelular)) echo $datocelular?>&nbsp;</p>
            <label>
                E-mail:
            </label>
            <p><?php if(!empty($datoemail)) echo $datoemail?> &nbsp;</p>
        </div>
    </fieldset>
    <fieldset>
        <legend>Vehiculos Asociados</legend>
        <div class="section-vehi-asoc">
            <ul>
                <li>Placa</li>
                <li>Marca</li>
                <li>Nº Interno</li>
                <li>Estado</li>
                <li>Ult. Refrendaci&oacute;n</li>
                <li class="accion">Acci&oacute;n</li>
                <?php
                $mes = date('n');
				$licencia=true;
				$mensaje_cond="";
				if(empty($datonumerolicenciaconductor))
				{
					$mensaje_cond.="El conductor no tiene registrada licencia";
					$licencia=false;
				}
				else
				{
					if(strtotime($datofechavencimientolic)  <= strtotime(date('Y-m-d')))
					{
						$mensaje_cond.="El conductor tiene vencida la licencia";
						$licencia=false;
					}
				}
                foreach ($datosVehConductor as $filaDatosVehConductor)
                {
                    //inicializamos la bandera para refrendar
                    $refrendar= true;
                    $mensaje_final = "";
                    $mensaje="";
                    $mensaje_activo="";
                    $mensaje_inactivo="";
                    $id = $filaDatosVehConductor['idvehiculoconductor']."_".$mes;
    
                    if($filaDatosVehConductor['activo']==1):
                        $activo = true; $mensaje_activo = "Activo";
                    else:
                        $activo = false; $mensaje_activo = "Inactivo" ; $mensaje_inactivo = "inactivo" ;
                    endif;
					
					
					
					//validamos el SOAT
					if(empty($filaDatosVehConductor['numerosoat']))
					{
						//no tiene SOAT registrado
						$mensaje.=" no tiene registrado SOAT";
						$refrendar= false;
					}
					else
					{
						if(strtotime($filaDatosVehConductor['soat_fechafinal']) <= strtotime(date('Y-m-d')))
						{
							//el SOAT esta vencido
							$mensaje.=", el SOAT esta vencido";
							$refrendar= false;
						}
					}
					//validamos el contractual
					if(empty($filaDatosVehConductor['numerocontractual'])) 
					{
						//no tiene contractual registrado
						$mensaje.=", no tiene registrado seguro contractual";
						$refrendar= false;
					}
					else
					{
						if($filaDatosVehConductor['cont_fechafinal'] <= date('Y-m-d'))
						{
							//el contractual esta vencido
							$mensaje.=", el seguro contractual esta vencido";
							$refrendar= false;
						}
					}
					//validamos el extracontractual
					if(empty($filaDatosVehConductor['numeroextracontractual']))  
					{
						//no tiene extracontractual registrado
						$mensaje.=", no tiene registrado seguro extracontractual";
						$refrendar= false;
					}
					else
					{
						if($filaDatosVehConductor['extra_fechafinal'] <= date('Y-m-d'))
						{
							//el extracontractual esta vencido
							$mensaje.=", el seguro extracontractual esta vencido";
							$refrendar= false;
						}
					}
					//validamos el revision
					if(empty($filaDatosVehConductor['numerorevision']))   
					{
						//no tiene revision registrado
						$mensaje.=", no tiene registrado revision tecnicomecanica";
						$refrendar= false;
					}
					else
					{
						if($filaDatosVehConductor['revi_fechafinal'] <= date('Y-m-d'))
						{
							//el revision esta vencido
							$mensaje.=", la revision tecnico-mecanica esta vencida";
							$refrendar= false;
						}
					}
                    ?>
                    <li>
                    <?php echo $filaDatosVehConductor['placa'];?>
                    </li>
                    <li>
                    <?php echo $filaDatosVehConductor['nombremarcavehiculo'];?>
                    </li>
                    <li>
                    <?php echo $filaDatosVehConductor['numerointerno'];?>
                    </li>
                    <li>
                    <?php echo $mensaje_activo;?>
                    </li>
                    <li>
                    <?php if(!empty($filaDatosVehConductor['fecharefrendacion'])) echo $filaDatosVehConductor['fecharefrendacion']; ?>
                    </li>
                    <li class="accion">
                    <form target="_blank" method="post" name="form_vehiculoconductor_<?php echo $id; ?>" id="form_vehiculoconductor_<?php echo $id; ?>" action="<?=site_url('imprimir/tarjetacontrol/index')?>">
                    <?php 
						if($filaDatosVehConductor['refrendado']):
							?>
                            
                                <input type="hidden" name="idrefrendacion" id="idrefrendacion" value="<?php if(!empty($filaDatosVehConductor['idrefrendacion'])) echo $filaDatosVehConductor['idrefrendacion']?>" />
                                <input type="submit" id="imprimir_<?php echo $filaDatosVehConductor['idrefrendacion']?>" name="imprimir_<?php echo $filaDatosVehConductor['idrefrendacion']?>" value="Imprimir" />
                            
                            <?php
						else:
							if($licencia && $activo && $refrendar):
							/*
								?>
								<!-- <a href="<?=site_url('conductores/refrendacion/verTarjeton/'.$filaDatosVehConductor['idvehiculoconductor'])?>" rel="facebox" class="facebox_">Refrendar</a> -->
								<!-- <input style="cursor:pointer;" type="button" id="refrendar" title="Refrendar" name="refrendar" value="Refrendar" onclick="abrirAjax('#tarjeton', '<?php echo site_url('conductores/refrendacion/verTarjeton/'.$filaDatosVehConductor['idvehiculoconductor']); ?>','idsubmoduloactual=20&mod=2')"> -->
								<input style="cursor:pointer;" type="button" id="refrendar" title="Refrendar" name="refrendar" value="Refrendar" onclick="buscaRegistro('<?php echo site_url('conductores/refrendacion/verTarjeton/'.$filaDatosVehConductor['idvehiculoconductor']); ?>','divbuscar=busqueda&amp;formulario=',630,630,'Refrendar tarjeton','#tarjeton')">
								<?php */ ?>
								<input style="cursor:pointer;" type="button" id="refrendar_<?php echo $id; ?>" title="Refrendar" name="refrendar" value="Refrendar" onclick="javascript:guardar_refrendacion('<?php echo $id; ?>', this, 'form_vehiculoconductor_<?php echo $id;?>')">
							
								<?php
							else:
								$mensaje_final= "No se puede refrendar debido a que: ".$mensaje_cond;
								$mensaje_final.= (empty($mensaje_inactivo)) ? "" : $mensaje_inactivo;
								$mensaje_final.= (empty($mensaje)) ? "" : ($mensaje);
								?>
								<a href="javascript:alert('<?php echo $mensaje_final; ?>')">No se puede refrendar</a>
								<?php
							endif;
						endif;
                    ?>
                    </form>
                    </li>
                    <style>
					 #datos_vehi{
						 border: 1px solid #000;
						 display: inline-block;
						 width:500px;
						 height:100%;
						 margin-bottom: 15px;
					 }
					 #datos_vehi > div{
						 padding:10px;
					 }
					 #datos_vehi > div > span{
						 font-weight:bold;
					 }
					</style>
                    
                    <li id="datos_vehi">
                    	<div>
                        	<span>LICENCIA DE CONDUCCI&Oacute;N</span>
                        	<div>N&uacute;mero: <?php echo $filaDatosVehConductor['numerolicenciaconductor']; ?> Fecha de vencimiento: <?php echo $filaDatosVehConductor['fechavencimiento']; ?> Categor&iacute;a: <?php echo $filaDatosVehConductor['nombrecategoria']; ?></div>
                        </div>
                    	<div>
                        	<span>SOAT</span>
                        	<div>N&uacute;mero: <?php echo $filaDatosVehConductor['numerosoat']; ?> Fecha de vencimiento: <?php echo $filaDatosVehConductor['soat_fechafinal']; ?></div>
                        </div>
                    	<div>
                        	<span>REVIS&Oacute;N TECNICO-MECANICA</span>
                        	<div>N&uacute;mero: <?php echo $filaDatosVehConductor['numerorevision']; ?> Fecha de vencimiento: <?php echo $filaDatosVehConductor['revi_fechafinal']; ?></div>
                        </div>
                    	<div>
                        	<span>SEGURO CONTRACTUAL</span>
                        	<div>N&uacute;mero: <?php echo $filaDatosVehConductor['numerocontractual']; ?> Fecha de vencimiento: <?php echo $filaDatosVehConductor['cont_fechafinal']; ?></div>
                        </div>
                    	<div>
                        	<span>SEGURO EXTRACONTRACTUAL</span>
                        	<div>N&uacute;mero: <?php echo $filaDatosVehConductor['numeroextracontractual']; ?> Fecha de vencimiento: <?php echo $filaDatosVehConductor['extra_fechafinal']; ?></div>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </fieldset>
    <div id="botoneria">
        <?=$botoneria ?>
    </div>
</div>
<div id="tarjeton" ></div>