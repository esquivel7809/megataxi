<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function ponerDireccion(){
	
	var barrio=document.getElementById('barrio');
	var direccion=document.getElementById('direccion');
	var dirTxt;
	
	
	var indiceBarrio=barrio.selectedIndex;
	indiceBarrio=parseInt(indiceBarrio);
	if(indiceBarrio==0){
		barrio.focus();
		exit();
	}else{
		dirTxt=barrio.options[indiceBarrio].value+' ';
	}
	
	var i=0;
	var elemento,indice,valor;
	for(i=1;i<7;i++){
		elemento=document.getElementById('txtC'+i);
		indice=elemento.selectedIndex;
		indice=parseInt(indice);
		valor=document.getElementById('txtC'+i).value;
		if(indice!=0){
			dirTxt+=elemento.options[indice].value+' '+valor+' ';
		}
	}
	
	direccion.value=dirTxt;	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
Mi pagina web
<iframe src="http://www.fosyga.gov.co"></iframe>
<iframe src="http://www.google.com.co"></iframe>
<iframe src="http://www.fcosystems.com"></iframe>


</body>
</html>
