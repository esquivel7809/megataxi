<script>
	$(document).ready(function(){
		$('#form_modulo').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#nombremodulo,#carpetamodulo').alpha();
        $('#orden').numeric();
});
	
</script>
<div class="clear"></div>
<div class="grid_6">
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