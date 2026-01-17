<html> 

<head> 
<title>Iniciar actualizaciÃ³n.</title> 
<META name='robot' content='noindex, nofollow'> 
</head> 

<body> 

<div align="center"> 
    <table border="0" width="600" style="font-family: Verdana; font-size: 8pt" id="table1"> 
        <tr> 
            <td colspan="2"><h3 align="center">ActualizaciÃ³n de datos</h3></td> 
        </tr> 
        <form method="POST" action="form2.php"> 
        <tr> 
            <td width="50%">&nbsp;</td> 
            <td width="50%">&nbsp;</td> 
        </tr> 
        <tr> 
            <td width="50%"> 
            <p align="center"><b>Cedula Conductor a actualizar: </b></td> 
            <td width="50%"> 
            <p align="center"><input type="text" name="id" size="20"></td> 
        </tr> 
        <tr> 
            <td width="50%">&nbsp;</td> 
            <td width="50%">&nbsp;</td> 
        </tr> 
        <tr> 
            <td> 
            <p align="center"> 
            <input type="submit" value="Iniciar actualizaciÃ³n" name="B1"></td> 
			
        </tr> 
        </form> 
    </table> 

</div> 
<br><br><br><br><br><br><br><br> 
<div align="center"> 
<center> <h3>INFORME VENCIMIENTO LICENCIAS DE CONDUCCION POR PERIODO DE FECHA </h3> </center> 
<br><br><br><br> 
<table border="1"> 

        <tr> 
            <td width="50%"> 
            <p align="center"><b>Fecha Inicial: </b></td> 
            <td width="50%"> 

        <form method="POST" action="vence_licencia.php"> 
            <p align="center"><input type="date" name="fechaini" size="20"></td> 
        </tr> 
        <tr> 
            <td width="50%">&nbsp;</td> 
            <td width="50%">&nbsp;</td> 
        </tr> 
        <tr> 
            
<td width="50%"> 
            <p align="center"><b>Fecha final: </b></td> 
            <td width="50%"> 
            <p align="center"><input type="date" name="fechafin" size="20"></td> 
        </tr> 
        <tr> 
            <td width="50%">&nbsp;</td> 
            <td width="50%">&nbsp;</td> 
        </tr> 
        <tr> 
            <td> 

            <p align="center"> 
            <input type="submit" value="Generar Informe" name="B1"></td> 
			
        </tr> 
</table>
</form>  
</div> 

</body> 

</html> 