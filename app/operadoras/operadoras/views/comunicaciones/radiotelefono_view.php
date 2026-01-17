<script>
$(document).ready(function(){
		$('#form_radiotelefonos').html5form({
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
	/*Autocompletar para los modelos de radiotelefonos*/
	function formatmodeloradio(modeloradio) {
		return modeloradio.nombremarcaradio+ " " + modeloradio.nombremodeloradio;
	};

	$("#nombremodeloradio").autocomplete("<?=site_url('comunicaciones/data/consultarmodeloradio/')?>", { 
		dataType: "json",
		parse: function(data) {
			return $.map(data, function(row) {
				return {
					data: row,
					value: row.idmodeloradio,
					result: row.idmodeloradio
				}
			});
		},
		width: 500,
		delay:200,
		selectFirst: true,
		scroll: true,
		formatItem: function(item) {
			return formatmodeloradio(item);
		}
	});
	$("#nombremodeloradio").result(function(event, data, formatted) {
		if (data)
		{
            $("#idmodeloradio").val(data.idmodeloradio);		  
            $("#nombremodeloradio").val(data.nombremarcaradio+" "+data.nombremodeloradio);
		}
	});

});
</script>
<div>
    <?php echo $mensaje_confirmacion; ?>
    <div class="titulo-modulo">Registro de radiotelefonos</div>
    <div class="contenido-modulo border border-radius border-shadow">
        <form method="post" name="form_radiotelefonos" id="form_radiotelefonos" action="<?=site_url('comunicaciones/radiotelefono/registro')?>">
            <input type="hidden" name="idradiotelefono" id="idradiotelefono" value="<?php if(!empty($datoidradiotelefono)) echo $datoidradiotelefono?>" />
            <div class="form">
                <div>
                    <label>Modelo : </label>
                    <input type="hidden" name="idmodeloradio" id="idmodeloradio" value="<?php if(!empty($datoidmodeloradio)) echo $datoidmodeloradio?>" />
                    <input type="text" name="nombremodeloradio" id="nombremodeloradio" required="required" title="Digite Modelo Radio" placeholder="Digite Modelo Radio" value="<?php if(!empty($datonombremodeloradio)) echo $datonombremodeloradio?>" size="40" />
                </div>
                <div>
                    <label>Serie : </label>
                    <input type="text" name="serieradiotelefono" id="serieradiotelefono" required="required" title="Serie" placeholder="Serie" value="<?php if(!empty($datoserieradiotelefono)) echo $datoserieradiotelefono?>" />
                </div>
                <div class="checkbox-section">
                    <label>Activo :</label>
					<input type="checkbox" name="activo" <?php if(!empty($datoactivo)) echo $datoactivo?> />
                </div>
                <div class="botoneria">
                    <?php echo $botoneria; ?>
                </div>
            </div>
        </form>
    </div>
</div>