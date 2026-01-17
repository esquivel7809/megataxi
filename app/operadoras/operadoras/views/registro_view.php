		<div class="grid_12 content">
			<div class="grid_3">
			    &nbsp; <?=$token?>
			</div>
			<div class="grid_6">
				<div class="demo">
				    <?php echo $msg; ?>
				</div>
			    <div class="box session-login">
			        <div class="block login" id="login-forms">
			            <?= form_open('inicio/guardar_registro') ?>
			                <div class="inicio_session">Complete la informacion</div>
			                <div class="form-login">
			                    <div>
			                        <label>NIT: </label>
			                        <?= form_input(array('name'=> 'nitempresa', 'id' => 'nitempresa', 'value' => $nitempresa ))?>
			                    </div>
			                    <div>
			                        <label>Empresa: </label>
			                        <?= form_input(array('name'=> 'empresa', 'id' => 'empresa'))?>
			                    </div>
			                    <div>
			                        <label>Email: </label>
			                        <?= form_input(array('name'=> 'email', 'id' => 'email'))?>
			                    </div>
			                    <div class="botoneria login-button">
			                    	<button class="" type="submit" name="registrar" id="registrar" value="registrar"  >Registrar</button>                            
			                    </div>
			                </div>
			            <?=form_close()?>
			        </div>
			    </div>
			</div>
			<div class="grid_3">
			    &nbsp; 
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>