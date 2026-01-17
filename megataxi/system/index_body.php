<?php
if($_SESSION[datos]->perfil==1){
	include('servicios_list.php');
}else if($_SESSION[datos]->perfil==2){
	include('servicios.php');
}


?>