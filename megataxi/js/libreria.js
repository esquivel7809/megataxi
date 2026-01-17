function editar_destino(id){
	document.getElementById('id_indicativo_ant').value=document.getElementById('id_indicativo_ant'+id).value;
	document.getElementById('id_indicativo').value=document.getElementById('id_indicativo'+id).value;
	document.getElementById('destino').value=document.getElementById('destino'+id).value;
	document.getElementById('precio_costo').value=document.getElementById('precio_costo'+id).value;	
	
//	alert(document.getElementById('destino'+id).value);
	
	if(confirm('Desea realizar esta tarea ahora?')){
		document.getElementById('formDestino').submit();
	}
}

function MasMenos(div,botton){
	if(document.getElementById(div).style.display==''){
		recoger(div);
		document.getElementById(botton).innerHTML='Mas+';
	}else{
		desplegar(div);
		document.getElementById(botton).innerHTML='Ocultar-';
	}
}


function desplegar(id){
	Effect.BlindDown(id);
}

function recoger(id){
	Effect.BlindUp(id);
}



function activar_calendario(campo,img){
Calendar.setup({
              inputField    : campo,
              button        : img,
			  ifFormat       :    "%Y-%m-%d",
              align         : "Tr"
            });
}

function armar_url_busqueda_a(){
	var fecha_ini=document.getElementById('fecha_ini_txt').value;

	var hora_ini=document.getElementById('h_ini').options[document.getElementById('h_ini').selectedIndex].value;
	var min_ini=document.getElementById('m_ini').options[document.getElementById('m_ini').selectedIndex].value;
	var seg_ini=document.getElementById('s_ini').options[document.getElementById('s_ini').selectedIndex].value;

	var fecha_fin=document.getElementById('fecha_fin_txt').value;
	
	var hora_fin=document.getElementById('h_fin').options[document.getElementById('h_fin').selectedIndex].value;
	var min_fin=document.getElementById('m_fin').options[document.getElementById('m_fin').selectedIndex].value;
	var seg_fin=document.getElementById('s_fin').options[document.getElementById('s_fin').selectedIndex].value;	
	
	
	
	
		var url='&fecha_inicial='+fecha_ini+' '+hora_ini+':'+min_ini+':'+seg_ini+'&fecha_final='+fecha_fin+' '+hora_fin+':'+min_fin+':'+seg_fin+'&f_fecha=1';
	
	
	
	var indicativ=document.getElementById('indicativo').value;

		if(document.getElementById('otrosCampos').style.display==''){
				url+='&otrosCampos=1';	
				if(document.getElementById('indicativo').value!="")
					url+='&indicativo='+indicativ;
			var plan_d=0;
			if(document.getElementById('no_plan_d').selectedIndex){
				plan_d=document.getElementById('no_plan_d').options[document.getElementById('no_plan_d').selectedIndex].value;
				var distribuidor=0;
				if(document.getElementById('id_distribuidor').selectedIndex){
					distribuidor=document.getElementById('id_distribuidor').options[document.getElementById('id_distribuidor').selectedIndex].value;					
					var plan=0;		
					if(document.getElementById('no_plan').selectedIndex){
						plan=document.getElementById('no_plan').options[document.getElementById('no_plan').selectedIndex].value;
						var cliente=0;
						if(document.getElementById('id_cliente').selectedIndex){
							cliente=document.getElementById('id_cliente').options[document.getElementById('id_cliente').selectedIndex].value;		
							var cuent=0;
							if(document.getElementById('id_cuenta').selectedIndex){
								cuent=document.getElementById('id_cuenta').options[document.getElementById('id_cuenta').selectedIndex].value;								
								url+="&no_plan_d="+plan_d+"&id_distribuidor="+distribuidor+"&no_plan="+plan+"&id_cliente="+cliente+"&id_cuenta="+cuent+"&consulta=5";
							}else{
								url+="&no_plan_d="+plan_d+"&id_distribuidor="+distribuidor+"&no_plan="+plan+"&id_cliente="+cliente+"&consulta=4";
							}
						}else{
							url+="&no_plan_d="+plan_d+"&id_distribuidor="+distribuidor+"&no_plan="+plan+"&consulta=3";
						}
					}else{
						url+="&no_plan_d="+plan_d+"&id_distribuidor="+distribuidor+"&consulta=2";
					}
				}else{
					url+="&no_plan_d="+plan_d+"&consulta=1";	
				}
			}
		}
	document.getElementById('url_busqueda').value=url;
//	alert(url);
	
}


