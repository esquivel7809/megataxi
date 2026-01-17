            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Por favor entrar</h3>
                    </div>
                    <div class="panel-body">
                    	<?= form_open('login/validar', array('role' => 'form', 'id'=>'form_login_', 'name'=>'form_login_')) ?>
                            <fieldset>
                                <div class="form-group">
                                	<?= form_input(array('name'=> 'usuario', 'id' => 'usuario', 'class' => 'form-control', 'placeholder' => 'Usuario', 'autofocus'=>'', 'title' => 'Digite el Usuario'))?>
                                    <!-- <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus> -->
                                </div>
                                <div class="form-group">
                                	<?= form_password(array('name'=> 'password', 'id' => 'password', 'class' => 'form-control', 'placeholder' => 'Contraseña', 'title' => 'Digite la Contraseña'))?>
                                    <!-- <input class="form-control" placeholder="Password" name="password" type="password" value=""> -->
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Recordarme
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block" type="submit" id="ingresar" >Ingresar</button>
                                <!-- <a href="index.html" class="btn btn-lg btn-success btn-block">Ingresar</a> -->
                            </fieldset>
                        <?=form_close()?>
						<?php if(!empty($resultado)){?>
                        <div id="login_response" ><?php echo $resultado; ?></div>
						<?php } ?>
                    </div>
                </div>
            </div>
