<div id="header">
    <div class="grid_3">
    	<a href="">
    		<img height='55px' width='220px' title="<?php echo NOMBRE_APLICACION?>" alt="<?php echo NOMBRE_APLICACION?>" src='<?php echo base_url("img/logo_sigitrans_medium.png"); ?>' />
        </a>
    </div>
    <div class="grid_3">
        <h6>
            <?php echo NOMBRE_APLICACION?>
        </h6>
    </div>
    <div class="grid_2">
        <img height='50px' width='120px' title="<?php echo $nombreempresa; ?>" src='<?php echo base_url($rutalogo); ?>' />
    </div>
    <div class="grid_3">
        <!-- <a href=""> -->
            <h1>
                <?php 
                echo $nombreempresa;
                ?>
                
            </h1>
            <?php echo "NIT: ".$nitempresa." - ".$direccionempresa." - ".$telefonoempresa?>
		<!-- </a> -->
    </div>
    <div class="grid_1">
        <img height='50px' width='50px' src='<?php echo base_url("img/conductores/sin_imagen.jpg"); ?>' />
    </div>
    <div class="clear"></div>
</div>