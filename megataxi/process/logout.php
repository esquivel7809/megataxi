<?php session_start();


include("email.reporte.servicios.php");




session_unregister('datos');
session_unset();
session_destroy();



?>

<script language="javascript">location.href="../";</script>