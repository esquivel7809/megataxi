// JavaScript Document
shortcut.remove("Ctrl+S");
shortcut.add("Ctrl+S",function() {
	seleccionar_fila('servicios','0');

//alert("Hi there!");
});

shortcut.add("Up",function() { //alert("entro");
	var num=parseInt(document.getElementById('num_p_actual').value); //alert(num);
	var nombre=document.getElementById('nombre_p_actual').value; //alert(num+" "+nombre);
	if(num>1){
		num--;
		seleccionar_fila(nombre,num);
	}
					 
	
});

shortcut.add("Ctrl+Enter",function() {
	var num=parseInt(document.getElementById('num_p_actual').value);
	var nombre=document.getElementById('nombre_p_actual').value;
	if(nombre=='servicios')
		document.getElementById('reporta'+num).focus();
},{

	'type':'keydown',
	'propagate':true,
	'disable_in_input':false,
	'target':document
});

shortcut.add("Enter",function() {
	var num=parseInt(document.getElementById('num_p_actual').value);
	var nombre=document.getElementById('nombre_p_actual').value;

	if(nombre=='servicios'){
		document.getElementById('mega1'+num).focus();
	}else{
		seleccionar_fila('servicios','10');
	}
		
},{

	'type':'keypress',
	'propagate':true,
	'disable_in_input':true,
	'target':document
});


shortcut.add("Down",function() {
	var num=parseInt(document.getElementById('num_p_actual').value);
	var nombre=document.getElementById('nombre_p_actual').value;
	num++;
	
	if(document.getElementById(nombre+num)){
		//alert(nombre+num);
		seleccionar_fila(nombre,num);
	}
});

shortcut.add("Alt+N",function() {
	abrir('/megataxi/forms/NuevoServicio.form.php','','','Edicion');
	ver_div_edit();
	setTimeout("document.getElementById('telManual').focus();",500);
});

shortcut.add("Alt+R",function() {
	abrir('/megataxi/forms/recordatorio.form.php','','&modo=add','Edicion');
	ver_div_edit();
	setTimeout("document.getElementById('telManual').focus();",500);
});


//Remove the shortcut
function quitar_shortcuts_default(e) {
  tecla = (document.all) ? e.keyCode : e.which;
//  return (tecla);
}

shortcut.add("Alt+C",function() {
	var num=parseInt(document.getElementById('num_p_actual').value);
	var nombre=document.getElementById('nombre_p_actual').value;
	enviar('CancelaServicio'+num);
});

shortcut.add("Esc",function() {
	cerrar_edicion();
});

shortcut.add("Alt+1",function() {
//	alert("Si funciona con los numeros 1");
	var telefono=document.getElementById('telefono_actual1').value;
	sel_telefono(telefono);
});

shortcut.add("Alt+2",function() {
//	alert("Si funciona con los numeros 2");
	var telefono=document.getElementById('telefono_actual2').value;
	sel_telefono(telefono);
});

shortcut.add("Alt+3",function() {
//	alert("Si funciona con los numeros 3");
	var telefono=document.getElementById('telefono_actual3').value;
	sel_telefono(telefono);
});

shortcut.add("Alt+4",function() {
//	alert("Si funciona con los numeros 4");
	var telefono=document.getElementById('telefono_actual4').value;
	sel_telefono(telefono);
});

shortcut.add("Alt+5",function() {
//	alert("Si funciona con los numeros 5");
	var telefono=document.getElementById('telefono_actual5').value;
	sel_telefono(telefono);
});

shortcut.add("Alt+6",function() {
//	alert("Si funciona con los numeros 6");
	var telefono=document.getElementById('telefono_actual6').value;
	sel_telefono(telefono);
});

shortcut.add("Alt+7",function() {
//	alert("Si funciona con los numeros 7");
	var telefono=document.getElementById('telefono_actual7').value;
	sel_telefono(telefono);
});

shortcut.add("Alt+8",function() {
//	alert("Si funciona con los numeros 8");
	var telefono=document.getElementById('telefono_actual8').value;
	sel_telefono(telefono);
});

shortcut.add("Alt+9",function() {
//	alert("Si funciona con los numeros 9");
	var telefono=document.getElementById('telefono_actual9').value;
	sel_telefono(telefono);
});