function armar_url_busqueda_r(){
	var fecha_ini=document.getElementById('fecha_ini_txt').value;

	var hora_ini=document.getElementById('h_ini').options[document.getElementById('h_ini').selectedIndex].value;
	var min_ini=document.getElementById('m_ini').options[document.getElementById('m_ini').selectedIndex].value;
	var seg_ini=document.getElementById('s_ini').options[document.getElementById('s_ini').selectedIndex].value;

	var fecha_fin=document.getElementById('fecha_fin_txt').value;
	
	var hora_fin=document.getElementById('h_fin').options[document.getElementById('h_fin').selectedIndex].value;
	var min_fin=document.getElementById('m_fin').options[document.getElementById('m_fin').selectedIndex].value;
	var seg_fin=document.getElementById('s_fin').options[document.getElementById('s_fin').selectedIndex].value;	
	
	
	
	
		var url='&fecha_inicial='+fecha_ini+' '+hora_ini+':'+min_ini+':'+seg_ini+'&fecha_final='+fecha_fin+' '+hora_fin+':'+min_fin+':'+seg_fin+'&f_fecha=1';
	
	
	
	var indicativ=document.getElementById('indicativo').value;

		if(document.getElementById('otrosCampos').style.display==''){
			url+='&otrosCampos=1';
			if(document.getElementById('indicativo').value!="")
				url+='&indicativo='+indicativ;

			var plan=0;
			if(document.getElementById('no_plan').selectedIndex){
				plan=document.getElementById('no_plan').options[document.getElementById('no_plan').selectedIndex].value;
				var cliente=0;
				if(document.getElementById('id_cliente').selectedIndex){
					cliente=document.getElementById('id_cliente').options[document.getElementById('id_cliente').selectedIndex].value;		
					var cuent=0;
					if(document.getElementById('id_cuenta').selectedIndex){
						cuent=document.getElementById('id_cuenta').options[document.getElementById('id_cuenta').selectedIndex].value;								
						url+="&no_plan="+plan+"&id_cliente="+cliente+"&id_cuenta="+cuent+"&consulta=4";
					}else{
						url+="&no_plan="+plan+"&id_cliente="+cliente+"&consulta=3";
					}
				}else{
					url+="&no_plan="+plan+"&consulta=2";
				}
			}
		}else{
			url+="&consulta=1";
		}
	
	
	

	document.getElementById('url_busqueda').value=url;
//	alert(url);
	
}


