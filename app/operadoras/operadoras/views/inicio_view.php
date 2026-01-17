		<div class="grid_12 content">
			<div class="grid_3">
			    &nbsp;
			</div>
			<div class="grid_6">
				<div class="demo">
					<?php echo (!empty($msg_activacion))? $msg_activacion."<br />" : ""; echo (!empty($msg_email))? $msg_email."<br />" : ""; ?> 
				    Para ingresar a la versi&oacute;n demo debe utilizar <br /><strong>Usuario: prueba</strong> y <strong>Contraseña: prueba</strong>.
				</div>
			    <div class="box session-login">
			        <div class="block login" id="login-forms">
			            <?php
			            	$attributes = array('class' => 'form_login', 'id' => 'form_login', 'name' => 'form_login');
							echo form_open('contacto/procesa', $attributes) ?>
			                <div class="inicio_session">Inicio de Sesi&oacute;n</div>
			                <div class="form-login">
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
			                        <label>NIT Empresa: </label>
			                        <?= form_input(array('name'=> 'nitempresa', 'id' => 'nitempresa'))?>
			                    </div>
			                    <div>
			                        <label>Empresa: </label>
			                        <div class="wrapper-select-form">
			                        <?= form_dropdown('idempresa', $empresas, '', 'id="idempresa"'); ?>
			                        </div>
			                    </div>
								<?php */ ?>
			                    <div class="botoneria login-button">
			                    	<button class="ingresar" type="submit" id="ingresar" >Ingresar</button>                            
			                    </div>
			                </div>
			                <?php /* ?> 
			                <div>
			                <?
			                $submit = array('type'=> 'button', 'value' => 'Ingresar','class'=>'login-button','onclick'=>'validarForm()','id'=>'ingresar');
			                //echo form_input($submit);
			                ?>
			                </div>
							 * <?php */ ?>
			            <?=form_close()?>
			        </div>
			        <div id="login_response">&nbsp;</div>
			    </div>
			    <?php /* ?> 
			    <div class="administrador">
			    	<?php echo anchor('administrador', 'Administrador', 'title="Sección para el administrador"'); ?>
			    </div>
			    <?php */ ?>
			</div>
			<div class="grid_3">
			    &nbsp;
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>