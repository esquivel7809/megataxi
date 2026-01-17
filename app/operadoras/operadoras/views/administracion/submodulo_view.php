<script>
	$(document).ready(function(){
		$('#form_submodulo').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#nombresubmodulo').alpha({allow:". "});
        $('#urlsubmodulo').alpha({allow:"."});
});
	
</script>
<div class="clear"></div>
<div class="grid_6">
		<fieldset>
			<legend>Gestión de Submodulos</legend>
            <form method="post" name="form_submodulo" id="form_submodulo" action="<?=site_url('administracion/submodulo/registro')?>">
                <input type="hidden" name="idsubmodulo" id="idsubmodulo" value="<?php if(!empty($datoidsubmodulo)) echo $datoidsubmodulo?>" />
                <table>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        Nombre del Submodulo:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="nombresubmodulo" id="nombresubmodulo" required="required" title="Nombre Submodulo" placeholder="Nombre Submodulo" value="<?php if(!empty($datonombresubmodulo)) echo $datonombresubmodulo?>" style="width: 200px;"  />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Archivo del Submodulo:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="urlsubmodulo" id="urlsubmodulo" required="required" title="Archivo Submodulo" placeholder="Archivo Submodulo" value="<?php if(!empty($datourlsubmodulo)) echo $datourlsubmodulo?>" style="width: 200px;"  />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Modulo:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="idmodulo" id="idmodulo" class="required" >
                                        <?=$modulos?>
                                        </select>
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