<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function(){
	$('#example1, #example3').accordion({
		canToggle: true,
		canOpenMultiple: true
	});
	$('#example2').accordion({
		canToggle: true
	});
	$('#example4').accordion({
		canToggle: true,
		canOpenMultiple: true
	});
	$(".loading").removeClass("loading");
});
</script>

<style>
.lateral {
	width: 230px;
	background-color: #ADDCAE;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	/*behavior: url(ie-css3.htc);*/
	padding-bottom: 6px;
	float: left;
	margin-top: 10px;
}
</style>
<div class="grid_3">
    <div class="lateral">
        <ul id="example3" class="accordion">
            <li class="locked">
                <h3>Panel de control</h3>
                <div class="panel loading">
                    <h4>Editar cuenta</h4>
                    <p>Modulo para editar la cuenta del usuario</p>
                </div>
            </li>
            <li class="active">
                <h3>Vencimientos SOAT</h3>
                <div class="panel loading">
                    <h4>a <?php echo date("d-m-Y")?></h4>
                    <ul class="panel loading">
                        <li>Vehiculo 1</li>
                        <li>Vehiculo 2</li>
                        <li>Vehiculo 3</li>
                    </ul>
                </div>
            </li>
            <li class="active">
                <h3>Venc. Tecnico-Mecanica</h3>
                <div class="panel loading">
                    <h4>a <?php echo date("d-m-Y")?></h4>
                    <ul class="panel loading">
                        <li>Vehiculo 1</li>
                        <li>Vehiculo 2</li>
                        <li>Vehiculo 3</li>
                    </ul>
                </div>
            </li>
            <li class="active">
                <h3>Venc. Licencia de Conducc&oacute;n</h3>
                <div class="panel loading">
                    <h4>a <?php echo date("d-m-Y")?></h4>
                    <ul class="panel loading">
                        <li>Vehiculo 1</li>
                        <li>Vehiculo 2</li>
                        <li>Vehiculo 3</li>
                    </ul>
                </div>
            </li>
        </ul>
	</div>
</div>
<div class="grid_9">
    <div id="contenido" >
    </div>
</div>
<div id="respuesta" class="grid_12"></div>
<div class="clear"></div>