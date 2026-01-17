$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
$(function() {
    $(window).bind("load resize", function() {
        //console.log($(this).width())
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    })
})

$(document).on("click", ".abrirAjax", function (event) {
	event.preventDefault();
	event.stopPropagation();
	var id = $(this).data('id');
	var url = $(this).data('url');
	var mod = $(this).data('mod');
	var sub = $(this).data('sub');
    // Limpiamos el html del div de la respuesta
    $("#respuesta").empty();
	// Enviamos el formulario usando AJAX
	$.ajax({
		type: "POST",
		//dataType: html,
		url: site_url+'/'+url,
		data: { idsubmoduloactual : sub, mod : mod },
		async: true,
		cache: false,
		beforeSend: function(){
			//bloqueamos el div
			$("#body").block({ 
				message: "Procesando, espere por favor...",
				css: { 
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff' 
				} 
			}); 
		}
	}).done(function (data) {
		$('#'+id).empty();
		$('#'+id).html(data);
		$("#body").unblock();
	}).fail(function (data) {
		$("#error").html("Disculpas, se ha presentado un Error, contacte a Soporte T&eacute;nico").show();
		$("#body").unblock();
	});
/*
	$.ajax({
		type: 'POST',
		url: site_url+'/'+url,
		data: { idsubmoduloactual : sub, mod : mod },
		cache:false,
		beforeSend: function(){
			//bloqueamos el div
			$("#body").block({ 
				message: "Procesando, espere por favor...",
				css: { 
					border: 'none', 
					padding: '15px', 
					backgroundColor: '#000', 
					'-webkit-border-radius': '10px', 
					'-moz-border-radius': '10px', 
					opacity: .5, 
					color: '#fff' 
				} 
			}); 
		},
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data) {
			console.log('#'+id);
			console.log(data);
			$('#'+id).empty();
			$('#'+id).html(data);
			$("#body").unblock();
		},
	  	error: function (request,error) {
	  		alert("A ocurrido un error " + error);
	  		$("#body").unblock();
	  	}			  	
	});
	*/
});

$(document).on("click", ".btnConsultar", function (event) {
	event.preventDefault()
	var id = $(this).data("divbusqueda");
	var titulo = $(this).data("titulo");
	$(id).removeData('bs.modal');
    $(id).modal({remote: $(this).data("url")});

    setTimeout(function() {
	    $("#myModalLabel").html(titulo);
    }, 200);
    
});
//$("#busqueda").modal({show: false});

