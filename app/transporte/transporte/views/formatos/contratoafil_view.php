<script>
</script>
<div class="titulo-modulo">Imprimir Formato de Contrato de Afiliciaci&oacute;n</div>
<div class="contenido-modulo contenido-informe border border-radius border-shadow">
    <form target="_blank" method="post" name="form_renotarope" id="form_renotarope" action="<?=site_url('imprimir/contratoafil/index')?>">
        <h2 class="subtitulo-modulo"> Criterios de Selecci&oacute;n </h2>
        <div id="filtros">
            <?=$filtros?>
        </div>
        <h2 class="subtitulo-modulo"> Otros filtros </h2>
        <div id="otrosfiltros">
        	<ul>
                <li style="width:200px;"><input type="checkbox" name="todos" style="cursor:pointer;" />Todos los Propietarios</li>
            </ul>
        </div>
        <div class="form">
            <div class="botoneria">
                <?php echo $botoneria; ?>
            </div>
        </div>
    </form>
</div>