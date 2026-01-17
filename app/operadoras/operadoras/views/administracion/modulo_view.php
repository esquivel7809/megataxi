<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Gestión de Modulos</h1>
    </div>
    <!-- /.col-lg-12 -->
	<div class="col-lg-12">
		<!--
		<form role="form">
		<form method="post" name="form_conductores" id="form_conductores" action="<?=site_url('conductores/conductores/registro')?>">
		<?= form_open('contacto/procesa', array('role' => 'form', 'id'=>'form_login', 'name'=>'form_login')) ?>
			<div class="form-group">
				<label>Tipo de Documento :</label>
				<input class="form-control">
				<?= form_input(array('name'=> 'username', 'id' => 'username', 'class' => 'form-control', 'placeholder' => 'Usuario', 'autofocus'=>'', 'title' => 'Digite el Usuario'))?>
				
				<p class="help-block">Example block-level help text here.</p>
			</div>
			<?= form_password(array('name'=> 'password', 'id' => 'password', 'class' => 'form-control', 'placeholder' => 'Contraseña', 'title' => 'Digite la Contraseña'))?>
		</form>
		<?=form_close()?>
		-->
		<!--
		<form role="form">
			<div class="form-group">
				<label>Tipo de Documento :</label>
				<input class="form-control">
			</div>
			<div class="form-group">
				<label>Tipo de Documento :</label>
				<input class="form-control">
			</div>
		</form>
-->
		<?= form_open('administracion/modulo/registro', array('role' => 'form', 'class' => 'form-horizontal', 'id'=>'form_modulo', 'name'=>'form_modulo')) ?>
            <input type="hidden" name="idmodulo" id="idmodulo" value="<?php if(!empty($datoidmodulo)) echo $datoidmodulo?>" />
		    <div class="form-group">
		        <label for="nombremodulo" class="control-label col-xs-3">Nombre del Modulo:</label>
		        <div class="col-xs-9">
		            <input type="text" class="form-control" name="nombremodulo" id="nombremodulo" required="required" title="Nombre Modulo" placeholder="Nombre Modulo" value="<?php if(!empty($datonombremodulo)) echo $datonombremodulo; ?>" />
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="carpetamodulo" class="control-label col-xs-3">Carpeta del Modulo:</label>
		        <div class="col-xs-9">
		            <input type="text" class="form-control" name="carpetamodulo" id="carpetamodulo" required="required" title="Carpeta Modulo" placeholder="Carpeta Modulo" value="<?php if(!empty($datocarpetamodulo)) echo $datocarpetamodulo?>"  />
		        </div>
		    </div>
		    <div class="form-group">
		        <label for="orden" class="control-label col-xs-3">Orden:</label>
		        <div class="col-xs-9">
		            <input type="text" class="form-control" name="orden" id="orden" required="required" title="Orden" placeholder="Orden" value="<?php if(!empty($datoorden)) echo $datoorden?>" />
		        </div>
		    </div>
		    <div class="form-group">
		        <div class="col-xs-offset-3 col-xs-9">
		            <?=$botoneria ?>
		        </div>
		    </div>
		<?=form_close()?>
<!-- 
<h1>Sign Up</h1>
    <form class="form-horizontal">
        <div class="form-group">
            <label class="control-label col-xs-3" for="inputEmail">Email:</label>
            <div class="col-xs-9">
                <input type="email" class="form-control" id="inputEmail" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="inputPassword">Password:</label>
            <div class="col-xs-9">
                <input type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="confirmPassword">Confirm Password:</label>
            <div class="col-xs-9">
                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="firstName">First Name:</label>
            <div class="col-xs-9">
                <input type="text" class="form-control" id="firstName" placeholder="First Name">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="lastName">Last Name:</label>
            <div class="col-xs-9">
                <input type="text" class="form-control" id="lastName" placeholder="Last Name">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="phoneNumber">Phone:</label>
            <div class="col-xs-9">
                <input type="tel" class="form-control" id="phoneNumber" placeholder="Phone Number">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3">Date of Birth:</label>
            <div class="col-xs-3">
                <select class="form-control">
                    <option>Date</option>
                </select>
            </div>
            <div class="col-xs-3">
                <select class="form-control">
                    <option>Month</option>
                </select>
            </div>
            <div class="col-xs-3">
                <select class="form-control">
                    <option>Year</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="postalAddress">Address:</label>
            <div class="col-xs-9">
                <textarea rows="3" class="form-control" id="postalAddress" placeholder="Postal Address"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3" for="ZipCode">Zip Code:</label>
            <div class="col-xs-9">
                <input type="number" class="form-control" id="ZipCode" placeholder="Zip Code">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-3">Gender:</label>
            <div class="col-xs-2">
                <label class="radio-inline">
                    <input type="radio" name="genderRadios" value="male"> Male
                </label>
            </div>
            <div class="col-xs-2">
                <label class="radio-inline">
                    <input type="radio" name="genderRadios" value="female"> Female
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-3 col-xs-9">
                <label class="checkbox-inline">
                    <input type="checkbox" value="news"> Send me latest news and updates.
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-3 col-xs-9">
                <label class="checkbox-inline">
                    <input type="checkbox" value="agree">  I agree to the <a href="#">Terms and Conditions</a>.
                </label>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-xs-offset-3 col-xs-9">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </div>
    </form>
		
	</div>
-->