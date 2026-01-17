<script type="text/javascript" src="<?=base_url()?>js/jquery.ajaxupload.js" ></script>
<script>
	$(document).ready(function(){
		$('#form_conductores').html5form({
			//responseDiv: '#contenido',
			messages: 'es',
			colorOn: '#6b6764',
			colorOff: '#b4b1af',
			allBrowsers: true,
			emailMessage: 'Dirección de correo inválida'
		});
		$('#fechanacimiento').mask("99/99/9999");
		
		$('#fechanacimiento').live('blur', function(){
			if($(this).val()!="" && $(this).val()!="__/__/____"){
				if(!isDate($(this).val())){
					alert('Fecha Invalida');
					$(this).focus().select();
					return false;
				}
			}
			if($(this).val()!=""){
				var fechaactual = GetTodayDate("dd/mm/aaaa");
				if(!compararFechas($(this).val(), fechaactual )){
					alert("la fecha de nacimiento no puede ser mayor a la fecha de actual");
					$('#fechanacimiento').focus().select();
					return false;
				}
			}
			var fecha = $(this).val();
			$("#edadempleado").val(calcular_edad(parseInt(fecha.substr(0,2)), parseInt(fecha.substr(3,2)),parseInt(fecha.substr(6,4))));
		});
    	/*Autocompletar para los lugares de expedicion y lugar de nacimiento*/
    	function formatlugarexpedicion(lugarexpedicion) {
    		return lugarexpedicion.nombremunicipio+ " - " +lugarexpedicion.nombredepartamento;
    	};
    
    	$("#lugarexpedicion,#lugarnacimiento").autocomplete("<?=site_url('conductores/data/consultarmunicipio')?>", {
    		dataType: "json",
    		parse: function(data) {
    			return $.map(data, function(row) {
    				return {
    					data: row,
    					value: row.nombremunicipio+ " - "+row.nombredepartamento,
    					result: row.nombremunicipio+ " - "+row.nombredepartamento
    				}
    			});
    		},
    		width: 500,
    		delay:200,
    		selectFirst: true,
    		scroll: true,
    		formatItem: function(item) {
    			return formatlugarexpedicion(item);
    		}
    	});
    	$("#lugarexpedicion").result(function(event, data, formatted) {
    		if (data)
    		{
    			$("#idlugarexpedicion").val(data.idmunicipio);
    		}
    	});
        
    	$("#lugarnacimiento").result(function(event, data, formatted) {
    		if (data)
    		{
    			$("#idlugarnacimiento").val(data.idmunicipio);
    		}
    	});
        
    	// se inicializa el calendario para la fecha de nacimiento
    	$('#fechanacimiento').datepicker({
    		changeMonth: true,
    		changeYear: true,
    		hideIfNoPrevNext : true,
    		showOn: 'button',
    		maxDate: '+0d',
    		buttonText: 'Fecha de Nacimiento',
    		buttonImage: '<?=base_url()?>img/cal.png',
    		buttonImageOnly: true,
			onClose: function( selectedDate ) {
				var currentDate_start = $(this).datepicker( "getDate" );
				$("#edadempleado").val(calcular_edad(parseInt(currentDate_start.getDate()), parseInt(currentDate_start.getMonth()+ 1),parseInt(currentDate_start.getFullYear())));
				}
    		});
            
        //$('#placa').mask('aaa999');
        $('#numerodocumento,#telefonofijo,#celular').numeric();
        $('#primernombre,#segundonombre,#primerapellido,#segundoapellido').alphanumeric({allow:" "});
        $('#direccion').alphanumeric({allow:" "});
        
        $("#lugarexpedicion").blur(function(){
            if($("#idlugarexpedicion").val()==''){
                $(this).attr('value','');
                }
        });
        
        $("#lugarnacimiento").blur(function(){
            if($("#idlugarnacimiento").val()==''){
                $(this).attr('value','');
                }
        });
        
        /** subir la imagen**/
    	try{
    		var button = $('#upload_button'), interval;
    		new AjaxUpload('#upload_button', {
    			action: '<?=site_url('conductores/data/subirfoto')?>',
    			data: {
    				idtipodocumento : $('#idtipodocumento').attr('value'),
    				numerodocumento : $('#numerodocumento').attr('value')
    			},
    			onSubmit : function(file , ext){
    				if (! (ext && /^(jpg|jpeg|gif|bmp|JPG|JPEG|GIF|BMP)$/.test(ext)))
    				{
    					// extensiones permitidas
    					alert('Error: Solo se permiten imagenes');
    					// cancela upload
    					return false;
    				} 
    			},
    			onComplete: function(file, response){
    				$('#fotoempleado').html(response);
    			}	
    		});
    	}
    	catch(e){}
        
        
	});
