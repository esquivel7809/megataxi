<div class="titulo-modulo">Informe de conductores</div>
<div class="contenido-modulo contenido-informe border border-radius border-shadow">
    <form target="_blank" method="post" name="form_infoconductores" id="form_conductores" action="<?=site_url('informes/infoconductores/resultado')?>">
        <input type="hidden" name="idinfoconductor" id="idinfoconductor" value="<?php if(!empty($datoidconductor)) echo $datoidconductor?>" />
        <div class="form">
	        <h2 class="subtitulo-modulo"> Criterios de Selecci&oacute;n </h2>
	        <div id="filtros">
	            <?=$filtros?>
	        </div>
	        <h2 class="subtitulo-modulo"> Otros filtros </h2>
	        <div id="otrosfiltros">
	        	<ul>
	                <li><input type="checkbox" name="conductor" style="cursor:pointer;" checked="checked" />Conductor</li>
	                <li><input type="checkbox" name="propietario" style="cursor:pointer;" />Propietario</li>
	                <li><input type="checkbox" name="activo" style="cursor:pointer;" checked="checked" />Activo</li>
	            </ul>
	        </div>
	        <h2 class="subtitulo-modulo"> Tipos de Reporte </h2>
	        <div id="tiporeporte" class="botoneria">
	            <input type="submit" id="Html" name="Html" value="Pantalla" />
	            <?php /* ?><input type="submit" id="pdf" name="pdf" value="PDF" /> <?php */ ?>
	            <input type="submit" id="excel" name="excel" value="Excel" />
	        </div>
		</div>
    </form>
</div>