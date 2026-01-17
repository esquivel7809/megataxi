<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inforefrendacion extends CI_Controller {

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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idinforefrendacion']))
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
    * Muestra el formulario para el informe de refrendacion de tarjetas de control
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
        //se incluye la vista
        $data['vista_contenido_mod']=array("informes/inforefrendacion_view");
        
        //Array que define los titulos que llevaran los criterios
        $Titulo=array('Conductor','Grupo Sanguineo','Genero','Placa','Marca','Modelo');
        //Array que define los campos id' de los criterios en laBD
        $CamposId=array('idconductor','idgruposanguineo','idgenero','idvehiculo','idmarcavehiculo','idmodelo');
        //Array que define la ruta para la busqueda
        $rutaBusqueda=array(site_url('informes/data/consultarconductor'),site_url('informes/data/consultargruposanguineo'),site_url('informes/data/consultargenero'),site_url('informes/data/consultarvehiculo'),site_url('informes/data/consultarmarcavehiculo'),site_url('informes/data/consultarmodelo'));
        //Array que define otras condiciones
        $otrasCondiciones="";
        
        $data['filtros'] = $this->informes->visualizaFiltros($Titulo,$CamposId,$rutaBusqueda,$otrasCondiciones);

        $this->load->view('include/plantilla3',$data);
    }
    
    /**
    * Muestra el resultado para el informe de refrendacion de tarjetas de control
    *
    * @access public
    * @param string
    * @return string
    */
    public function resultado()
    {
        $data['vista_contenido_mod']=array("informes/inforefrendacion_res_view");
        $arraypost=$this->input->post();
        $arrayidconductor       =   $arraypost['idconductor'];
        $arrayidgruposanguineo  =   $arraypost['idgruposanguineo'];
        $arrayidgenero          =   $arraypost['idgenero'];
        $arrayidvehiculo        =   $arraypost['idvehiculo'];
        $arrayidmarcavehiculo  =   $arraypost['idmarcavehiuclo'];
        $arrayidmodelo          =   $arraypost['idmodelo'];
        $fechainicial=$this->funciones->convertirFormatoFecha($arraypost['fechainicial']);
        $fechafinal=$this->funciones->convertirFormatoFecha($arraypost['fechafinal']);
		
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
        $valoridvehiculo="";
		if(is_array($arrayidvehiculo) && !empty($arrayidvehiculo))
		{
			foreach($arrayidvehiculo as $value)
			{
				$valoridvehiculo.=(empty($valoridvehiculo))? "'".$value."'" :  ",'".$value."'" ; 
			}
		}
		$valoridmarcavehiculo="";
		if(is_array($arrayidmarcavehiculo) && !empty($arrayidmarcavehiculo))
		{
			foreach($arrayidmarcavehiculo as $value)
			{
				$valoridmarcavehiculo.=(empty($valoridmarcavehiculo))? "'".$value."'" :  ",'".$value."'" ; 
			}
		}
		$valoridmodelo="";
		if(is_array($arrayidmodelo) && !empty($arrayidmodelo))
		{
			foreach($arrayidmodelo as $value)
			{
				$valoridmodelo.=(empty($valoridmodelo))? "'".$value."'" :  ",'".$value."'" ; 
			}
		}
        
        /***** Condicion de las fechas ********/
        $condfecha=" r.fecharefrendacion>='".$fechainicial."' AND r.fecharefrendacion<='".$fechafinal."'";
        
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
        if($valoridvehiculo!="")
        {
            $titulo.=$this->informes->tituloFiltro($valoridvehiculo,'vehiculo',array('idvehiculo'),'placa','Vehiculo');
            $condicionvehiculo=" AND v.idvehiculo IN(".stripslashes($valoridvehiculo).")";
        }
        if($valoridmarcavehiculo!="")
        {
            $titulo.=$this->informes->tituloFiltro($valoridmarcavehiculo,'marcavehiculo',array('idmarcavehiculo'),'nombremarcavehiculo','Marca de Vehiculo');
            $condicionmarcavehiculo=" AND mv.idmarcavehiculo IN(".stripslashes($valoridmarcavehiculo).")";
        }
        if($valoridmodelo!="")
        {
            $titulo.=$this->informes->tituloFiltro($valoridmodelo,'modelo',array('idmodelo'),'nombremodelo','Modelo');
            $condicionmodelo=" AND mo.idmodelo IN(".stripslashes($valoridmodelo).")";
        }
        
        /**** Campos a Consultar *******/
        $sqlselect="vc.numerotarjeta, td.abreviatura, c.numerodocumento, m.nombremunicipio AS lugarexpedicion, c.nombrecompleto, 
                    g.nombregenero, gs.nombregruposanguineo, v.placa, mv.nombremarcavehiculo, mo.nombremodelo, v.numerointerno,
                    r.fecharefrendacion, r.horarefrendacion, r.fechavencimiento ";
        
        /***** Relacion de Tablas *****/
        $sqlfrom="FROM refrendacion AS r 
                INNER JOIN vehiculoconductor AS vc ON vc.idvehiculoconductor=r.idvehiculoconductor
                LEFT JOIN conductor AS c ON c.idconductor=vc.idconductor
                LEFT JOIN vehiculo AS v ON v.idvehiculo=vc.idvehiculo
                LEFT JOIN genero AS g ON g.idgenero=c.idgenero
                LEFT JOIN gruposanguineo AS gs ON gs.idgruposanguineo=c.idgruposanguineo
                LEFT JOIN tipodocumento AS td ON td.idtipodocumento=c.idtipodocumento
                LEFT JOIN municipio AS m ON m.idmunicipio=c.idlugarexpedicion
                LEFT JOIN municipio AS m1 ON m1.idmunicipio=c.idlugarnacimiento
                LEFT JOIN marcavehiculo AS mv ON mv.idmarcavehiculo=v.idmarcavehiculo
                LEFT JOIN modelo AS mo ON mo.idmodelo=v.idmodelo
                ";
                
        /****** Condicion *******/
        $sqlcondicion=$condfecha.$condicioncoductor.$condiciongruposanguineo.$condiciongenero.$condicionvehiculo.$condicionmarcavehiculo.$condicionmodelo;
        if(empty($sqlcondicion)) $sqlcondicion="1";
        
        /****** Orden de la consulta ********/
        $sqlorder="c.idconductor ASC";
        
        /***** Consulta completa********/
        $sqlconsulta="SELECT ".$sqlselect.$sqlfrom." WHERE ".$sqlcondicion." AND vc.activo='1' ORDER BY ".$sqlorder;
        
        /***** Datos que pasan a la vista *****/
        $data['result']=$this->db->query($sqlconsulta);
        $data['arraysino']=array('1'=>'SI','0'=>'NO');
        $data['tituloInfo']=$this->informes->encabezadoInforme('INFORME DE REFRENDACIÓN DE TARJETAS DE CONTROL',$titulo,$fechainicial,$fechafinal,true);
		
		if(isset($arraypost["Html"])){
			$data['imprimir']=true;
			$this->load->view("include/plantilla4",$data);
		}
		else if(isset($arraypost["pdf"])){
			/*
			$data['imprimir']=false;
			$nombrearchivo="informe_refre_tarjetas_control_".date('YmdHis').".pdf";
			$html=$this->load->view("informes/infoconductores_res_view",$data, true);
			$this->generar($html, $nombrearchivo);
			*/
		}
		else if(isset($arraypost["excel"])){
			$data['imprimir']=false;
			$data['tiporeporte']="excel";
			$data['nombrearchivo']="informe_refre_tarjetas_control_".date('YmdHis').".xls";
			$this->load->view("include/plantilla4",$data);           
		}

        
        //$this->load->view("include/plantilla4",$data);           
    }
    
}
/* End of file inforefrendacion.php */
/* Location: ./application/controllers/informes/inforefrendacion.php */