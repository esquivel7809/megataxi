/*
$(document).keypress(function(e));
$(document).keydown(function(e));
$(document).keyup(function(e));
Flecha de arriba	38
Flecha derecha	39
Flecha de abajo	40
*/

$(document).ready(function(){
	//cargamos el localstorage
    var params = 	[	
    	{
	        //url: config.ajax.pathSufix + '/medica/medico/GetAll/'+atenea.sfa.parametros.user.id, 
	        url: 'vehiculos/getSuspendidos',
	        KeyIDPattern: "Suspendidos", 
	        FilterPattern: /Suspendidos/, 
	        FilterMember: "", 
	        FilterValue: "", 
	        //object: $("#selContacto")
	        object: ""
        },
        {
	        url: 'vehiculos/getNoSuspendidos',
	        KeyIDPattern: "NoSuspendidos", 
	        FilterPattern: /NoSuspendidos/, 
	        FilterMember: "", 
	        FilterValue: "", 
	        //object: $("#selContacto")
	        object: ""
        },

/*
        {
        url: config.ajax.pathSufix + '/picklist/GetTiposVisita', 
        KeyIDPattern: "TiposVisita", 
        FilterPattern: /TiposVisita/, 
        FilterMember: '', 
        FilterValue: '', 
        object: atenea.sfa.api.medica.actividad.loadAsuntos
        },		
*/						
    ];
	
    domStorage.storeMode(params);
	
	// pone le foco en el primer textbox de los megas
	$(".pos-1-1").focus();
	
	$(document).keypress(function(e) { //alert(e.which);
		//13 es el código de la tecla
		/*if(e.which == 13) {
			alert('Has pulsado enter!');
		}*/
	});
	
	//cuando se esta en el text de mega
	$(".input-mega").keyup(function(e) {
		var posy =  $(this).data('posy');
		var posx =  $(this).data('posx');

		//Flecha izquierda	37
		if(e.which == 37) {
			if(posx==1){
				return false
			}else{
				$(".pos-"+posy+"-"+(posx-1)).focus().select();
			}
		}
		//Flecha derecha	39
		if(e.which == 39 || e.which == 13) {
			if(posx==5){
				return false
			}else{
				$(".pos-"+posy+"-"+(posx+1)).focus().select();
			}
		}
		//Flecha de abajo	40
		if(e.which == 40) {
			if(posy==5){
				return false
			}else{
				$(".pos-"+(posy+1)+"-"+(posx)).focus().select();
			}
		}
		//Flecha de arriba	38
		if(e.which == 38) {
			if(posy==1){
				return false
			}else{
				$(".pos-"+(posy-1)+"-"+(posx)).focus().select();
			}
		}
		// Ctrl-Enter pressed
		if (e.ctrlKey && e.keyCode == 13) {
			$(".pos-reporta-"+posy).focus().select();
		}

	});
	
	//cuando se esta en el text de reporta
	$(".input-reporta").keyup(function(e) {
		//Flecha izquierda	37
		if(e.which == 37) {
			var posy =  $(this).data('posy');
			$(".pos-"+posy+"-5").focus();
		}
	});
	
	//cuando se pasa a otro text
	$(".input-mega").blur(function(e) {
		var mega =  $(this).attr('mega');
		var val =  $(this).val();
		console.log(mega+" "+val);
		//si esta vacio no se hace nada
		if(val == mega){ return false }
		//si el valor digitado es diferente de vacio y es diferente del atributo data-mega, se procede a guardar
		else if((val != "") && (val != mega)){
			//consultamos si el mega esta dentro de los NO suspendidos
			var data = domStorage.storeGetFilterItem("NoSuspendidos", "placa", mega);
			if (data.length > 0) {
				$(this).attr('mega', val);
				//console.log("guardado");
			}else{
				alert("Mega no valido...");
				$(this).focus().select();
			}
		}else if(val == "" && (mega !="")){
			$(this).attr('mega', "");
			//console.log("actualizado a vacio");
		}
		
		
	});
		
	
	
});