function armar_url_busqueda(){
	var fecha_ini=document.getElementById('fecha_ini_txt').value;

	var hora_ini=document.getElementById('h_ini').options[document.getElementById('h_ini').selectedIndex].value;
	var min_ini=document.getElementById('m_ini').options[document.getElementById('m_ini').selectedIndex].value;
	var seg_ini=document.getElementById('s_ini').options[document.getElementById('s_ini').selectedIndex].value;

	var fecha_fin=document.getElementById('fecha_fin_txt').value;
	
	var hora_fin=document.getElementById('h_fin').options[document.getElementById('h_fin').selectedIndex].value;
	var min_fin=document.getElementById('m_fin').options[document.getElementById('m_fin').selectedIndex].value;
	var seg_fin=document.getElementById('s_fin').options[document.getElementById('s_fin').selectedIndex].value;	
	
	
	
	
		var url='&fecha_inicial='+fecha_ini+' '+hora_ini+':'+min_ini+':'+seg_ini+'&fecha_final='+fecha_fin+' '+hora_fin+':'+min_fin+':'+seg_fin+'&f_fecha=1';
	
	
	
	var indicativ=document.getElementById('indicativo').value;
	var cuent=document.getElementById('cuenta').options[document.getElementById('cuenta').selectedIndex].value;
	var dura1=document.getElementById('duracion1').value;
	var dura2=document.getElementById('duracion2').value;	
	var val1=document.getElementById('valor1').value;
	var val2=document.getElementById('valor2').value;
	



	if(document.getElementById('otrosCampos').style.display==''){
		if(document.getElementById('indicativo').value!="")
			url+='&indicativo='+indicativ+'&f_indicativo=1';
		if(document.getElementById('duracion1').value!=""&&document.getElementById('duracion2').value!="")
			url+='&duracion1='+dura1+'&duracion2='+dura2+'&f_duracion=1';

		url+='&cuenta='+document.getElementById('cuenta').options[document.getElementById('cuenta').selectedIndex].value+'&f_cuenta=1';
		
		if(document.getElementById('valor1').value!=""&&document.getElementById('valor1').value!="")
			url+='&valor1='+val1+'&valor2='+val2+'&f_valor=1';			
	}
	
	
	

	document.getElementById('url_busqueda').value=url;
//	alert(url);
	
}



function enviar(form,txt){
//	var confirma;
	if(confirma=confirm('Esta seguro que desea continuar?')){
		document.getElementById(form).submit();
	}
//	return confirma;

}

function ver_div_edit(){
/*	document.getElementById('DivEdicion').style.display='none';
	Effect.toggle('EditBackground');
	setTimeout("desplegar('DivEdicion');",500);*/
	document.getElementById('acciones').innerHTML='';
	clearInterval(LastServices);
	clearInterval(LastClients);
	
//	document.getElementById('EditBackground').style.display='';	
	document.getElementById('DivEdicion').style.display='';	

		
}
function ver_div_edit_1(){
/*	document.getElementById('DivEdicion').style.display='none';
	Effect.toggle('EditBackground');
	setTimeout("desplegar('DivEdicion');",500);*/
	document.getElementById('acciones').innerHTML='';
	clearInterval(LastServices);
	clearInterval(LastClients);
	
//	document.getElementById('EditBackground').style.display='';	
	document.getElementById('DivEdicion_1').style.display='';	

		
}
function buscar_cli(){

	var sal=document.getElementById('saldo').value;
	var simbol=">";
	var s=document.getElementById('simbolo');
		if(sal!='')
			simbol=s.options[s.selectedIndex].value;
		else
			sal=0;
	
	abrir('client_list.php',' Mis Clientes','&palabra='+document.getElementById('palabra').value+'&saldo='+sal+'&simbolo='+simbol,'content');
}

function buscar_dist(){

	var sal=document.getElementById('saldo').value;
	var simbol=">";
	var s=document.getElementById('simbolo');
		if(sal!='')
			simbol=s.options[s.selectedIndex].value;
		else
			sal=0;
			
		if(document.getElementById('MasParametros').style.display!=''){
			document.getElementById('saldo').value=0;
			simbol=">";
		}
	
	abrir('resellers.php',' Mis Distribuidores','&palabra='+document.getElementById('palabra').value+'&saldo='+sal+'&simbolo='+simbol,'content');
}

function cerrar_edicion(){

	abrir('/megataxi/system/ultimos_servicios_pedidos.php','','','ultimos_servicios');
	
	LastServices=setInterval("abrir('/megataxi/system/ultimos_servicios_pedidos.php','','','ultimos_servicios');",2500);
	LastClients=setInterval("abrir('/megataxi/system/clientes_nuevos.php','','','ultimos_clientes');",3000);

document.getElementById('DivEdicion').style.display='none';
//document.getElementById('EditBackground').style.display='none';
/*
Effect.toggle('DivEdicion');
Effect.toggle('EditBackground');	*/
}

