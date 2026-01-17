<form onsubmit="return false;" name="FrmDatos">
<!-- <input type="hidden" name="ArchivoOrigen" value="<?php echo MODULOS_PATH."auditoriac/auditoriaf.php";?>" />  -->
<table border="1" class="tablacontenido" align="center" cellpadding="0" cellspacing="0" style="width:950px">
    <tr class="titulo">
        <th colspan="5">AUDITORIA CUENTAS M&Eacute;DICAS</th>
    </tr>

<?php
	$DeshabilitaContrato='';
	if($ExisteInfo=='1')
	{
		$DeshabilitaContrato='disabled';
	}
    ?>
	<tr>
        <td colspan="5">
            <table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                    <td class="celdaizquierda">Registro N&ordm;:<br />
                    <input name="idregistroatencion" type="text" class="cajatexto" id="idregistroatencion" onkeypress="return validar(event,/[0-9]/)" size="25" maxlength="12" disabled="disabled" value="<?=$DatosRegistroActual[0]['idregistroatencion']?>" <?php echo $DeshabilitarRegistroInactivo?> />
                    </td>
                    <td class="celdaizquierda">Fecha(dd/mm/yyyy):<br />
                    <input name="fechaingreso" type="text" class="cajatexto" id="fechaingreso" onkeypress="return validar(event,/[0-9]/)" onkeyup="lafecha(this,event)" onblur="vfecha(this);abrirAjax('validamayorfecha','<?=URL_COMUN_PATH."data/validafechamayor.php"?>','mensaje=La fecha de ingreso debe ser menor o igual a la fecha actual&fechafinal='+this.value+'&nombreformulario='+this.form.name+'&nombrecampo='+this.name,'2');" size="15" maxlength="10" value="<?php if($DatosRegistroActual[0]['fechaingreso']!=""){echo $DatosRegistroActual[0]['fechaingreso'];}else{echo date('d/m/Y');}?>" <?php echo $DeshabilitarRegistroInactivo?> disabled="disabled" />
                    <img src="<?php echo URL_COMUN_PATH."imagenes/cal.gif"?>" style="cursor:pointer" onClick="popUpCalendar(document.forms.item(0).elements['fechaingreso'], document.forms.item(0).elements['fechaingreso'], 'dd/mm/yyyy');" title="Calendario" <?php echo $DeshabilitarRegistroInactivo?> />
                    <div id="validamayorfecha" style="display:none"></div>
                    </td>
                    <td class="celdaizquierda">Origen Hospitalizaci&oacute;n:<br />
                    <select class="cajatexto" name="idorigenhospitalizacion" style="width:200px" onchange="habilitarProcedencia(this.form,this.value)" <?php echo $DeshabilitarRegistroInactivo?>>
                    <?php
                    crearCombo($listaorigenhospitalizacion,$DatosRegistroActual[0]['idorigenhospitalizacion'],'idorigenhospitalizacion','nombreorigenhospitalizacion');
                    ?>
                    </select>
                    </td>
                    <td class="celdaizquierda">Situaci&oacute;n<br />
                    <select class="cajatexto" name="idsituacion" style="width:150px" <?php echo $DeshabilitarRegistroInactivo?>>
                    <?php
                    crearCombo($listasituacion,$DatosRegistroActual[0]['idsituacion'],'idsituacion','nombresituacion');
                    ?>
                    </select>
                    </td>
                	<td class="celdaizquierda" valign="top">Cama:<br />
                    <input name="cama" type="text" class="cajatexto" id="cama" onkeypress="return validar(event,/[A-Za-z0-9ÑñáéíóúÁÉÍÓÚ ]/)" size="20" maxlength="20" value="<?=$DatosRegistroActual[0]['cama']?>" <?php echo $DeshabilitarRegistroInactivo?> />
                    </td>
            	</tr>
			</table>
		</td>
	</tr>
	<tr <?=$OcultarCuentas?>>
    	<td colspan="5" >
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td class="celdaizquierda">
                    <img style="cursor:pointer" src='<?php echo URL_COMUN_PATH?>imagenes/modificar.jpg' title='Agregar M&eacute;dicos' onclick="abrirPaciente('<?php echo URL_MODULOS_PATH."parametrizacion/medico.php";?>','FrmDatos','info','disabled','1')" />
                    </td>
                    <td class="celdaizquierda">
                    <div id="datomedico">
                    M&eacute;dico:<br />
                    <select class="cajatexto" name="idmedico" style="width:250px" <?php echo $DeshabilitarRegistroInactivo?>>
                    <?php
                    crearCombo($listamedico,$DatosRegistroActual[0]['idmedico'],'idmedico','nombremedico');
                    ?>
                    </select>
                    </div>
                    </td>
                    <td class="celdaizquierda">Especialidad:<br />
                    <select class="cajatexto" name="idespecialidad" style="width:220px" <?php echo $DeshabilitarRegistroInactivo?>>
                    <?php
                    crearCombo($listaespecialidad,$DatosRegistroActual[0]['idespecialidad'],'idespecialidad','nombreespecialidad');
                    ?>
                    </select>
                    </td>
                    <td class="celdaizquierda">Dep.Procedencia:<br />
                    <select class="cajatexto" name="iddepartamento" style="width:150px" onchange="cargarcomboajax('<? echo URL_COMUN_PATH.'data/';?>municipios.php','municipio',this.value,'iddepartamento','')" <?php echo $DeshabilitarCampos;?> <?php echo $DeshabilitarRegistroInactivo?> <?php if($DatosRegistroActual[0]['idorigenhospitalizacion']!='REM')echo 'disabled="disabled"';?>>
                    <?php
                    crearCombo($listadepartamento,$DatosRegistroActual[0]['iddepartamentoprocedencia'],'iddepartamento','nombredepartamento');
                    ?>
                    </select>
                    </td>
                    <td class="celdaizquierda">Mun.Procedencia:<br />
                    <div id="municipio">
                    <?php
					$_POST['iddepartamento']=$DatosRegistroActual[0]['iddepartamentoprocedencia'];
					$_POST['idmunicipio']=$DatosRegistroActual[0]['idmunicipioprocedencia'];
					$_POST['DeshabilitarCampos']=$DeshabilitarCampos;
					if($DatosRegistroActual[0]['idorigenhospitalizacion']!='REM')
						$_POST['DeshabilitarRegistroInactivo']='disabled';
					include COMUN_PATH.'data/municipios.php';
					?>
                    </div>        
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="5"  height="10" align="left">
			<?php
            $widthpaciente='100%';
            $DeshabilitarCampos="disabled";
            $jsbuscarajax="buscarDatos('busquedapaciente',this.form,this.form.idtipodocumento,this,'".URL_MODULOS_PATH."auditoriac/data/buscapaciente.php','numerodocumento='+this.value+'&DeshabilitarCampos=".$DeshabilitarCampos."',event,'buscapaciente')";
            ?>
			<div id="datospaciente">
            <table border="0" class="" align="center" cellpadding="0" cellspacing="0" width="<?=$widthpaciente?>">
              <tr>
                <td>
                  <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td class="celdaizquierda">
                        <table cellpadding="0" cellspacing="0" width="100%">
                          <tr>
                            <td valign="bottom"><img style="cursor:pointer" src='<?php echo URL_COMUN_PATH?>imagenes/modificar.jpg' title='Agregar o Modificar Paciente' onclick="abrirPaciente('<?php echo URL_MODULOS_PATH."auditoriac/paciente.php";?>','FrmDatos','info','disabled','1')" <?php echo $DeshabilitarRegistroInactivo?>></td>
                            <td valign="bottom">
                              Identicaci&oacute;n Paciente:<br />
                              <select class="cajatexto" name="idtipodocumento" style="width:170px" <?php echo $HabilitarPrimaria;?> <?php echo $DeshabilitarRegistroInactivo?> >
                              <?php
                              crearCombo($listatipodocu,$DatosPactienteActual[0]['idtipodocumento'],'idtipodocumento','nombretipodocumento');
                              ?>
                              </select>
                            </td>
                            <td valign="bottom"><br />
                            <div id="busquedapacientedirecto" style="display:none"></div>
                            <input name="numerodocumento" type="text" class="cajatexto" id="numerodocumento" onkeypress="return desactivaEnter(event)" onkeyup="<?=$jsbuscarajax;?>" value="<?=$DatosPactienteActual[0]['numerodocumento'];?>" title="<?=$DatosPactienteActual[0]['numerodocumento'];?>" <?php echo $HabilitarPrimaria;?> size="20" <?php echo $DeshabilitarRegistroInactivo?> /></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td valign="top" align="left">
                              <div style="width:250px; position:absolute; display:none;" id="busquedapaciente" class="capabusqueda"></div>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td class="celdaizquierda">
                 	  		<table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
									<td>Nombre Paciente:<br />
                                    <input name="nombrepaciente" type="text" class="cajatexto" id="nombrepaciente" onkeypress="return validar(event,/[A-Za-zÑñáéíóúÁÉÍÓÚ ]/)" size="65" title="<?=html_entity_decode($DatosPactienteActual[0]['nombrepaciente']);?>" value="<?=html_entity_decode($DatosPactienteActual[0]['nombrepaciente']);?>" <?php echo $DeshabilitarCampos;?> <?php echo $DeshabilitarRegistroInactivo?> />
									</td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                      </td>
                      <td class="celdaizquierda">
                 	  		<table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td title="Fecha de Nacimiento">Fec.Nac:<br />
                                    <input name="fechanacimiento" type="text" class="cajatexto" id="fechanacimiento" onkeypress="return validar(event,/[0-9]/)" onkeyup="lafecha(this,event)" size="15" maxlength="10" value="<?=$DatosPactienteActual[0]['fechanacimiento'];?>" title="<?=$DatosPactienteActual[0]['fechanacimiento'];?>" onblur="calcularedad('validar',this.form,'fechanacimiento','edadpaciente','<?php echo URL_COMUN_PATH.'data/calcularedad.php'?>');" <?php echo $DeshabilitarCampos;?> disabled="disabled" <?php echo $DeshabilitarRegistroInactivo?> />
                                    </td>
                                    <td>Edad:<br />
                                    <input name="edadactualpaciente" type="text" class="cajatexto" id="edadactualpaciente" onkeypress="return validar(event,/[0-9/]/)" size="10" value="<? echo $DatosRegistroActual[0]['edadactualpaciente'].' '.html_entity_decode($DatosRegistroActual[0]['unidadedadactualpaciente']);?>" title="<? echo $DatosRegistroActual[0]['edadactualpaciente'].' '.html_entity_decode($DatosRegistroActual[0]['unidadedadactualpaciente']);?>" <?php echo $DeshabilitarCampos;?> disabled="disabled" <?php echo $DeshabilitarRegistroInactivo?> />
                                    </td>
                                    <td>Gr. Etareo:<br />
                                    <select class="cajatexto" name="idgrupoetareo" style="width:110px" <?php echo $DeshabilitarCampos;?> <?php echo $DeshabilitarRegistroInactivo?>>
                                    <?php
                                    crearCombo($listagrupoetareo,$DatosRegistroActual[0]['idgrupoetareo'],'idgrupoetareo','nombregrupoetareo');
                                    ?>
                                    </select>
                                    </td>
                            	</tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                      	</td>
					</tr>
                    <tr>
                      	<td class="celdaizquierda" colspan="3" >
                 	  		<table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>Entidad Salud:<br />
                                    <select class="cajatexto" name="idinstitucioneapb" style="width:400px;" onchange="cargarcomboajax('<? echo URL_COMUN_PATH.'data/';?>contratos.php','contrato',this.value,'idinstitucioneapb','')" <?php echo $DeshabilitarRegistroInactivo?> <?=$DeshabilitaContrato?>>
                                    <?php
                                    crearCombo($listaeapb,$DatosRegistroActual[0]['idinstitucioneapb'],'idinstitucioneapb','nombreinstitucioneapb');
                                    ?>
                                    </select>
                                    </td>
                                    <td>Contrato:<br />
                                    <div id="contrato">
                                    <?php
                                    $_POST['idinstitucioneapb']=$DatosRegistroActual[0]['idinstitucioneapb'];
									$_POST['idcontrato']=$DatosRegistroActual[0]['idcontrato'];
									$_POST['DeshabilitarRegistroInactivo']=$DeshabilitarRegistroInactivo;
									$_POST['DeshabilitaContrato']=$DeshabilitaContrato;
									include COMUN_PATH.'data/contratos.php';
									?>
                                    </div>        
                                    </td>
                                    <td>R&eacute;gimen:<br />
                                    <select class="cajatexto" name="idregimen" style="width:220px" <?php echo $DeshabilitarRegistroInactivo?> >
                                    <?php
                                    crearCombo($listaregimen,$DatosRegistroActual[0]['idregimen'],'idregimen','nombreregimen');
                                    ?>
                                    </select>
                                    </td>
                            	</tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
        </table>
        </div>
        </td>
    </tr>
	<tr <?=$OcultarCuentas?>>
		<td   valign="top" class="celdaizquierda">
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td valign="bottom" colspan="2">
                    	Diagn&oacute;stico de Ingreso:
                    </td>
                </tr>
                <tr>
                	<td valign="bottom" style="width:10px">
                    	<?php
						if($DatosRegistroActual[0]['diagnosticoalerta']==1)
							$mostraralerta='style="color:#F00"';
						?>
                    	<input <?=$mostraralerta?> name="iddiagnosticoingreso" type="text" class="cajatexto" id="iddiagnosticoingreso" onkeypress="return validar(event,/[A-Za-z0-9]/)" size="5" maxlength="4" disabled="disabled" value="<?=$DatosRegistroActual[0]['iddiagnosticoingreso']?>" <?php echo $DeshabilitarRegistroInactivo?> />
                    </td>
                    <td valign="bottom">
                    	<input <?=$mostraralerta?> name="nombrediagnosticoingreso" type="text" class="cajatexto" id="nombrediagnosticoingreso"  onKeyUp="buscarDatos('busquedadiagnostico',this.form,this.form.iddiagnosticoingreso,this,'<? echo URL_MODULOS_PATH.'auditoriac/data/';?>buscadiagnostico.php','idtipodocumento='+this.form.idtipodocumento.value+'&numerodocumento='+this.form.numerodocumento.value+'&nombrediagnosticoingreso='+this.value,event,'buscadiagnostico')" onkeypress="return desactivaEnter(event)" size="50" maxlength="255" value="<?=html_entity_decode($DatosRegistroActual[0]['nombrediagnosticoingreso'])?>" <?php echo $DeshabilitarRegistroInactivo?> />
                    </td>
             	</tr>
				<tr>
					<td></td>
					<td valign="top">
					<div style="width:300px; position:absolute; display:none;" id="busquedadiagnostico" class="capabusqueda"></div>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" class="celdaizquierda">
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td valign="bottom" colspan="2">
						Otro Diagn&oacute;stico:
					</td>
				</tr>
				<tr>
					<td valign="bottom" style="width:10px">
						<input name="iddiagnosticootro" type="text" class="cajatexto" id="iddiagnosticootro" onkeypress="return validar(event,/[A-Za-z0-9]/)" size="5" maxlength="4" disabled="disabled" value="<?=$DatosRegistroActual[0]['iddiagnosticootro']?>" <?php echo $DeshabilitarRegistroInactivo?> />
					</td>
					<td valign="bottom">
						<input name="nombrediagnosticootro" type="text" class="cajatexto" id="nombrediagnosticootro"  onKeyUp="buscarDatos('busquedadiagnosticootro',this.form,this.form.iddiagnosticootro,this,'<? echo URL_MODULOS_PATH.'auditoriac/data/';?>buscadiagnostico.php','idtipodocumento='+this.form.idtipodocumento.value+'&numerodocumento='+this.form.numerodocumento.value+'&nombrediagnosticootro='+this.value,event,'buscadiagnostico')" onkeypress="return desactivaEnter(event)" size="50" maxlength="255" value="<?=html_entity_decode($DatosRegistroActual[0]['nombrediagnosticootro'])?>" <?php echo $DeshabilitarRegistroInactivo?> />
					</td>
				</tr>
				<tr>
					<td></td>
					<td valign="top">
						<div style="width:300px; position:absolute; display:none;" id="busquedadiagnosticootro" class="capabusqueda"></div>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" class="celdaizquierda">
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td valign="bottom">
						Sala:
					</td>
				</tr>
				<tr>
					<td valign="bottom" style="width:10px">
                        <select class="cajatexto" name="idsalacirugia" style="width:280px" <?php echo $DeshabilitarRegistroInactivo?>>
                        <?php
                        crearCombo($listasalacirugia,$DatosRegistroActual[0]['idsalacirugia'],'idsalacirugia','nombresalacirugia');
                        ?>
                        </select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
   		<td valign="top"   colspan="5" <?php echo $OcultarConcurrente;?>>
    	<table cellpadding="0" cellspacing="0" width="100%">
   		<tr>
		<td valign="top" class="celdaizquierda" >
        	<table cellpadding="0" cellspacing="0" width="100%">
            	<tr>
                	<td valign="bottom" colspan="2" nowrap="nowrap">
                    	Diagn&oacute;stico de Egreso:
                    </td>
                </tr>
                <tr>
                	<td valign="bottom" style="width:10px">
                    	<input name="iddiagnosticoegreso" type="text" class="cajatexto" id="iddiagnosticoegreso" onkeypress="return validar(event,/[A-Za-z0-9]/)" size="4" maxlength="4" disabled="disabled" value="<?=$DatosRegistroActual[0]['iddiagnosticoegreso']?>" <?php echo $DeshabilitarRegistroInactivo?> />
                    </td>
                    <td valign="bottom">
                    	<input name="nombrediagnosticoegreso" type="text" class="cajatexto" id="nombrediagnosticoegreso" onKeyUp="buscarDatos('busquedadiagnosticoegreso',this.form,this.form.iddiagnosticoegreso,this,'<? echo URL_MODULOS_PATH.'auditoriac/data/';?>buscadiagnostico.php','idtipodocumento='+this.form.idtipodocumento.value+'&numerodocumento='+this.form.numerodocumento.value+'&nombrediagnosticoegreso='+this.value,event,'buscadiagnostico')" onkeypress="return desactivaEnter(event)" size="45" maxlength="255" value="<?=html_entity_decode($DatosRegistroActual[0]['nombrediagnosticoegreso'])?>" <?php echo $DeshabilitarRegistroInactivo?> />
                    </td>
             	</tr>
				<tr>
					<td></td>
					<td valign="top">
					<div style="width:300px; position:absolute; display:none;" id="busquedadiagnosticoegreso" class="capabusqueda"></div>
					</td>
				</tr>
			</table>
		</td>
        <td class="celdaizquierda">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td nowrap="nowrap">Alto Costo:<br />
                    <select class="cajatexto" name="altocosto" style="width:60px" <?php echo $DeshabilitarRegistroInactivo?>>
                        <option value="">Seleccione...</option>
                        <?php
                        $listasino=$sino->listarSino();
                        if(!empty($listasino))
                        {
                            foreach($listasino as $valorsino => $Valor)
                            {
                                if($DatosRegistroActual[0]['altocosto']==$valorsino)
                                    echo '<option value="'.$valorsino.'" selected>'.html_entity_decode($Valor).'</option>';
                                else
                                    echo '<option value="'.$valorsino.'">'.html_entity_decode($Valor).'</option>';
                                next($listasino);
                            }
                        }
                        ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
        </td>
        <td class="celdaizquierda">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>Tipo Egreso:<br />
                    <select class="cajatexto" name="idtipoegreso" style="width:85px" <?php echo $DeshabilitarRegistroInactivo?>>
                    <?php
                    crearCombo($listatipoegreso,$DatosRegistroActual[0]['idtipoegreso'],'idtipoegreso','nombretipoegreso');
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
        </td>
        <td class="celdaizquierda">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                    Est. Egreso:<br />
                    <select class="cajatexto" name="idestadoegreso" style="width:85px" <?php echo $DeshabilitarRegistroInactivo?>>
                    <?php
                    crearCombo($listaestadoegreso,$DatosRegistroActual[0]['idestadoegreso'],'idestadoegreso','nombreestadoegreso');
                    ?>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
        </td>
        <td class="celdaizquierda">
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                <td>Destino:<br />
                <select class="cajatexto" name="iddestinopaciente" style="width:150px" <?php echo $DeshabilitarRegistroInactivo?> onchange="visualizarInstituciondestino('iddestinopaciente','idinstituciondestino')">
                <?php
                crearCombo($listadestinopaciente,$DatosRegistroActual[0]['iddestinopaciente'],'iddestinopaciente','nombredestinopaciente');
                ?>
                </select>
                </td>
                </tr>
                <tr>
                <td>
                </td>
                </tr>
            </table>
        </td>
	    <td class="celdaizquierda">
                <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>Inst. Destino:<br />
                        <?php
						if($DatosRegistroActual[0]['iddestinopaciente']==3 || $DatosRegistroActual[0]['iddestinopaciente']==4)
						{
						?>
                            <select class="cajatexto" name="idinstituciondestino" style="width:270px" <?php echo $DeshabilitarRegistroInactivo?>>
                                <?php
                                crearCombo($listainstituciondestino,$DatosRegistroActual[0]['idinstituciondestino'],'idinstituciondestino','nombreinstituciondestino');
                                ?>
                            </select>
                        <?php
						}
						else
						{
						?>
                            <select class="cajatexto" name="idinstituciondestino" style="width:270px" <?php echo $DeshabilitarRegistroInactivo?> disabled="disabled">
                                <?php
                                crearCombo($listainstituciondestino,$DatosRegistroActual[0]['idinstituciondestino'],'idinstituciondestino','nombreinstituciondestino');
                                ?>
                            </select>
                        <?php
						}
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </td>
 		</table>
		</td>
	</tr>
	<tr>
   		<td valign="top" colspan="5"  <?php echo $OcultarConcurrente;?>>
            <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td class="celdaizquierda">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>N&ordm; Factura:<br />
                              <input name="numerofactura" type="text" class="cajatexto" id="numerofactura" size="15" maxlength="50" value="<?=$DatosRegistroActual[0]['numerofactura']?>" <?php echo $DeshabilitarRegistroInactivo?> />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                </td>
                <td class="celdaizquierda">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td nowrap="nowrap">Fecha:<br />
                              <input name="fechafactura" type="text" value="<?php if($DatosRegistroActual[0]['fechafactura']!="00/00/0000"){echo $DatosRegistroActual[0]['fechafactura'];}?>" class="cajatexto" id="fechafactura" onkeypress="return validar(event,/[0-9]/)" onkeyup="lafecha(this,event)" onblur="vfecha(this)" size="15" maxlength="10" <?php echo $DeshabilitarRegistroInactivo?> />
                              <img src="<?php echo URL_COMUN_PATH."imagenes/cal.gif"?>" style="cursor:pointer"onClick="popUpCalendar(document.forms.item(0).elements['fechafactura'], document.forms.item(0).elements['fechafactura'], 'dd/mm/yyyy');" title="Calendario" <?php echo $DeshabilitarRegistroInactivo?> />
                          </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                   </td>
                    <td valign="top" colspan="2" <?php echo $OcultarConcurrente;?>>
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="left">Recobro:<br />
                                <select class="cajatexto" name="idrecobro" style="width:150px" <?php echo $DeshabilitarRegistroInactivo?>>
                                <?php
                                crearCombo($listarecobro,$DatosRegistroActual[0]['idrecobro'],'idrecobro','nombrerecobro');
                                ?>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                    <td class="celdaizquierda">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>Nombre Facturador:<br />
                                  <input name="nombrefacturador" type="text" onkeypress="return validar(event,/[A-Za-zÑñáéíóúÁÉÍÓÚ ]/)" class="cajatexto" id="nombrefacturador" size="35" maxlength="50" value="<?=html_entity_decode($DatosRegistroActual[0]['nombrefacturador'])?>" <?php echo $DeshabilitarRegistroInactivo?> />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                    <td class="celdaizquierda">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                              <td nowrap="nowrap">Dig.Vr.Fac:<br />
                                <select class="cajatexto" name="habilitarvalor" style="width:60px" <?php echo $DeshabilitarRegistroInactivo?> onchange="habilitarValorFactura(this.form)">
                                    <option value="">Seleccione...</option>
                                    <?php
                                    $listasino=$sino->listarSino();
                                    if(!empty($listasino))
                                    {
                                        foreach($listasino as $valorsino => $Valor)
                                        {
                                            if($DatosRegistroActual[0]['habilitarvalor']==$valorsino)
                                                echo '<option value="'.$valorsino.'" selected>'.html_entity_decode($Valor).'</option>';
                                            else
                                                echo '<option value="'.$valorsino.'">'.html_entity_decode($Valor).'</option>';
                                            next($listasino);
                                        }
                                    }
                                    ?>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                    <td class="celdaizquierda">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td nowrap="nowrap">Vr. Factura:<br />
                                <input name="valorfactura" type="text" class="cajatexto" id="valorfactura" onkeypress="return validar(event,/[0-9.]/)" onkeyup="escribirValorpagar(this,this.form.valorglosas,this.form.valorpagar);" onblur="validarValorfactura(this,this.form.valorglosas)" size="20" maxlength="20" value="<?=$DatosRegistroActual[0]['valorfactura']?>" <?php echo $DeshabilitarRegistroInactivo?> disabled="disabled" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                    <td class="celdaizquierda">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>Vr. Glosas:<br />
                                <input name="valorglosas" type="text" class="cajatexto" id="valorglosas" onkeypress="return validar(event,/[0-9.]/)" size="20" maxlength="20" value="<?=$DatosRegistroActual[0]['valorglosas']?>" <?php echo $DeshabilitarRegistroInactivo?> disabled="disabled" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                    <td class="celdaizquierda">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td>Vr. a Pagar:<br />
                                <input name="valorpagar" type="text" class="cajatexto" id="valorpagar" onkeypress="return validar(event,/[0-9.]/)" size="20" maxlength="20" value="<?=$DatosRegistroActual[0]['valorpagar']?>" <?php echo $DeshabilitarRegistroInactivo?> disabled="disabled" />
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
	</tr>
    <tr>
        <td colspan="5">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="width:940px">
                        <div id="Botoneria">
                        <?php
                        $botoneria->visualizaBotoneria($ExisteInfo,$jsguardar,$jseliminar,$jsbuscar,$jscancelar,'',$DeshabilitarRegistroInactivo,$jsimprimir);
                        ?>
                        </div>
                    </td>
                    <td align="right">
                        <?=$TituloImagen?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="7" colspan="5">
        </td>
	</tr>
</table>
</form>