</script>
<?php echo $mensaje_confirmacion; ?>
  <div class="titulo-modulo">Registro de conductores</div>
  <div class="contenido-modulo border border-radius border-shadow">
    <form method="post" name="form_conductores" id="form_conductores" action="<?=site_url('conductores/conductores/registro')?>">
      <input type="hidden" name="idconductor" id="idconductor" value="<?php if(!empty($datoidconductor)) echo $datoidconductor?>" />
      <div class="form">
        <div>
          <label>Tipo de Documento :</label>
          <div class="wrapper-select-form">
            <select name="idtipodocumento" id="idtipodocumento" required="" title="Tipo de Documento" <?php if(!empty($disabled)) echo $disabled?>>
              <?=$tipodocumento?>
            </select>
          </div>
        </div>
        <div>
          <label>N&uacute;mero de Documento : </label>
          <input type="text" name="numerodocumento" id="numerodocumento" required="required" title="Numero Documento" placeholder="Digite Nº Documento" value="<?php if(!empty($datonumerodocumento)) echo $datonumerodocumento?>" <?php if(!empty($disabled)) echo $disabled?>/>
        </div>
        <div>
          <label>Lugar de Expedici&oacute;n : </label>
          <input type="hidden" name="idlugarexpedicion" id="idlugarexpedicion" required="required" value="<?php if(!empty($datoidlugarexpedicion)) echo $datoidlugarexpedicion?>" />
          <input type="text" name="lugarexpedicion" id="lugarexpedicion" required="required" title="Lugar de Expedicion" placeholder="Lugar de Expedicion" value="<?php if(!empty($datolugarexpedicion)) echo $datolugarexpedicion?>" />
        </div>
        <div>
          <label>Primer Nombre : </label>
          <input type="text" name="primernombre" id="primernombre" required="required" title="Primer Nombre" placeholder="Digite Primer Nombre" value="<?php if(!empty($datoprimernombre)) echo $datoprimernombre?>" />
        </div>
        <div>
          <label>Segundo Nombre : </label>
          <input type="text" name="segundonombre" id="segundonombre" title="Segundo Nombre" placeholder="Digite Segundo Nombre" value="<?php if(!empty($datosegundonombre)) echo $datosegundonombre?>" />
        </div>
        <div>
          <label>Primer Apellido : </label>
          <input type="text" name="primerapellido" id="primerapellido" required="required" title="Primer Apellido" placeholder="Digite Primer Apellido" value="<?php if(!empty($datoprimerapellido)) echo $datoprimerapellido?>" />
        </div>
        <div>
          <label>Segundo Apellido : </label>
          <input type="text" name="segundoapellido" id="segundoapellido" title="Segundo Apellido" placeholder="Digite Segundo Apellido" value="<?php if(!empty($datosegundoapellido)) echo $datosegundoapellido?>" />
        </div>
        <div>
          <label>Direcci&oacute;n : </label>
          <input type="text" name="direccion" id="direccion" required="required" title="Direccion" placeholder="Digite la Direccion" value="<?php if(!empty($datodireccion)) echo $datodireccion?>" />
        </div>
        <div>
          <label>Telefono Fijo : </label>
          <input type="text" name="telefonofijo" id="telefonofijo" title="Telefono fijo" placeholder="Digite Telefono fijo" value="<?php if(!empty($datotelefonofijo)) echo $datotelefonofijo?>" />
        </div>
        <div>
          <label>E-Mail : </label>
          <input type="text" name="email" id="email" title="E-Mail" placeholder="Digite E-Mail" value="<?php if(!empty($datoemail)) echo $datoemail?>" />
        </div>
        <div>
          <label>Celular : </label>
          <input type="text" name="celular" id="celular" required="required" title="Celular" placeholder="Digite Celular" value="<?php if(!empty($datocelular)) echo $datocelular?>" />
        </div>
        <div>
          <label>Fecha de Nac. : </label>
          <input type="text" name="fechanacimiento" id="fechanacimiento" maxlength="10" title="Digite la fecha de nacimiento" placeholder="Digite Fecha Nacimiento" required="" value="<?php if(!empty($datofechanacimiento)) echo $datofechanacimiento?>" />
        </div>
        <div>
          <label>Edad (años) : </label>
          <input name="edadempleado" class="required" type="text" id="edadempleado" readonly="readonly" value="<?php echo $datoedad; ?>" <?php echo $DeshabilitarCampos;?> />
        </div>
        <div>
          <label>Lugar de Nac. : </label>
          <input type="hidden" name="idlugarnacimiento" id="idlugarnacimiento" required="required" value="<?php if(!empty($datoidlugarnacimiento)) echo $datoidlugarnacimiento?>" />
          <input type="text" name="lugarnacimiento" id="lugarnacimiento" required="required" title="Lugar de Nacimiento" placeholder="Lugar de Nacimiento" value="<?php if(!empty($datolugarnacimiento)) echo $datolugarnacimiento?>" />
        </div>
        <div>
          <label>G&eacute;nero :</label>
          <div class="wrapper-select-form">
            <select name="idgenero" id="idgenero" class="required">
              <?=$genero?>
            </select>
          </div>
        </div>
        <div>
          <label>Grupo Sanguineo :</label>
          <div class="wrapper-select-form">
            <select name="idgruposanguineo" id="idgruposanguineo" class="required">
              <?=$gruposanguineo?>
            </select>
          </div>
        </div>
        <div class="checkbox-section">
          <label>Conductor :</label>
          <input type="checkbox" name="conductor" <?php if(!empty($datoconductor)) echo $datoconductor?> />
        </div>
        <div class="checkbox-section">
          <label>Propietario :</label>
          <input type="checkbox" name="propietario" <?php if(!empty($datopropietario)) echo $datopropietario?> />
        </div>
        <div class="checkbox-section">
          <label>Activo :</label>
          <input type="checkbox" name="activo" <?php if(!empty($datoactivo)) echo $datoactivo?> />
        </div>
        <div class="botoneria"> <?php echo $botoneria; ?> </div>
      </div>
      <div class="foto-cond" id="fotoempleado" >
        <?=$datorutafoto?>
      </div>
    </form>
  </div>