function accion(txt){
	document.getElementById('acciones').innerHTML=txt;
//	setTimeout("document.getElementById('acciones').innerHTML='';",5000);
}

function selAllCheckBox(id,subI1,cantidad){
	for(i=0;i<cantidad;i++){
		if(document.getElementById(id+subI1+i).checked==true)
			document.getElementById(id+subI1+i).checked=false;
		else
			document.getElementById(id+subI1+i).checked=true;
	}
}

function sincronizar(id,subI1,cantidad){
	var primero=0;
	var val=document.getElementById(id+subI1+primero).value;
		for(i=0;i<cantidad;i++){
			document.getElementById(id+subI1+i).value=val;
		}
}


function val_num(e) {
  tecla = (document.all) ? e.keyCode : e.which;
    if((tecla<48||tecla>57)&&(tecla!=13&&tecla!=46&&tecla!=0&&tecla!=8))
  	alert('unicamente se pueden escribir numeros la tecla que se digito es la'+tecla);
	return ((tecla>=48)&&(tecla<=57)||tecla==0||tecla==8||tecla==46);

}

//Enviar formulario sin confirmacion
function enviarSC(form){
	if(formulario=document.getElementById(form))
		formulario.submit();
	else
		alert('no existe el formulario a enviar');
}

//Accion a ejecutar cuando se presiona una tecla y se est� parado en algun campo u objeto del documento
function accion_objeto(e,campo,id){
    tecl = (document.all) ? e.keyCode : e.which; //alert(tecl);
	id=parseInt(id);
	if(tecl==13){
		var num=parseInt(document.getElementById('num_p_actual').value);
		console.log(num);
			if(campo.search('mega')!=-1){
				txtactual=campo.replace('mega','');
				txtactual=parseInt(txtactual);
				siguiente=txtactual+1;
//				alert(num);
				
				if(document.getElementById('mega'+txtactual+id).value!=''){
					if(!buscar_en_array(suspendidos,document.getElementById('mega'+txtactual+id).value)){
						if(buscar_en_array(NoSuspendidos,document.getElementById('mega'+txtactual+id).value)){
						
//							abrir('/megataxi/process/reporte_mega.process.php','','&mega='+document.getElementById('mega'+txtactual+id).value+'&servicio_id='+document.getElementById('servicio_id'+id).value,'DivProcess');

							document.getElementById('megaHidden'+txtactual+id).value=document.getElementById('mega'+txtactual+id).value;
	
							document.getElementById('RServicio_idTxt').value=document.getElementById('servicio_id'+id).value;
							document.getElementById('RMegaTxt').value=document.getElementById('mega'+txtactual+id).value;
							document.getElementById('ReporteForm').action='../process/reporte_mega.process.php';
							document.getElementById('ReporteForm').submit();
						
							if(document.getElementById('mega'+siguiente+id)){		
								document.getElementById('mega'+siguiente+id).focus();
							}else{
								//var num=parseInt(document.getElementById('num_p_actual').value);
								var nombre=document.getElementById('nombre_p_actual').value;
								if(nombre=='servicios'){
									document.getElementById('reporta'+num).focus();
								}
							}
						}else{
							alert("Vehiculo no registrado");
							document.getElementById(id).focus();
//							alert('El vehiculo '+document.getElementById('mega'+txtactual+id).value+' no se encuentra registrado en la base de datos');
						}
					}else{
						
						var posicionSuspendido=verifica_posicion(suspendidos,document.getElementById('mega'+txtactual+id).value);
						alert(causaSuspension[posicionSuspendido]);
						document.getElementById('mega'+txtactual+id).focus();
//						alert('El vehiculo '+document.getElementById('mega'+txtactual+id).value+' se encuentra suspendido, no puede realizar servicios');
					}
				}else if(document.getElementById('megaHidden'+txtactual+id).value!=''){

					
					document.getElementById('RServicio_idTxt').value=document.getElementById('servicio_id'+id).value;
					document.getElementById('RMegaTxt').value=document.getElementById('megaHidden'+txtactual+id).value;
					document.getElementById('ReporteForm').action='../process/retirar_reporte_mega.process.php';
					document.getElementById('ReporteForm').submit();
				
					
					
					
					if(document.getElementById('mega'+siguiente+id)){		
						document.getElementById('mega'+siguiente+id).focus();
					}else{
						//var num=parseInt(document.getElementById('num_p_actual').value);
						var nombre=document.getElementById('nombre_p_actual').value;
						if(nombre=='servicios'){
							document.getElementById('reporta'+num).focus();
						}
					}
					
				}
			}else if(campo.search('reporta')!=-1){ 
					//var num=parseInt(document.getElementById('num_p_actual').value);
					var nombre=document.getElementById('nombre_p_actual').value;
					var reportanum = document.getElementById('reporta'+num).value
				console.log(reportanum);
					if(!buscar_en_array(suspendidos,reportanum)){
						if(buscar_en_array(NoSuspendidos,reportanum)){
							if(nombre=='servicios'){
								
								if(reportanum != ''){
								//Se Confirma el servicio con el mega que report� la recogida.
								
									document.getElementById('RServicio_idTxt').value=document.getElementById('servicio_id'+id).value;
									document.getElementById('RMegaTxt').value=reportanum;
									document.getElementById('ReporteForm').action='../process/reporte_servicio.process.php';
									if(confirm("El mega "+document.getElementById('RMegaTxt').value+" ha realizado el servicio?")){
										document.getElementById('ReporteForm').submit();
									}
								}else{
								
							
									document.getElementById('reporta'+num).focus();
								}
							}					
						}else if(document.getElementById('reporta'+num).value!=''){
	//						alert('El vehiculo '+document.getElementById('reporta'+num).value+' No se encuentra en la base de datos');							
						}
					}else{
		//				alert('El vehiculo '+document.getElementById('reporta'+num).value+' se encuentra suspendido, no puede realizar servicios');
					}						
			}
	}else if(parseInt(e.keyCode)==37){
		if(campo.search('mega')!=-1){
			txtactual=campo.replace('mega','');
			txtactual=parseInt(txtactual);
			anterior=txtactual-1;
			
			if(document.getElementById('mega'+anterior+id)){		
				document.getElementById('mega'+anterior+id).select();
			}else{
				var num=parseInt(document.getElementById('num_p_actual').value);
				var nombre=document.getElementById('nombre_p_actual').value;
				if(nombre=='servicios'){
					document.getElementById('reporta'+num).select();
				}
			}
		}else if(campo.search('reporta')!=-1){
			var num=parseInt(document.getElementById('num_p_actual').value);
			document.getElementById('mega15'+num).select();
		}
	}else if(parseInt(e.keyCode)==39){
		if(campo.search('mega')!=-1){
			txtactual=campo.replace('mega','');
			txtactual=parseInt(txtactual);
			siguiente=txtactual+1;
			
			if(document.getElementById('mega'+siguiente+id)){		
				document.getElementById('mega'+siguiente+id).select();
			}else{
				var num=parseInt(document.getElementById('num_p_actual').value);
				var nombre=document.getElementById('nombre_p_actual').value;
				if(nombre=='servicios'){
					document.getElementById('reporta'+num).select();
				}
			}
		}
	}
}


