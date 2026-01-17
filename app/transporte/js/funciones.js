/*
 *  written by Jorge Serrano
 *  http://www.jossof.com
 * 
 */
var tagScript = '(?:<script.*?>)((\n|\r|.)*?)(?:<\/script>)';
/**
* Eval script fragment
* @return String
*/
String.prototype.evalScript = function()
{
	return (this.match(new RegExp(tagScript, 'img')) || []).evalScript();
};
/**
* strip script fragment
* @return String
*/
String.prototype.stripScript = function()
{
        return this.replace(new RegExp(tagScript, 'img'), '');
};
/**
* extract script fragment
* @return String
*/
String.prototype.extractScript = function()
{
        var matchAll = new RegExp(tagScript, 'img');
        return (this.match(matchAll) || []);
};
/**
* Eval scripts
* @return String
*/
Array.prototype.evalScript = function(extracted)
{
                var s=this.map(function(sr){
                var sc=(sr.match(new RegExp(tagScript, 'im')) || ['', ''])[1];
                if(window.execScript){
                window.execScript(sc);
                }
                else
                {
                 window.setTimeout(sc,0);
                }
                });
                return true;
};
/**
* Map array elements
* @param {Function} fun
* @return Function
*/
Array.prototype.map = function(fun)
{
        if(typeof fun!=="function"){return false;}
        var i = 0, l = this.length;
        for(i=0;i<l;i++)
        {
                fun(this[i]);
        }
        return true;
};
$(document).ready(function($) {
	$('a[rel*=facebox]').facebox({
		loadingImage : '../../img/loading.gif',
		closeImage   : '../../img/closelabel.png'
	})
});
jQuery("a[rel*=facebox]").live("click",function(e){
	e.preventDefault();
	jQuery.facebox({ ajax: $(this).attr('href') });
});
 /**
*  Funcion que realiza lo necesario para abrir un archivo y enviarle las variables por Ajax
*  Capa = id del div en el cual se va a cargar la informacion
*  Archivo = nombre del archivo que va a procesar los datos
*  URL = Variable con los datos enviados "Variable1="+Variable1+"&variable2=contenido";
*/
function abrirAjax(capaAjax,Archivo,URL)
{ 
    // Limpiamos el html del div de la respuesta
    $("#respuesta").html(""); //alert(URL);
	// Enviamos el formulario usando AJAX
	$.ajaxSetup({ cache: false });
	$.ajax({
		type: 'POST',
		url: Archivo,
		data: URL,
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
			//$(capaAjax).html("<center><img id='cargando' src='../../img/transporte/ajax-loader.gif' style='border:none'></center>");
		},
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data) { //alert(capaAjax);
			//$('#cargando').hide();
			$(capaAjax).html("");
			//alert($CapaAjax.html());
			$(capaAjax).html(data);
			//alert($CapaAjax.html());
			$("#body").unblock() 
		}
	});
}
	/* Inicialización en español para la extensión 'UI date picker' para jQuery. */
    jQuery(function($){
    	$.datepicker.regional['es'] = {
    		closeText: 'Cerrar',
    		prevText: '&#x3c;Ant',
    		nextText: 'Sig&#x3e;',
    		currentText: 'Hoy',
    		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
    		dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
    		dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
    		dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
    		weekHeader: 'Sm',
    		dateFormat: 'dd/mm/yy',
    		firstDay: 1,
    		isRTL: false,
    		showMonthAfterYear: false,
    		yearSuffix: ''};
    	$.datepicker.setDefaults($.datepicker.regional['es']);
    });
