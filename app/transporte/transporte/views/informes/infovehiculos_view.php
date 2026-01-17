<script>
	$(document).on("click", ".propietarios", function () {
		$(".opcpropietarios").toggle();
	});
</script>
<div class="titulo-modulo">Informe de Vehiculos</div>
<div class="contenido-modulo contenido-informe border border-radius border-shadow">
    <form target="_blank" method="post" name="form_infovehiculos" id="form_infovehiculos" action="<?=site_url('informes/infovehiculos/resultado')?>">
        <input type="hidden" name="idinfovehiculo" id="idinfovehiculo" value="<?php if(!empty($datoidinfovehiculo)) echo $datoidinfovehiculo?>" />
        <h2 class="subtitulo-modulo"> Criterios de Selecci&oacute;n </h2>
        <div id="filtros">
            <?=$filtros?>
        </div>
        <h2 class="subtitulo-modulo"> Otros filtros </h2>
        <div id="otrosfiltros">
        	<ul>
                <li><input type="checkbox" name="asociado" style="cursor:pointer;" />Asociado</li>
                <li><input type="checkbox" name="rodamiento" style="cursor:pointer;" />Rodamiento</li>
                <li><input type="checkbox" name="comunicacion" style="cursor:pointer;" />Comunicaci&oacute;n</li>
                <li><input type="checkbox" name="activo" style="cursor:pointer;" checked="checked" />Vehiculos Activos</li>
                <li><input type="checkbox" name="propietarios" class="propietarios" style="cursor:pointer;" />Incluir Propietarios</li>
                <li class="opcpropietarios" style="display: none">
                	<ul>
                		<li><input type="radio" checked="checked" name="opcionpropietarios" style="cursor:pointer;" value="1" />Uno solo</li>
                		<li><input type="radio" name="opcionpropietarios" style="cursor:pointer;" value="2" />Todos</li>
                	</ul>
                </li>
                <li><input type="checkbox" name="tarjetaOperacion" style="cursor:pointer;" />Incluir Tarjeta de Operaci&oacute;n</li>
            </ul>
        </div>
        <h2 class="subtitulo-modulo"> Tipos de Reporte </h2>
        <div id="tiporeporte">
            <input type="submit" id="Html" name="Html" value="Html" />
            <?php /* ?><input type="submit" id="pdf" name="pdf" value="PDF" /> <?php */ ?>
            <input type="submit" id="excel" name="excel" value="Excel" />
        </div>
	</form>
</div>