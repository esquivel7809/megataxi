// JavaScript Document

function getXMLHTTPRequest()
{
var req = false;
try
  {
    req = new XMLHttpRequest(); /* p.e. Firefox */
  }
catch(err1)
  {
  try
    {
     req = new ActiveXObject("Msxml2.XMLHTTP");
  /* algunas versiones IE */
    }
  catch(err2)
    {
    try
      {
       req = new ActiveXObject("Microsoft.XMLHTTP");
  /* algunas versiones IE */
      }
      catch(err3)
        {
         req = false;
        }
    } 
  }
return req;
}

var miPeticion = getXMLHTTPRequest();

function abrir(page,titulo,otros,div) {
	
if(titulo!='')
	document.title='Jossof '+titulo;
	
var miAleatorio=parseInt(Math.random()*99999999);
var url = page+"?aleatorio="+miAleatorio+otros;
miPeticion.open("GET", url, true);
miPeticion.onreadystatechange = function (){respuestaAjax(div)};
miPeticion.send(" ");
}



function respuestaAjax(div) {
//	document.getElementById('esperando').innerHTML ='';
	
if(miPeticion.readyState == 4) {
if(miPeticion.status == 200) { console.log(miPeticion.responseText);
	if(miPeticion.responseText==""){
			miPeticion.responseText=".";
		}
        document.getElementById(div).innerHTML = miPeticion.responseText;
        } else {
		//alert("Ha ocurrido un error: " + miPeticion.statusText + " div "+div);
        }
    } else {     // si readyState ha cambiado
                 // pero readyState <> 4
  //         document.getElementById('esperando').innerHTML = 'Cargando .........';
    }

}