function buscaRegistro(Archivo,URL,Alto,Ancho,Titulo,Id)
{ //alert(Id);
	//alert(document.getElementById(Id));
	$(Id).html("");
	$(Id).dialog({
		bgiframe: true,
		autoOpen: false,
		//closeOnEscape: false,
		height: Alto,  //alto
		width: Ancho,  //ancho
		resizable: false,
		title: Titulo,
		modal: true
		//close: function(event, ui) { alert("cerrado") },
		//beforeClose: function(event, ui) { alert("antes de cerrar") }
	});	
	$(Id).dialog('open').load(Archivo, {URL:URL}, function(response, status, xhr){})
}
function cambiar_estado(obj,Archivo)
{
	var id                 =   obj.id;
	var datos              =   id.split("-");
	var campo              =   datos[0];
	var idperfilusuario    =   datos[1];
	var idsubmodulo        =   datos[3];
	if($(obj).is(':checked'))
	   modi=1;
	else
	   modi=0;
	
    var URL="campo="+campo+
	        "&idperfilusuario="+idperfilusuario+
	        //"&idmodulo="+idmodulo+
	        "&idsubmodulo="+idsubmodulo+
	        "&modi="+modi;
	$Capa = $('#procesar');
	abrirAjax_obj($Capa,Archivo,URL,33);
}
function visualizarFiltro(criterio)
{
	if(document.getElementById(criterio+'_tr').style.display=="none")
		document.getElementById(criterio+'_tr').style.display="";
	else if(document.getElementById(criterio+'_tr').style.display=="")
		document.getElementById(criterio+'_tr').style.display="none";
}
//Funcion que...
function buscarDatos(capa,objform,objdestino,objorigen,Archivo,URL,e,idtabla)
{
	var bandentro=0;
    tecla = (document.all) ? e.keyCode : e.which;
	//alert(tecla);
	if(tecla==13)
	{
		if(document.getElementById(idtabla))
		{
			Tabla=document.getElementById(idtabla).getElementsByTagName('TR');
			if(Tabla.length==1)
			{
				eval(Tabla[0].title);
			}
			else
			{
				for(i=0;i<Tabla.length;i++)
				{
					if(Tabla[i].className=='trcapabusquedahover')
					{
						eval(Tabla[i].title);
						bandentro=1;
						break;
					}
				}
			}
		}
	}
	if(tecla==38 || tecla==40)
	{
		var j=0;
		if(document.getElementById(idtabla))
		{
			Tabla=document.getElementById(idtabla).getElementsByTagName('TR');
			for(i=0;i<Tabla.length;i++)
			{
				if(Tabla[i].className=='trcapabusquedahover')
				{
					Tabla[i].className='trcapabusqueda';
					if(tecla==38)
						j=i-1;
					else if(tecla==40)
						j=i+1;
					break;
				}
			}
			if(Tabla[j])
			{
				Tabla[j].className='trcapabusquedahover';
				document.getElementById(capa).scrollTop = document.getElementById(Tabla.item(j).id).offsetTop;
			}
		}
	}
	if((tecla<37 || tecla>40) && tecla!=13)
	{ 
		if(objorigen.value!="")
		{	//alert("entro");
			var CapaRetorno;
			CapaRetorno = document.getElementById(capa);
			CapaRetorno.style.display="";
			abrirAjax('#'+capa,Archivo,URL);
			CapaRetorno.style.borderBottom="4px";
			CapaRetorno.style.borderTop="2px";
			CapaRetorno.style.borderLeft="2px";
			CapaRetorno.style.borderRight="4px";
			CapaRetorno.style.borderStyle="outset";
			CapaRetorno.style.filter="alpha(opacity=94)";
		}
		else
		{
			//objdestino.value="";
			document.getElementById(capa).innerHTML=""; 
			document.getElementById(capa).style.display="none";
		}
	}
}
function desactivaEnter(e)
{
    tecla = (document.all) ? e.keyCode : e.which;
	if(tecla==13)
	{
		return false;
	}
}
function limpiarEstilo(idtabla,idtd)
{
	if(document.getElementById(idtabla))
	{
		Tabla=document.getElementById(idtabla).getElementsByTagName('TR');
		for(i=0;i<Tabla.length;i++)
		{
			Tabla[i].className='trcapabusqueda';
		}
		document.getElementById(idtd).className='trcapabusquedahover';
	}
}
//Funcio que crea el objeto Ajax
function crearajax()
{
	var xmlhttp=false;
	/** para Mozilla */
 	try 
	{
 		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
 	}
	catch (e) 
	{
		/** Si hay error se intenta para internet explorer*/
 		try 
		{
 			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
 		}
		catch (E) 
		{
 			xmlhttp = false;
 		}
  	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') 
	{
 		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
/**
*  Funcion que realiza lo necesario para abrir un archivo y enviarle las variables por Ajax
*  Capa = id del div en el cual se va a cargar la informacion
*  Archivo = nombre del archivo que va a procesar los datos
*  URL = Variable con los datos enviados "Variable1="+Variable1+"&variable2=contenido";
*/
function abrirAjax_obj(Capa,Archivo,URL,NumeroObjeto)
{
	nombreCapa=Capa;
	if(document.getElementById(Capa))
		Capa=document.getElementById(Capa);
	if(opener)
	{
		if(opener.document.getElementById(Capa))
			Capa=opener.document.getElementById(Capa);
	}
	if(parent)
	{
		if(parent.document.getElementById(Capa))
			Capa=parent.document.getElementById(Capa);
	}
	window['objetoAjax'+NumeroObjeto]= crearajax();
	window['objetoAjax'+NumeroObjeto].open("POST",Archivo,true);
	window['objetoAjax'+NumeroObjeto].onreadystatechange=function()
	{
		//alert(window['objetoAjax'+NumeroObjeto].readyState);
		if (window['objetoAjax'+NumeroObjeto].readyState==1)
		{
			Capa.innerHTML="<img src='"+URL_COMUN_PATH+"imagenes/cargando.gif' style='border:none'>Cargando...";
		}
		else if (window['objetoAjax'+NumeroObjeto].readyState==4 && window['objetoAjax'+NumeroObjeto].status!="200")
		{
			setTimeout("abrirAjax('"+nombreCapa+"','"+Archivo+"','"+URL+"','"+NumeroObjeto+"');",500);
		}
		else if (window['objetoAjax'+NumeroObjeto].readyState==4 && window['objetoAjax'+NumeroObjeto].status=="200")
		{
			//alert(window['objetoAjax'+NumeroObjeto].responseText);
			//alert(Capa.innerHTML);
			var scs=window['objetoAjax'+NumeroObjeto].responseText.extractScript();    //capturamos los scripts 
			Capa.innerHTML = window['objetoAjax'+NumeroObjeto].responseText;
			if(scs!="")
				scs.evalScript();       //ahora si, comenzamos a interpretar todo  
		}
	}
	window['objetoAjax'+NumeroObjeto].setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	window['objetoAjax'+NumeroObjeto].send(URL);
}
/**
*  Funcion que realiza lo necesario para calcular la edad
*  dia_nacim = dia de nacimiento (int)
*  mes_nacim = mes de nacimiento (int)
*  anio_nacim = año de nacimiento (int)
*  return = edad en años
*/
function calcular_edad(dia_nacim,mes_nacim,anio_nacim)
{
	fecha_hoy = new Date();
	ahora_anio = fecha_hoy.getYear();
	ahora_mes = fecha_hoy.getMonth();
	ahora_dia = fecha_hoy.getDate();
	edad = (ahora_anio + 1900) - anio_nacim;
	if ( ahora_mes < (mes_nacim - 1))
	{
	  edad--;
	}
	if (((mes_nacim - 1) == ahora_mes) && (ahora_dia < dia_nacim))
	{ 
	  edad--;
	}
	if (edad > 1900)
	{
		edad -= 1900;
	}
	return edad;
}
function guardar_refrendacion(id, obj, idform){
	if(id!=""){
		if(confirm("Esta Seguro Que Desea Refrendar")){
			//id = $(this).attr("id");
			$.ajax({
				url: base_url +'/conductores/refrendacion/registro.html',
				type: "POST",
				data: { id_puesto : id, Guardar : "Guardar" },
				dataType:"text",
				success: function(data_, textStatus, jqXHR ) {
					if(data_!=""){ 
						$('#'+obj.id).remove();
						campo = '<input type="hidden" name="idrefrendacion" value="'+data_+'"  /><input type="submit" id="imprimir_'+idform+'" name="imprimir_'+idform+'" value="Imprimir" />';
						$("#"+idform).append(campo);
						alert("Registro almacenado con exito");
					}else{
						alert("No se pudo almacenar el Registro");
					}
				}
			});
		}
	}else{
		alert("No se pudo almacenar el Registro");
	}
}
function compararFechas(fecha1, fecha2)
{ 
	var d1 = fecha1.substr(0,2);
	var m1 = fecha1.substr(3,2);
	var a1 = fecha1.substr(6,4);
	var fecha1=String(m1+"/"+d1+"/"+a1);
	
	var d2 = fecha2.substr(0,2);
	var m2 = fecha2.substr(3,2);
	var a2 = fecha2.substr(6,4);
	var fecha2=String(m2+"/"+d2+"/"+a2);
	if( (new Date(fecha1).getTime() > new Date(fecha2).getTime()))
	{
		return false;
	}
	return true;
}
function isDate(txtDate)
{
	var currVal = txtDate;
	if(currVal == '')
	return false;
	
	//Declare Regex  
	var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
	var dtArray = currVal.match(rxDatePattern); // is format OK?
	
	if (dtArray == null)
		return false;
	
	//Checks for mm/dd/yyyy format.
	//dtMonth = dtArray[1];
	//dtDay= dtArray[3];
	//dtYear = dtArray[5];
	
	//Checks for dd/mm/yyyy format.
    dtDay = dtArray[1];
    dtMonth= dtArray[3];
    dtYear = dtArray[5];   
/*
	fecha_hoy = new Date();
	ahora_anio = fecha_hoy.getFullYear();
	if (dtYear < 1900 || dtYear > (ahora_anio+3))
		return false;
*/
	if (dtYear < 1900)
		return false;
	else if (dtMonth < 1 || dtMonth > 12)
		return false;
	else if (dtDay < 1 || dtDay> 31)
		return false;
	else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
		return false;
	else if (dtMonth == 2)
	{
		var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
		if (dtDay> 29 || (dtDay ==29 && !isleap))
			return false;
	}
	return true;
}
function GetTodayDate(format) {
	format=((format=="")? 'dd/mm/aaaa' : format );
	var tdate = new Date();
	//var dd = ((tdate.getDate().length) === 1)? '0' +(tdate.getDate()) :  (tdate.getDate()); //yeilds day
	var dd = tdate.getDate();
	var dd = parseInt(dd);
	var dds = String(dd);
	var dd = (dds.length == 1)? '0' + dds : dds ; //yeilds month
	//var MM = ((tdate.getMonth().length+1) === 1)? '0' + (tdate.getMonth()+1) : (tdate.getMonth()+1); //yeilds month
	var MM = tdate.getMonth();
	var MM = parseInt(MM);
	var MM = MM + 1;
	var MMs = String(MM);
	var MM = (MMs.length == 1)? '0' + MMs : MMs ; //yeilds month
	var yyyy = tdate.getFullYear(); //yeilds year
	
	if(format =="dd/mm/aaaa"){
		var xxx = dd + "/" +( MM) + "/" + yyyy;
	}else if(format =="dd-mm-aaaa"){
		var xxx = dd + "-" +( MM) + "-" + yyyy;
	}
	
	return String(xxx);
}