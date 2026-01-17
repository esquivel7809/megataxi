<script type="text/javascript">
    $(document).ready(function()
    {
    $("#username").focus();
    });
    
    function redireccionar()
    {
        window.location.href ="<?=site_url('modulos/inicio/')?>";
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
        /*else if($("#idempresa").attr("value")=="" || $("#idempresa").attr("value")==0)
        {
            alert("Debe Seleccionar la Empresa");
            $("#idempresa").focus();
            return false;
        }*/
        else
        {
            URL="username="+$("#username").attr("value")+
                "&password="+$("#password").attr("value")+
                "&idempresa=1";
            $.ajax({
                type: "POST",
                url: "<?=site_url('validacion/validarusuario')?>",  // Send the login info to this page
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
                        $("#idempresa").attr("value","0");
                        $('#login_response').html(msg);
                    }
                }
            });
        }
    }
 </script>
<div class="clear"></div>
<div class="grid_12" style="height: 100px;"></div>
<div class="clear"></div>
<div class="grid_2">
    &nbsp;
</div>
<div class="grid_8">
    <div class="box session-login">
        <div id="login_response"></div>
        <div class="block login" id="login-forms">
            <?= form_open('contacto/procesa') ?>
                <div class="inicio_session">Inicio de Sesi&oacute;n</div>
                <div class="form">
                    <div>
                        <label>Usuario: </label>
                        <?= form_input(array('name'=> 'username', 'id' => 'username'))?>
                    </div>
                    <div>
                        <label>Contraseña: </label>
                        <?= form_password(array('name'=> 'password', 'id' => 'password'))?>
                    </div>
                    <?php /* ?>
                    <div>
                        <label>Empresa: </label>
                        <div class="wrapper-select-form">
                        <?= form_dropdown('idempresa', $empresas, '', 'id="idempresa"'); ?>
                        </div>
                    </div>
					<?php */ ?>
                    <div class="botoneria">
                    	<button class="login-button" type="button" id="ingresar" onclick='validarForm()' >Ingresar</button>                            
                    </div>
                </div>
                <div>
                <?
                $submit = array('type'=> 'button', 'value' => 'Ingresar','class'=>'login-button','onclick'=>'validarForm()','id'=>'ingresar');
                //echo form_input($submit);
                ?>
                </div>
            <?=form_close()?>
        </div>
    </div>
</div>
<div class="grid_2">
    &nbsp;
</div>
<div class="clear"></div>
<div class="grid_12" style="height: 100px;"></div>
<div class="clear"></div>
