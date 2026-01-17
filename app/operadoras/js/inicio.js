$(document).ready(function()
{
	$("#username").focus();
});

function redireccionar()
{
	window.location.href = site_url + '/servicios'; 
}
function enter(e)
{ 
	tecla = (document.all) ? e.keyCode : e.which;
	if(tecla==13)
	{
		$("#ingresar").click();
	}
	else
	{
		return false;
	}
}

//function validarForm()
$(document).on("submit", "#form_login", function (event) {
	event.preventDefault();
	event.stopPropagation();

	if($("#username").val()=="")
	{
		alert("Debe Digitar el Nombre de Usuario");
		$("#username").focus();
		return false;
	}
	else if($("#password").val()=="")
	{
		alert("Debe Digitar la Contraseña");
		$("#password").focus();
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			//dataType: json,
			url: site_url + "/validacion/validarusuario",
			data: $(this).serialize(),
			async: true,
			cache: false
		}).done(function (data) {
			if(data == 'yes'){ 
				$('#login_response').removeClass("alert-danger").addClass("alert alert-success").html("Entrada exitosa").show();
				setTimeout(function() {
					redireccionar();
				    }, 1000);

			}else{
				$('#username').val("").focus();
				$('#password').val("");
				$('#login_response').addClass("alert alert-danger").html(data).show();
				setTimeout(function() {
					$('#login_response').fadeToggle(1000);
				    }, 2000);

			}
		}).fail(function (data) {
			$("#error").html("Disculpas, se ha presentado un Error, contacte a Soporte T&eacute;nico").show();
		});
	}
});
