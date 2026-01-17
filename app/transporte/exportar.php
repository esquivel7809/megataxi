<?php
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);
if (PHP_SAPI == 'cli')
	die('Este ejemplo sólo se puede ejecutar desde un navegador Web');
 
/** Incluye PHPExcel */
require_once dirname(__FILE__) . '/clases/PHPExcel.php';
// Crear nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();
 
// Propiedades del documento
$objPHPExcel->getProperties()->setCreator("sin nombre")
							 ->setLastModifiedBy("sin nombre")
							 ->setTitle("Office 2010 XLSX Documento de prueba")
							 ->setSubject("Office 2010 XLSX Documento de prueba")
							 ->setDescription("Documento de prueba para Office 2010 XLSX, generado usando clases de PHP.")
							 ->setKeywords("office 2010 openxml php")
							 ->setCategory("Archivo con resultado de prueba");
 
 
 
// Combino las celdas desde A1 hasta E1
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
 
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'REPORTE DE CONDUCTORES A LA SUPERINTENDENCIA DE PUERTOS Y TRANSPORTE')
            ->setCellValue('A2', 'CEDULA')
            ->setCellValue('B2', 'NOMBRES')
            ->setCellValue('C2', 'GRUPOINTERNO')
			->setCellValue('D2', 'FECHA NACIMIENTO')
			->setCellValue('E2', 'FECHA INGRESO (FIRMA ULTIMO CONTRATO)')
			->setCellValue('F2', 'VENCIMIENTO CONTRATO')
			->setCellValue('G2', 'N. LICENCIA')
			->setCellValue('H2', 'CATEGORIA LICENCIA')
			->setCellValue('I2', 'FECHA VENCIMIENTO');
			
// Fuente de la primera fila en negrita
$boldArray = array('font' => array('bold' => true,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
 
$objPHPExcel->getActiveSheet()->getStyle('A1:E2')->applyFromArray($boldArray);		
 
	
			
//Ancho de las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);	
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);	
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);	
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);		
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);	
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);		
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(9);	
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);	
 
/*Extraer datos de MYSQL*/
	# conectare la base de datos
    $con=@mysqli_connect('localhost', 'root', 'super45mega67', 'transporte');
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }
	$sql="SELECT DISTINCT * FROM conductor,licenciaconductor,categoria where (conductor.idconductor=licenciaconductor.idconductor) and (licenciaconductor.idcategoria=categoria.idcategoria) and (conductor.activo=1) order by conductor.numerodocumento";
	$query=mysqli_query($con,$sql);
	$cel=3;//Numero de fila donde empezara a crear  el reporte
	while ($row=mysqli_fetch_array($query)){
		$numerodocumento=$row['numerodocumento'];
		$nombrecompleto=$row['nombrecompleto'];
		$primernombre=$row['primernombre'];
		$fechanacimiento=$row['fechanacimiento'];
		$fechacreacion=$row['fechacreacion'];
		$vencimientocontrato=$row['fechacreacion'];
		$numerolicenciaconductor=$row['numerolicenciaconductor'];
		$nombrecategoria=$row['nombrecategoria'];
		$fechavencimiento=$row['fechavencimiento'];
		
			$a="A".$cel;
			$b="B".$cel;
			$c="C".$cel;
			$d="D".$cel;
			$e="E".$cel;
			$f="F".$cel;
			$g="G".$cel;
			$h="H".$cel;
			$i="I".$cel;
			
			// Agregar datos
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($a, $numerodocumento)
            ->setCellValue($b, $nombrecompleto)
            ->setCellValue($c, $primernombre)
            ->setCellValue($d, $fechanacimiento)
			->setCellValue($e, $fechacreacion)
			->setCellValue($f, $fechacreacion)
			->setCellValue($g, $numerolicenciaconductor)
			->setCellValue($h, $nombrecategoria)
			->setCellValue($i, $fechavencimiento);
			
	$cel+=1;
	}
 
/*Fin extracion de datos MYSQL*/
$rango="A2:$e";
$styleArray = array('font' => array( 'name' => 'Arial','size' => 10),
'borders'=>array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('argb' => 'FFF')))
);
$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);
// Cambiar el nombre de hoja de cálculo
$objPHPExcel->getActiveSheet()->setTitle('Reporte de conductores');
 
 
// Establecer índice de hoja activa a la primera hoja , por lo que Excel abre esto como la primera hoja
$objPHPExcel->setActiveSheetIndex(0);
 
 
// Redirigir la salida al navegador web de un cliente ( Excel5 )
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte.xls"');
header('Cache-Control: max-age=0');
// Si usted está sirviendo a IE 9 , a continuación, puede ser necesaria la siguiente
header('Cache-Control: max-age=1');
 
// Si usted está sirviendo a IE a través de SSL , a continuación, puede ser necesaria la siguiente
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>