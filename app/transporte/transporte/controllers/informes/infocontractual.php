<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infocontractual extends CI_Controller {

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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idinfocontractual']))
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
    * Muestra el formulario para el informe de seguro Contractual
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
        $data['vista_contenido_mod']=array("informes/infocontractual_view");
        
        //Array que define los titulos que llevaran los criterios
        $Titulo=array('Aseguradora','Placa','Modelo','Tipo', 'Marca');
        //Array que define los campos id' de los criterios en laBD
        $CamposId=array('idaseguradora','idvehiculo','idmodelo','idtipovehiculo','idmarcavehiculo');
        //Array que define la ruta para la busqueda
        $rutaBusqueda=array(site_url('informes/data/consultaraseguradora'),site_url('informes/data/consultarvehiculo'),site_url('informes/data/consultarmodelo'),site_url('informes/data/consultartipovehiculo'),site_url('informes/data/consultarmarcavehiculo'));
        //Array que define otras condiciones
        $otrasCondiciones="";
        
        $data['filtros'] = $this->informes->visualizaFiltros($Titulo,$CamposId,$rutaBusqueda,$otrasCondiciones);

        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Muestra el resultado para el informe de seguro Contractual
    *
    * @access public
    * @param string
    * @return string
    */
    public function resultado()
    {
        $data['vista_contenido_mod']=array("informes/infocontractual_res_view");
        $titulo="";
        $arraypost=$this->input->post();
        $arrayidaseguradora     =   $arraypost['idaseguradora'];
        $arrayidvehiculo        =   $arraypost['idvehiculo'];
        $arrayidmodelo          =   $arraypost['idmodelo'];
        $arrayidtipovehiculo    =   $arraypost['idtipovehiculo'];
        $arrayidmarcavehiculo   =   $arraypost['idmarcavehiculo'];
        $fechainicial=$this->funciones->convertirFormatoFecha($arraypost['fechainicial']);
        $fechafinal=$this->funciones->convertirFormatoFecha($arraypost['fechafinal']);
		
		$valoridaseguradora="";
		if(is_array($arrayidaseguradora) && !empty($arrayidaseguradora))
		{
			foreach($arrayidaseguradora as $value)
			{
				$valoridaseguradora.=(empty($valoridaseguradora))? "'".$value."'" :  ",'".$value."'" ; 
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
		$valoridmodelo="";
		if(is_array($arrayidmodelo) && !empty($arrayidmodelo))
		{
			foreach($arrayidmodelo as $value)
			{
				$valoridmodelo.=(empty($valoridmodelo))? "'".$value."'" :  ",'".$value."'" ; 
			}
		}
		$valoridtipovehiculo="";
		if(is_array($arrayidtipovehiculo) && !empty($arrayidtipovehiculo))
		{
			foreach($arrayidtipovehiculo as $value)
			{
				$valoridtipovehiculo.=(empty($valoridtipovehiculo))? "'".$value."'" :  ",'".$value."'" ; 
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
        
        /***** Condicion de las fechas ********/
        $condfecha=" AND c.fechafinal>='".$fechainicial."' AND c.fechafinal<='".$fechafinal."'";
        
        /**Otros Filtros*/
        if($arraypost['activo']=='on')
        {
            $titulo.="Vehiculos Activos ";
        	$condactivo=" v.activo='1'";
        }
        else
        {
            $titulo.="Vehiculos No Activos ";
            $condactivo=" v.activo='0'";
        }
        if($arraypost['asociado']=='on')
        {
            $titulo.="- Asociados ";
        	$condasociado=" AND v.asociado='1'";
        }
        if($arraypost['rodamiento']=='on')
        {
            $titulo.="- Afil. Rodamiento ";
            $condrodamiento=" AND v.empresa='1'";
        }
        if($arraypost['comunicacion']=='on')
        {
            $titulo.="- Afil. Comunicación ";
            $condcomunicacion=" AND v.comunicacion='1'";
        }
        /*****/
        
        $titulo.="<br />";
        
        /******Filtros*****/            
        if($valoridaseguradora!="")
        {
        	$titulo.=$this->informes->tituloFiltro($valoridaseguradora,'aseguradora',array('idaseguradora'),'nombreaseguradora','Aseguradora');
        	$condicionaseguradora=" AND c.idaseguradora IN (".stripslashes($valoridaseguradora).")";
        }
        if($valoridvehiculo!="")
        {
        	$titulo.=$this->informes->tituloFiltro($valoridvehiculo,'vehiculo',array('idvehiculo'),'placa','Vehiculo');
        	$condicionvehiculo=" AND v.idvehiculo IN (".stripslashes($valoridvehiculo).")";
        }
        if($valoridmodelo!="")
        {
            $titulo.=$this->informes->tituloFiltro($valoridmodelo,'modelo',array('idmodelo'),'nombremodelo','Modelo');
            $condicionmodelo=" AND m.idmodelo IN(".stripslashes($valoridmodelo).")";
        }
        if($valoridtipovehiculo!="")
        {
            $titulo.=$this->informes->tituloFiltro($valoridtipovehiculo,'tipovehiculo',array('idtipovehiculo'),'nombretipovehiculo','Tipo de Vehiculo');
            $condiciontipovehiculo=" AND tv.idtipovehiculo IN(".stripslashes($valoridtipovehiculo).")";
        }
        if($valoridmarcavehiculo!="")
        {
            $titulo.=$this->informes->tituloFiltro($valoridmarcavehiculo,'marcavehiculo',array('idmarcavehiculo'),'nombremarcavehiculo','Marca de Vehiculo');
            $condicionmarcavehiculo=" AND mv.idmarcavehiculo IN(".stripslashes($valoridmarcavehiculo).")";
        }
        /************/
        
        /**** Campos a Consultar *******/
        $sqlselect="c.numerocontractual, c.fechafinal, a.nombreaseguradora, v.idvehiculo, v.placa,
                    m.nombremodelo, tv.nombretipovehiculo, mv.nombremarcavehiculo, v.asociado,
                    v.empresa, v.comunicacion, v.activo ";
        
        /***** Relacion de Tablas *****/
        $sqlfrom="FROM contractual AS c 
                LEFT JOIN aseguradora AS a ON a.idaseguradora=c.idaseguradora
                LEFT JOIN vehiculo AS v ON v.idvehiculo=c.idvehiculo
                LEFT JOIN modelo AS m ON m.idmodelo=v.idmodelo
                LEFT JOIN tipovehiculo AS tv ON tv.idtipovehiculo=v.idtipovehiculo
                LEFT JOIN marcavehiculo AS mv ON mv.idmarcavehiculo=v.idmarcavehiculo
                ";
                
        /****** Condicion *******/
        $sqlcondicion=$condfecha.$condicionaseguradora.$condicionvehiculo.$condicionmodelo.$condiciontipovehiculo.$condicionmarcavehiculo;
        
        /***** Consulta completa********/
        $sqlconsulta="SELECT ".$sqlselect.$sqlfrom." WHERE".$condactivo.$condasociado.$condrodamiento.$condcomunicacion.$sqlcondicion. " AND c.activo='1'";
        
        /***** Datos que pasan a la vista *****/            
        $data['result']=$this->db->query($sqlconsulta);
        $data['arraysino']=array('1'=>'SI','0'=>'NO');
        $data['tituloInfo']=$this->informes->encabezadoInforme('INFORME DE SEGUROS CONTRACTUALES',$titulo,$fechainicial,$fechafinal,true);
        
		if(isset($arraypost["Html"])){
			$data['imprimir']=true;
			$this->load->view("include/plantilla4",$data);
		}
		else if(isset($arraypost["pdf"])){
			/*
			$data['imprimir']=false;
			$nombrearchivo="informe_seguros_contractuales_".date('YmdHis').".pdf";
			$html=$this->load->view("informes/infoconductores_res_view",$data, true);
			$this->generar($html, $nombrearchivo);
			*/
		}
		else if(isset($arraypost["excel"])){
			$data['imprimir']=false;
			$data['tiporeporte']="excel";
			$data['nombrearchivo']="informe_seguros_contractuales_".date('YmdHis').".xls";
			$this->load->view("include/plantilla4",$data);           
		}
    }
    
}
/* End of file infocontractual.php */
/* Location: ./application/controllers/informes/infocontractual.php */