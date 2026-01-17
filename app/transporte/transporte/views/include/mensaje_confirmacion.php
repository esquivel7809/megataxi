<?php
	//se inicializa la variable del mensaje
	$mensaje ="";
	//se verifica si esta activado el mostrar mensaje
	if($mostrar_mensaje){
	$mensaje ="<div id='mensaje-confirmacion' class='".$class."'>
				<span class='login-status-icon'></span>
				<div id='login-status-message'>".$msg.".</div>
				</div>";
	}
	echo $mensaje;
