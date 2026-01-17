<div class="grid_12">
	<div class="titulo-modulo">Registro de conductores</div>
	<div class="contenido-modulo border border-radius border-shadow">
		<form method="post" name="form_conductores" id="form_conductores" action="<?=site_url('conductores/conductores/registro')?>">
			<input type="hidden" name="idconductor" id="idconductor" value="<?php if(!empty($datoidconductor)) echo $datoidconductor?>" />
			<div class="form">
				<div>
					<label>Tipo de Documento :</label>
					<div class="wrapper-select-form">
						<select name="idtipodocumento" id="idtipodocumento" required="" title="Tipo de Documento" <?php if(!empty($disabled)) echo $disabled?>>
						<?=$tipodocumento?>
						</select>
					</div>
				</div>
		        <div>
					<label>Nombre del Modulo : </label>
					<input type="text" name="nombremodulo" id="nombremodulo" required="required" title="Nombre Modulo" placeholder="Nombre Modulo" value="<?php if(!empty($datonombremodulo)) echo $datonombremodulo?>" />
				</div>
		        <div>
                    Carpeta del Modulo:
                    <input type="text" name="carpetamodulo" id="carpetamodulo" required="required" title="Carpeta Modulo" placeholder="Carpeta Modulo" value="<?php if(!empty($datocarpetamodulo)) echo $datocarpetamodulo?>" style="width: 200px;"  />
				</div>
		        <div>
                    Orden:
                    <input type="text" name="orden" id="orden" required="required" title="Orden" placeholder="Orden" value="<?php if(!empty($datoorden)) echo $datoorden?>" size="8"/>
				</div>

				
				
        <div>
          <label>Lugar de Expedici&oacute;n : </label>
          <input type="hidden" name="idlugarexpedicion" id="idlugarexpedicion" required="required" value="<?php if(!empty($datoidlugarexpedicion)) echo $datoidlugarexpedicion?>" />
          <input type="text" name="lugarexpedicion" id="lugarexpedicion" required="required" title="Lugar de Expedicion" placeholder="Lugar de Expedicion" value="<?php if(!empty($datolugarexpedicion)) echo $datolugarexpedicion?>" />
        </div>
        <div>
          <label>Primer Nombre : </label>
          <input type="text" name="primernombre" id="primernombre" required="required" title="Primer Nombre" placeholder="Digite Primer Nombre" value="<?php if(!empty($datoprimernombre)) echo $datoprimernombre?>" />
        </div>
        <div>
          <label>Segundo Nombre : </label>
          <input type="text" name="segundonombre" id="segundonombre" title="Segundo Nombre" placeholder="Digite Segundo Nombre" value="<?php if(!empty($datosegundonombre)) echo $datosegundonombre?>" />
        </div>
        <div>
          <label>Primer Apellido : </label>
          <input type="text" name="primerapellido" id="primerapellido" required="required" title="Primer Apellido" placeholder="Digite Primer Apellido" value="<?php if(!empty($datoprimerapellido)) echo $datoprimerapellido?>" />
        </div>
        <div>
          <label>Segundo Apellido : </label>
          <input type="text" name="segundoapellido" id="segundoapellido" title="Segundo Apellido" placeholder="Digite Segundo Apellido" value="<?php if(!empty($datosegundoapellido)) echo $datosegundoapellido?>" />
        </div>
        <div>
          <label>Direcci&oacute;n : </label>
          <input type="text" name="direccion" id="direccion" required="required" title="Direccion" placeholder="Digite la Direccion" value="<?php if(!empty($datodireccion)) echo $datodireccion?>" />
        </div>
        <div>
          <label>Telefono Fijo : </label>
          <input type="text" name="telefonofijo" id="telefonofijo" title="Telefono fijo" placeholder="Digite Telefono fijo" value="<?php if(!empty($datotelefonofijo)) echo $datotelefonofijo?>" />
        </div>
        <div>
          <label>E-Mail : </label>
          <input type="text" name="email" id="email" title="E-Mail" placeholder="Digite E-Mail" value="<?php if(!empty($datoemail)) echo $datoemail?>" />
        </div>
        <div>
          <label>Celular : </label>
          <input type="text" name="celular" id="celular" required="required" title="Celular" placeholder="Digite Celular" value="<?php if(!empty($datocelular)) echo $datocelular?>" />
        </div>
        <div>
          <label>Fecha de Nac. : </label>
          <input type="text" name="fechanacimiento" id="fechanacimiento" maxlength="10" title="Digite la fecha de nacimiento" placeholder="Digite Fecha Nacimiento" required="" value="<?php if(!empty($datofechanacimiento)) echo $datofechanacimiento?>" />
        </div>
        <div>
          <label>Edad (años) : </label>
          <input name="edadempleado" class="required" type="text" id="edadempleado" readonly="readonly" value="<?php echo $datoedad; ?>" <?php echo $DeshabilitarCampos;?> />
        </div>
        <div>
          <label>Lugar de Nac. : </label>
          <input type="hidden" name="idlugarnacimiento" id="idlugarnacimiento" required="required" value="<?php if(!empty($datoidlugarnacimiento)) echo $datoidlugarnacimiento?>" />
          <input type="text" name="lugarnacimiento" id="lugarnacimiento" required="required" title="Lugar de Nacimiento" placeholder="Lugar de Nacimiento" value="<?php if(!empty($datolugarnacimiento)) echo $datolugarnacimiento?>" />
        </div>
        <div>
          <label>G&eacute;nero :</label>
          <div class="wrapper-select-form">
            <select name="idgenero" id="idgenero" class="required">
              <?=$genero?>
            </select>
          </div>
        </div>
        <div>
          <label>Grupo Sanguineo :</label>
          <div class="wrapper-select-form">
            <select name="idgruposanguineo" id="idgruposanguineo" class="required">
              <?=$gruposanguineo?>
            </select>
          </div>
        </div>
        <div class="checkbox-section">
          <label>Conductor :</label>
          <input type="checkbox" name="conductor" <?php if(!empty($datoconductor)) echo $datoconductor?> />
        </div>
        <div class="checkbox-section">
          <label>Propietario :</label>
          <input type="checkbox" name="propietario" <?php if(!empty($datopropietario)) echo $datopropietario?> />
        </div>
        <div class="checkbox-section">
          <label>Activo :</label>
          <input type="checkbox" name="activo" <?php if(!empty($datoactivo)) echo $datoactivo?> />
        </div>
        <div class="botoneria"> <?php echo $botoneria; ?> </div>
      </div>
      <div class="foto-cond" id="fotoempleado" >
        <?=$datorutafoto?>
      </div>
    </form>
  </div>





	
		<fieldset>
			<legend>Gestión de Modulos</legend>
            <form method="post" name="form_modulo" id="form_modulo" action="<?=site_url('administracion/modulo/registro')?>">
                <input type="hidden" name="idmodulo" id="idmodulo" value="<?php if(!empty($datoidmodulo)) echo $datoidmodulo?>" />
                <table>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        Nombre del Modulo:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="nombremodulo" id="nombremodulo" required="required" title="Nombre Modulo" placeholder="Nombre Modulo" value="<?php if(!empty($datonombremodulo)) echo $datonombremodulo?>" style="width: 200px;"  />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Carpeta del Modulo:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="carpetamodulo" id="carpetamodulo" required="required" title="Carpeta Modulo" placeholder="Carpeta Modulo" value="<?php if(!empty($datocarpetamodulo)) echo $datocarpetamodulo?>" style="width: 200px;"  />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Orden:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="orden" id="orden" required="required" title="Orden" placeholder="Orden" value="<?php if(!empty($datoorden)) echo $datoorden?>" size="8"/>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table>
                                <tr>
                                    <td>
                                        <div id="botoneria">
                                            <?=$botoneria ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </form>
		</fieldset>
</div>
<div class="clear"></div>