function accion_objeto_blur(campo,num){ //alert(campo+" "+num);
	//console.log(campo+" "+num);
	document.getElementById('RServicio_idTxt').value=document.getElementById('servicio_id'+num).value;
	document.getElementById('RMegaTxt').value=document.getElementById(campo+num).value;

	if(campo.search('mega')!=-1){
		txtactual=campo.replace('mega','');
		txtactual=parseInt(txtactual);
		var id="mega"+txtactual+num;
		if(document.getElementById(id).value!=''){
			if(!buscar_en_array(suspendidos,document.getElementById(id).value)){
				if(buscar_en_array(NoSuspendidos,document.getElementById(id).value)){
			//		abrir('/megataxi/process/reporte_mega.process.php','','&mega='+document.getElementById(campo).value+'&servicio_id='+document.getElementById('servicio_id'+num).value,'DivProcess');	
					document.getElementById('ReporteForm').action='../process/reporte_mega.process.php';
					document.getElementById('ReporteForm').submit();
				}else{
					alert("Vehiculo no registrado");
					document.getElementById(id).focus();
				}
			}else{
			var posicionSuspendido=verifica_posicion(suspendidos,document.getElementById(id).value);
			alert(causaSuspension[posicionSuspendido]);
			document.getElementById(id).focus();
//						alert('El vehiculo '+document.getElementById('mega'+txtactual+id).value+' se encuentra suspendido, no puede realizar servicios');
		}
	}
	}else if(campo.search('reporta')!=-1){
	//	abrir('/megataxi/process/reporte_servicio.process.php','','&mega='+document.getElementById(campo).value+'&servicio_id='+document.getElementById('servicio_id'+num).value,'DivProcess');
		document.getElementById('ReporteForm').action='../process/reporte_servicio.process.php';
		document.getElementById('ReporteForm').submit();
	}
}

