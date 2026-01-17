// Cargo los ID's de los arrays que se convierten en "scrollables"
var scrollDivs=new Array();
scrollDivs[0]="DivEdicion";

function carga()
{
	posicion=0; elMovimiento=null;
	
	// IE
	if(navigator.userAgent.indexOf("MSIE")>=0) navegador=0;
	// Otros
	else navegador=1;
}

function evitaEventos(event)
{
	// Funcion que evita que se ejecuten eventos adicionales
	if(navegador==0)
	{
		window.event.cancelBubble=true;
		window.event.returnValue=false;
	}
	if(navegador==1) event.preventDefault();
}

function comienzoMovimiento(event, id)
{
	elMovimiento=document.getElementById(id);
	
	/* Si el elemento que se le hizo click es texto (nodeType=3) se toma como target
	el elemento padre */
	if(elMovimiento.nodeType==3) elMovimiento=elMovimiento.parentNode;
	
	 // Obtengo la posicion del cursor
	if(navegador==0)
	 {
	 	cursorComienzoX=window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;
		cursorComienzoY=window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;

		document.attachEvent("onmousemove", enMovimiento);
		document.attachEvent("onmouseup", finMovimiento);
	}
	if(navegador==1)
	{    
		cursorComienzoX=event.clientX+window.scrollX;
		cursorComienzoY=event.clientY+window.scrollY;
		
		document.addEventListener("mousemove", enMovimiento, true); 
		document.addEventListener("mouseup", finMovimiento, true);
	}
	
	elComienzoX=parseInt(elMovimiento.style.left);
	elComienzoY=parseInt(elMovimiento.style.top);
	// Actualizo el posicion del elemento
	elMovimiento.style.zIndex=++posicion;
	
	evitaEventos(event);
}

function enMovimiento(event)
{  
	var xActual, yActual;
	if(navegador==0)
	{    
		xActual=window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;
		yActual=window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;
	}  
	if(navegador==1)
	{
		xActual=event.clientX+window.scrollX;
		yActual=event.clientY+window.scrollY;
	}
	
	elMovimiento.style.left=(elComienzoX+xActual-cursorComienzoX)+"px";
	elMovimiento.style.top=(elComienzoY+yActual-cursorComienzoY)+"px";

	evitaEventos(event);
}

function finMovimiento(event)
{
	if(navegador==0)
	{    
		document.detachEvent("onmousemove", enMovimiento);
		document.detachEvent("onmouseup", finMovimiento);
	}
	if(navegador==1)
	{
		document.removeEventListener("mousemove", enMovimiento, true);
		document.removeEventListener("mouseup", finMovimiento, true); 
	}
}
