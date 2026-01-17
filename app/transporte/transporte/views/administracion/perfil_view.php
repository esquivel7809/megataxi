<script>
	$(document).ready(function(){
		$('#form_perfil').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#nombremodulo,#carpetamodulo').alpha();
});
	
</script>
<style type="text/css">
<!-- 
.placa{
    font-size: 50px;
    height: 50px;
    width: 230px;
    text-transform: uppercase;
    
}
 -->
</style>
<div class="clear"></div>
<div class="grid_6">
		<fieldset>
			<legend>Gestión de Perfiles de Usuario</legend>
            <form method="post" name="form_perfil" id="form_perfil" action="<?=site_url('administracion/perfil/registro')?>">
                <input type="hidden" name="idperfilusuario" id="idperfilusuario" value="<?php if(!empty($datoidperfilusuario)) echo $datoidperfilusuario?>" />
                <table>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        Nombre del Perfil:
                                    </td>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="nombreperfilusuario" id="nombreperfilusuario" required="required" title="Nombre Perfil" placeholder="Nombre Perfil" value="<?php if(!empty($datonombreperfilusuario)) echo $datonombreperfilusuario?>" style="width: 200px;"  />
                                    </td>
                                    <td><?php if(!empty($jsmodulos)) {?>
                                        <input type="button" id="modulos" name="modulos" value="Módulos" onclick="<?php echo $jsmodulos?>" />
                                        <?php }?>
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