function listar_destinos(){
	if(document.getElementById('palabra').value!='')
		{
			abrir('/voip/forms/list_destinos.form.php',' Listado de destinos','&palabra='+document.getElementById('palabra').value,'destinos');
	}	
}

function seleccionar_fila(nombre,num){ //console.log(nombre+" "+num);
//	alert(num);
	document.getElementById('nombre_p_actual').value=nombre;
	document.getElementById('num_p_actual').value=num;

//	if(parseInt(num)==0||parseInt(num)==15){
// 		document.getElementById('panel_servicios').scrollTo(0,400);
//	}

	for(i=1;i<=5;i++){
		if(!verificar_contenido('mega'+i,num)){
			//alert("entro");
			break;
		}
	}

//	document.getElementById('mega1'+num).focus();
	var i=1;
	while(fila=document.getElementById(nombre+i)){
		fila.style.background='#ffffff';
		i++;
	}
	document.getElementById(nombre+num).style.background = '#eeeeee';
	
}


function remover_shortcuts(){
	
}

function onfocus_general(){
	
}

function buscar_en_array(array,palabra){
	var i;
	var encontro=false;
	for(i=0;i<array.length;i++){
		if(array[i]==palabra)
			encontro=true;
	}
	return encontro;
}

function verifica_posicion(array,palabra){
        var i;
        var encontro=false;
        for(i=0;i<array.length;i++){
                if(array[i]==palabra){
                        encontro=i;
			break;
		}
        }
        return encontro;

}


function caracter_pulsado(ElEvento){
	var evento = window.event || ElEvento;	
	alert("El caracter pulsado es: "+evento.keyCode );
}


function ponerDireccion(){
	

		var barrio=document.getElementById('barrio');
		var direccion=document.getElementById('direccion');
		var dirTxt='';
	
	
		var indiceBarrio=barrio.selectedIndex;
		indiceBarrio=parseInt(indiceBarrio);
		if(indiceBarrio==0){
			barrio.focus();
		}else{
			dirTxt=barrio.options[indiceBarrio].value+' ';
		}
	
		var i=0;
		var elemento,indice,valor;
		for(i=1;i<7;i++){
			elemento=document.getElementById('convencion'+i);
			indice=elemento.selectedIndex;
			indice=parseInt(indice);
			valor=document.getElementById('txtC'+i).value;
			if(indice!=0){
				dirTxt+=elemento.options[indice].value+' '+valor+' ';
			}
		}
	
		direccion.value=dirTxt;	
}

