<?php 

session_start();

?>

<form action="../process/logout.process.php" method="post">
	<p>&nbsp;  </p>
	<p>&nbsp;</p>
	<p align="center">&nbsp;</p>
	<p align="center">
	  <input type="submit" name="salir" value="SALIR" title="Solo salir de la aplicacion un momento" style="height:60px;width:300px;font-size:24px;" />
  </p>
	<p align="center"><br />
	    <input type="submit" name="salir_y_cerrar" value="SALIR Y CERRAR TURNO" title="Si ha terminado su turno, haga click aqui, de lo contrario haga click en salir" style="height:60px; width:300px;font-size:24px;" />
                    </p>
</form>
