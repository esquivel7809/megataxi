<script type="text/javascript">
$(document).ready(function(){
	$('#example3').accordion({
		canToggle: true,
		canOpenMultiple: true
	});
	$(".loading").removeClass("loading");
});
</script>
<div class="grid_4">
    <div class="lateral">
        <ul id="example3" class="accordion">
            <li class="locked">
                <h3>Panel de control</h3>
                <div class="panel loading">
                    <h4>Editar cuenta</h4>
                    <p>Modulo para editar la cuenta del usuario</p>
                </div>
            </li>
            <?php echo $html_venc_soat; ?>
            <?php echo $html_venc_revision; ?>
            <?php echo $html_venc_licencia; ?>
        </ul>
	</div>
</div>