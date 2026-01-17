<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infoconductores extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/conductores/conductores
	 *	- or -
	 * 		http://example.com/index.php/conductores/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/conductores/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
        parent::__construct();
        
        $this->load->library('funciones');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idinfoconductor']))
            {
                terminar_session();
            }
            else
            {
                $this->load->library('tabla');
                $this->load->library('informes');
            }
        }
        else
        {
            terminar_session();
        }
    }
        
    /**
    * Muestra el formulario para el informe de conductores
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
		//se incluye la vista
        $data['vista_contenido_mod']=array("informes/infoconductores_view");
        
        //Array que define los titulos que llevaran los criterios
        $Titulo=array('Conductor','Grupo Sanguineo','Genero');
        //Array que define los campos id' de los criterios en laBD
        $CamposId=array('idconductor','idgruposanguineo','idgenero');
        //Array que define la ruta para la busqueda
        $rutaBusqueda=array(site_url('informes/data/consultarconductor'),site_url('informes/data/consultargruposanguineo'),site_url('informes/data/consultargenero'));
        //Array que define otras condiciones
        $otrasCondiciones="";
        
        $data['filtros'] = $this->informes->visualizaFiltros($Titulo,$CamposId,$rutaBusqueda,$otrasCondiciones);

        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Muestra el resultado para el informe de conductores
    *
    * @access public
    * @param string
    * @return string
    */
    public function resultado()
    {
        $data['vista_contenido_mod']=array("informes/infoconductores_res_view");
        $titulo="";
        $arraypost=$this->input->post();
		
        $arrayidconductor       =   $arraypost['idconductor'];
        $arrayidgruposanguineo  =   $arraypost['idgruposanguineo'];
        $arrayidgenero          =   $arraypost['idgenero'];
		
		$valoridconductor="";
		if(is_array($arrayidconductor) && !empty($arrayidconductor))
		{
			foreach($arrayidconductor as $value)
			{
				$valoridconductor.=(empty($valoridconductor))? "'".$value."'" :  ",'".$value."'" ; 
			}
		}
		$valoridgruposanguineo="";
		if(is_array($arrayidgruposanguineo) && !empty($arrayidgruposanguineo))
		{
			foreach($arrayidgruposanguineo as $value)
			{
				$valoridgruposanguineo.=(empty($valoridgruposanguineo))? "'".$value."'" :  ",'".$value."'" ; 
			}
		}
		$valoridgenero="";
		if(is_array($arrayidgenero) && !empty($arrayidgenero))
		{
			foreach($arrayidgenero as $value)
			{
				$valoridgenero.=(empty($valoridgenero))? "'".$value."'" :  ",'".$value."'" ; 
			}
		}

        
        /**Otros Filtros*/
        if($arraypost['activo']=='on')
        {
            $titulo.="Activos ";
        	$condactivo=" c.activo='1'";
        }
        else
        {
            $titulo.="No Activos ";
            $condactivo=" c.activo='0'";
        }
        if($arraypost['conductor']=='on')
        {
            $titulo.="- Conductores";
        	$condconductor=" AND c.conductor='1'";
        }
        if($arraypost['propietario']=='on')
        {
            $titulo.="- Propietarios";
            $condpropietario=" AND c.propietario='1'";
        }
        
        $titulo.="<br />";
        
        /******Filtros*****/ 
        if($valoridconductor!="")
        {
        	$titulo.=$this->informes->tituloFiltro($valoridconductor,'conductor',array('idconductor'),'numerodocumento','Numero de Documento');
        	$condicioncoductor=" AND c.idconductor IN (".stripslashes($valoridconductor).")";
        }
        if($valoridgruposanguineo!="")
        {
            $titulo.=$this->informes->tituloFiltro($valoridgruposanguineo,'gruposanguineo',array('idgruposanguineo'),'nombregruposanguineo','Grupo Sanguineo');
            $condiciongruposanguineo=" AND gs.idgruposanguineo IN(".stripslashes($valoridgruposanguineo).")";
        }
        if($valoridgenero!="")
        {
            $titulo.=$this->informes->tituloFiltro($valoridgenero,'genero',array('idgenero'),'nombregenero','Genero');
            $condiciongenero=" AND g.idgenero IN(".stripslashes($valoridgenero).")";
        }
        
        /**** Campos a Consultar *******/
        $sqlselect="c.*, td.abreviatura, m.nombremunicipio AS lugarexpedicion, m1.nombremunicipio AS lugarnacimiento,
                    g.nombregenero, gs.nombregruposanguineo ";
        
        /***** Relacion de Tablas *****/
        $sqlfrom="FROM conductor AS c 
                LEFT JOIN genero AS g ON g.idgenero=c.idgenero
                LEFT JOIN gruposanguineo AS gs ON gs.idgruposanguineo=c.idgruposanguineo
                LEFT JOIN tipodocumento AS td ON td.idtipodocumento=c.idtipodocumento
                LEFT JOIN municipio AS m ON m.idmunicipio=c.idlugarexpedicion
                LEFT JOIN municipio AS m1 ON m1.idmunicipio=c.idlugarnacimiento
                ";
                
        /****** Condicion *******/
        $sqlcondicion=$condicioncoductor.$condiciongruposanguineo.$condiciongenero;
        
        /***** Consulta completa********/
        $sqlconsulta="SELECT ".$sqlselect.$sqlfrom." WHERE".$condactivo.$condconductor.$condpropietario.$sqlcondicion;
        
        /***** Datos que pasan a la vista *****/
        $data['result']=$this->db->query($sqlconsulta);
        $data['arraysino']=array('1'=>'SI','0'=>'NO');
        
		if(isset($arraypost["Html"])){
			$data['imprimir']=true;
			$data['tituloInfo']=$this->informes->encabezadoInforme('INFORME DE CONDUCTORES',$titulo,$fechainicial,$fechafinal,false);
			$this->load->view("include/plantilla4",$data);
		}
		else if(isset($arraypost["pdf"])){
			$data['imprimir']=false;
			$nombrearchivo="informe_conductores_".date('YmdHis').".pdf";
			$html=$this->load->view("informes/infoconductores_res_view",$data, true);
			$this->generar($html, $nombrearchivo);
		}
		else if(isset($arraypost["excel"])){
			$data['imprimir']=false;
			$data['tiporeporte']="excel";
			$data['nombrearchivo']="informe_conductores_".date('YmdHis').".xls";
			$data['tituloInfo']=$this->informes->encabezadoInforme('INFORME DE CONDUCTORES',$titulo,$fechainicial,$fechafinal,false);
			$this->load->view("include/plantilla4",$data);           
		}
    }
	
	public function generar($html, $nombrearchivo)
	{
		$this->load->library('Pdf');
		//$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Jorge Serrano');
		$pdf->SetTitle('Ejemplo de provincías con TCPDF');
		$pdf->SetSubject('Tutorial TCPDF');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
		$pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
		
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//relación utilizada para ajustar la conversión de los píxeles
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		
		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
		$pdf->setFontSubsetting(true);
		
		// Establecer el tipo de letra
		
		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
		//$pdf->SetFont('freemono', '', 14, '', true);
		
		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
		$pdf->AddPage('L', 'A4');
		
		//fijar efecto de sombra en el texto
		//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
/*		
		// Establecemos el contenido para imprimir
		$provincia = $this->input->post('provincia');
		$provincias = $this->pdfs_model->getProvinciasSeleccionadas($provincia);
		foreach($provincias as $fila)
		{
			$prov = $fila['p.provincia'];
		}
		//preparamos y maquetamos el contenido a crear
		$html = '';
		$html .= "<style type=text/css>";
		$html .= "th{color: #fff; font-weight: bold; background-color: #222}";
		$html .= "td{background-color: #AAC7E3; color: #fff}";
		$html .= "</style>";
		$html .= "<h2>Localidades de ".$prov."</h2><h4>Actualmente: ".count($provincias)." localidades</h4>";
		$html .= "<table width='100%'>";
		$html .= "<tr><th>Id localidad</th><th>Localidades</th></tr>";
		
		//provincias es la respuesta de la función getProvinciasSeleccionadas($provincia) del modelo
		foreach ($provincias as $fila) 
		{
			$id = $fila['l.id'];
			$localidad = $fila['l.localidad'];
		
			$html .= "<tr><td class='id'>" . $id . "</td><td class='localidad'>" . $localidad . "</td></tr>";
		}
		$html .= "</table>";
*/		
		// Imprimimos el texto con writeHTMLCell()
		//$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
		$pdf->writeHTML($html, true, false, false, false, '');
		
		// ---------------------------------------------------------
		// Cerrar el documento PDF y preparamos la salida
		// Este método tiene varias opciones, consulte la documentación para más información.
		$nombre_archivo = utf8_decode($nombrearchivo);
		$pdf->Output($nombre_archivo, 'I');
	}
	
}
/* End of file infoconductores.php */
/* Location: ./application/controllers/informes/infoconductores.php */