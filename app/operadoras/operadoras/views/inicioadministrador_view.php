<script type="text/javascript">
    $(document).ready(function()
    {
    $("#username").focus();
    });
    
    function redireccionar()
    {
        window.location.href ="<?=site_url('administracion/inicio/')?>";
    }
    function enter(e)
    { 
    	tecla = (document.all) ? e.keyCode : e.which;
        if(tecla==13)
    	{
    		$("#ingresar").click();
    	}
    	else
    	{
    		return false;
    	}
    }
    
    function validarForm()
    {
        if($("#username").attr("value")=="")
        {
            alert("Debe Digitar el Nombre de Usuario");
            $("#username").focus();
            return false;
        }
        else if($("#password").attr("value")=="")
        {
            alert("Debe Digitar la Contraseña");
            $("#password").focus();
            return false;
        }
        else
        {
            URL="username="+$("#username").attr("value")+
                "&password="+$("#password").attr("value");
            $.ajax({
                type: "POST",
                url: "<?=site_url('administracion/validacion/validarusuario')?>",  // Send the login info to this page
                data: URL,
                cache:false,
            	beforeSend: function(){
            		$("#login_response").html("<img id='cargando' src='img/ajax-loader.gif' style='border:none' alt=''> ");
            	},
                success: function(msg)
                {
                    if(msg == 'yes') // LOGIN OK?
                    { 
                        redireccionar()
                    }
                    else // ERROR?
                    {
                        $("#username").focus();
                        $("#username").attr("value","");
                        $("#password").attr("value","");
                        $('#login_response').html(msg);
                    }
                }
            });
        }
    }
 </script>
		<div class="grid_12 content">
			<div class="grid_3">
			    &nbsp;
			</div>
			<div class="grid_6">
			    <div class="box session-login">
			        <div class="block login" id="login-forms">
			            <?= form_open('administrador/entrada') ?>
			                <div class="inicio_session">Inicio de Sesi&oacute;n Administrador</div>
			                <div class="form-login">
			                    <div>
			                        <label>Usuario: </label>
			                        <?= form_input(array('name'=> 'username', 'id' => 'username'))?>
			                    </div>
			                    <div>
			                        <label>Contraseña: </label>
			                        <?= form_password(array('name'=> 'password', 'id' => 'password'))?>
			                    </div>
			                    <div class="botoneria login-button">
			                    	<button type="button" id="ingresar" onclick='validarForm()' >Ingresar</button>
			                    </div>
			                </div>
			                <div>
			                </div>
			            <?=form_close()?>
			        </div>
			        <div id="login_response">&nbsp;</div>
			    </div>
			</div>
			<div class="grid_3">
			    &nbsp;
			</div>
		</div>
		<div class="clear"></div>