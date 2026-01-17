<script>
</script>
<div class="titulo-modulo">Imprimir Formato de Renovaci&oacute;n de Tarjeta de Operaci&oacute;n</div>
<div class="contenido-modulo contenido-informe border border-radius border-shadow">
    <form target="_blank" method="post" name="form_renotarope" id="form_renotarope" action="<?=site_url('imprimir/renotarope/index')?>">
        <h2 class="subtitulo-modulo"> Criterios de Selecci&oacute;n </h2>
        <div id="filtros">
            <?=$filtros?>
        </div>
        <h2 class="subtitulo-modulo"> Otros filtros </h2>
        <div id="otrosfiltros">
        	<ul>
                <li style="width:200px;"><input type="checkbox" name="todos" style="cursor:pointer;" />Todos los vehiculos</li>
            </ul>
        </div>
        <div class="form">
            <!-- 
            <div>

                <label>Placa:</label>
                <input type="hidden" name="idrenotarope" id="idrenotarope" value="<?php if(!empty($datoidrenotarope)) echo $datoidrenotarope?>" />
                <input type="text" name="tarjeton" id="tarjeton" required="required" title="Conductor" placeholder="Digite tarjeta, cedula o placa" value="<?php if(!empty($datonombreconductor)) echo $datonombreconductor?>"/>
            </div>
            <div>

                <label>Placa:</label>
                <input type="text" name="placa" id="placa" class="placa ac_input" required="required" title="Placa" placeholder="Placa" value="" autocomplete="off" readonly="readonly">
            </div>
            -->
            <div class="botoneria">
                <?php echo $botoneria; ?>
            </div>
        </div>
    </form>
</div>