function buscar_direccion(objeto){
	var campo=document.getElementById(objeto);
	var valor=campo.value;
	if(valor.length>5){
		abrir('/megataxi/scripts_php/direccion.php','','&telefono='+valor,'direccionCliente');
	}
	
}

function nuevo_servicio(){
	abrir('/megataxi/forms/NuevoServicio.form.php','','','Edicion');
	setTimeout("document.getElementById('telManual').focus();",500);	
	ver_div_edit();

}

function nuevo_servicio_1(){
	abrir('/megataxi/forms/NuevoServicio.form.php','','','Edicion_1');
	setTimeout("document.getElementById('telManual').focus();",500);	
	ver_div_edit_1();

}

function nuevo_recordatorio(){
	abrir('/megataxi/forms/recordatorio.form.php','','&modo=add','Edicion');
	ver_div_edit();
	setTimeout("document.getElementById('telManual').focus();",500);	
}

function verificar_contenido(mega,id){ //console.log("verificar_contenido "+mega+" "+id);
	campo=mega;
	campoTxt=document.getElementById(mega+id);
	if(campo.search('mega')!=-1)
	{
		txtactual=campo.replace('mega','');
		txtactual=parseInt(txtactual);
		if(txtactual==5 && document.getElementById('mega'+txtactual+id).value!='')
		{
			document.getElementById('mega'+txtactual+id).focus();
			return false;
		}
		else
		{
			//if(document.getElementById('mega'+txtactual+id).value=='')
			if(document.getElementById('mega'+txtactual+id).value != null)
			{
				if(document.getElementById('mega'+txtactual+id).value==''){
					document.getElementById('mega'+txtactual+id).focus();
					return false;
				}else{
					return true;
				}
			}
			else
			{
				return true;
				/*
				siguiente=txtactual+1;
				if(!document.getElementById('mega'+siguiente+id))
				{
					var num=parseInt(document.getElementById('num_p_actual').value);
					var nombre=document.getElementById('nombre_p_actual').value;
					if(nombre=='servicios')
					{
						document.getElementById('reporta'+num).focus();
					}
					return false;
				}	
				//alert(txtactual);
				siguiente=txtactual+1;
				//if(campoTxt.value!=''){
				if(document.getElementById('mega'+siguiente+id)!='')
				{
					if(document.getElementById('mega'+siguiente+id))
					{
						document.getElementById('mega'+siguiente+id).focus();
						return false;
					}
					else
					{
						var num=parseInt(document.getElementById('num_p_actual').value);
						var nombre=document.getElementById('nombre_p_actual').value;
						if(nombre=='servicios')
						{
							document.getElementById('reporta'+num).focus();
						}
					}		
					return true;
				}
				else
				{
					return false;
				}*/
			}
		}
	}
}//Verificar el seleccionar filas en onfocus();


function suspension(modo){
	
	var i=0;
	var url="&modo="+modo;
	
	while(document.getElementById('vehiculoSel'+i)){
		if(document.getElementById('vehiculoSel'+i).checked)
			url+="&vehiculo[]="+document.getElementById('vehiculoSel'+i).value;
		i++;
	}
	if(i==0)
		return 0;
	else{
//		document.getElementById('suspenderVarios').action='/megataxi/process/vehiculo.process.php?'+url;
//		document.getElementById('suspenderVarios').submit();
		IFrameProcess.location.href='/megataxi/process/vehiculo.process.php?'+url;
	
//		abrir('/megataxi/process/vehiculo.process.php','',url,'IFrameProcess');
	}

//alert(url);
	
}


function SelCheckBox(nombre){
	var i=0;
	while(document.getElementById(nombre+i)){
		campo=document.getElementById(nombre+i);
		if(campo.checked==true)
			campo.checked=false;
		else
			campo.checked=true;

		i++;
		
	}
}

function sel_telefono(tel){
	if(document.getElementById('DivEdicion').style.display==''){
		document.getElementById('telManual').value=tel;
		buscar_direccion('telManual');
	}
}
