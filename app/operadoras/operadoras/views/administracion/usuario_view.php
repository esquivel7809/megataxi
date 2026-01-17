<script>
	$(document).ready(function(){
		$('#form_usuario').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
        
        $('#loginusuario,#contrasena,#contrasena1').alphanumeric();
        $('#numerodocumento,#telefonousuario,#celularusuario').numeric();
        $('#nombreusuario,#cargousuario').alphanumeric({allow:" "});
        
        $('#loginusuario').mask('*****?*****');
        
        $("#contrasena").blur(function(){
            if($("#contrasena").attr("value")!="")
            {
                $("#contrasena1").focus().select();
            }
        });
        
        $("#contrasena1").blur(function(){
            if($("#contrasena1").attr("value")!=$("#contrasena").attr("value"))
            {
                $("#contrasena1").attr("value","");
                $("#contrasena").attr("value","");
            }
        });
        
});
	
</script>
<div class="clear"></div>
<div class="grid_6">
		<fieldset>
			<legend>Gestión de Usuarios</legend>
            <form method="post" name="form_usuario" id="form_usuario" action="<?=site_url('administracion/usuario/registro')?>">
                <input type="hidden" name="idusuario" id="idusuario" value="<?php if(!empty($datoidusuario)) echo $datoidusuario?>" />
                <table>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        Login:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="loginusuario" id="loginusuario" required="required" title="Login" placeholder="Login" value="<?php if(!empty($datologinusuario)) echo $datologinusuario?>" <?php if(!empty($disabled)) echo $disabled?> size="12"  />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Contraseña:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="password" name="contrasena" id="contrasena" required="required" title="Contraseña" placeholder="Contraseña" value="<?php if(!empty($datocontraseña)) echo $datocontraseña?>" size="25"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Repetir Contraseña:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="password" name="contrasena1" id="contrasena1" required="required" title="Repetir Contraseña" placeholder="Repetir Contraseña" value="<?php if(!empty($datocontraseña1)) echo $datocontraseña1?>" size="25" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tipo de Documento:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="idtipodocumento" id="idtipodocumento" class="required">
                                        <?=$tipodocumento?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Numero de Documento:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="numerodocumento" id="numerodocumento" required="required" title="Numero Documento" placeholder="Digite Nº Documento" value="<?php if(!empty($datonumerodocumento)) echo $datonumerodocumento?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Nombre:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="nombreusuario" id="nombreusuario" required="required" title="Nombre del usuario" placeholder="Nombre del usuario" value="<?php if(!empty($datonombreusuario)) echo $datonombreusuario?>" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Telefono Fijo:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="telefonousuario" id="telefonousuario" required="required" title="Telefono del usuario" placeholder="Telefono del usuario" value="<?php if(!empty($datotelefonousuario)) echo $datotelefonousuario?>" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Celular:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="celularusuario" id="celularusuario" required="required" title="Celular del usuario" placeholder="Celular del usuario" value="<?php if(!empty($datocelularusuario)) echo $datocelularusuario?>" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Cargo:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="cargousuario" id="cargousuario" required="required" title="Cargo del usuario" placeholder="Cargo del usuario" value="<?php if(!empty($datocargousuario)) echo $datocargousuario?>" size="40" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Perfil Usuario:
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="idperfilusuario" id="idperfilusuario" class="required" >
                                        <?=$perfilusuario?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Activo:<input type="checkbox" name="activo" style="cursor:pointer;" <?php if(!empty($datoactivo)) echo $datoactivo?> /></td>
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