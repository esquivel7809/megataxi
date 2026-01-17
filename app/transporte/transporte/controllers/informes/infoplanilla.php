<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Infoplanilla extends CI_Controller {
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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idinfoplanilla']))
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
    * Muestra el formulario para el informe de seguros SOAT
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
        $data['vista_contenido_mod']=array("informes/infoplanilla_view");
        
        //Array que define los titulos que llevaran los criterios
        $Titulo=array('Numero de Planilla','Placa','Conductor','Modelo','Tipo', 'Marca');
        //Array que define los campos id' de los criterios en laBD
        $CamposId=array('idplanilla','idvehiculo','idconductor','idmodelo','idtipovehiculo','idmarcavehiculo');
        //Array que define la ruta para la busqueda
        $rutaBusqueda=array(site_url('informes/data/consultarnumeroplanilla'),site_url('informes/data/consultarvehiculo'),site_url('informes/data/consultarconductor'),site_url('informes/data/consultarmodelo'),site_url('informes/data/consultartipovehiculo'),site_url('informes/data/consultarmarcavehiculo'));
        //Array que define otras condiciones
        $otrasCondiciones="";
        
        $data['filtros'] = $this->informes->visualizaFiltros($Titulo,$CamposId,$rutaBusqueda,$otrasCondiciones);
        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Muestra el resultado para el informe de seguros SOAT
    *
    * @access public
    * @param string
    * @return string
    */
    public function resultado()
    {
        $data['vista_contenido_mod']=array("informes/infoplanilla_res_view");
        $titulo="";
        $arraypost=$this->input->post();
        $arrayidplanilla	=   $arraypost['idplanilla'];
        $arrayidvehiculo        =   $arraypost['idvehiculo'];
		$arrayidconductor		=   $arraypost['idconductor'];
        $arrayidmodelo          =   $arraypost['idmodelo'];
        $arrayidtipovehiculo    =   $arraypost['idtipovehiculo'];
        $arrayidmarcavehiculo   =   $arraypost['idmarcavehiculo'];
        $fechainicial=$this->funciones->convertirFormatoFecha($arraypost['fechainicial']);
        $fechafinal=$this->funciones->convertirFormatoFecha($arraypost['fechafinal']);
        
		$valoridplanilla="";
		if(is_array($arrayidplanilla) && !empty($arrayidplanilla))
		{
			foreach($arrayidplanilla as $value)
			{
				$valoridplanilla.=(empty($valoridplanilla))? "'".$value."'" :  ",'".$value."'" ; 
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
        $valoridconductor="";
		if(is_array($arrayidconductor) && !empty($arrayidconductor))
		{
			foreach($arrayidconductor as $value)
			{
				$valoridconductor.=(empty($valoridconductor))? "'".$value."'" :  ",'".$value."'" ; 
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
        $condfecha=" p.fechainicio>='".$fechainicial."' AND p.fechainicio<='".$fechafinal."'";
        
        /**Otros Filtros*/
        /*
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
        if($valoridplanilla!="")
        {
        	$titulo.=$this->informes->tituloFiltro($valoridplanilla,'planilla',array('idplanilla'),'numeroplanilla','Planilla');
        	$condicionplanilla=" AND p.idplanilla IN (".stripslashes($valoridplanilla).")";
        }
        if($valoridvehiculo!="")
        {
        	$titulo.=$this->informes->tituloFiltro($valoridvehiculo,'vehiculo',array('idvehiculo'),'placa','Vehiculo');
        	$condicionvehiculo=" AND v.idvehiculo IN (".stripslashes($valoridvehiculo).")";
        }
        if($valoridconductor!="")
        {
        	$titulo.=$this->informes->tituloFiltro($valoridconductor,'conductor',array('idconductor'),'nombrecompleto','Conductor');
        	$condicionconductor=" AND c.idvehiculo IN (".stripslashes($valoridconductor).")";
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
        $sqlselect="p.numeroplanilla, p.fechainicio, p.ciudaddestino, p.fecharegreso, p.cantidadpasajeros, 
        			c.nombrecompleto, c.telefonofijo, c.celular, v.idvehiculo, v.placa,
                    m.nombremodelo, tv.nombretipovehiculo, mv.nombremarcavehiculo, v.asociado,
                    v.empresa, v.comunicacion, v.activo ";
        
        /***** Relacion de Tablas *****/
        $sqlfrom="FROM planilla AS p
                LEFT JOIN vehiculoconductor AS vc ON vc.idvehiculoconductor=p.idvehiculoconductor
                LEFT JOIN vehiculo AS v ON v.idvehiculo=vc.idvehiculo
                LEFT JOIN conductor AS c ON c.idconductor=vc.idconductor
                LEFT JOIN modelo AS m ON m.idmodelo=v.idmodelo
                LEFT JOIN tipovehiculo AS tv ON tv.idtipovehiculo=v.idtipovehiculo
                LEFT JOIN marcavehiculo AS mv ON mv.idmarcavehiculo=v.idmarcavehiculo
                
                ";
                
        /****** Condicion *******/
        $sqlcondicion=$condfecha.$condicionplanilla.$condicionvehiculo.$condicionconductor.$condicionmodelo.$condiciontipovehiculo.$condicionmarcavehiculo;
        
        /***** Consulta completa********/
        $sqlconsulta="SELECT ".$sqlselect.$sqlfrom." WHERE ".$condactivo.$condasociado.$condrodamiento.$condcomunicacion.$sqlcondicion." ORDER BY p.numeroplanilla ASC";
        
        /***** Datos que pasan a la vista *****/            
        $data['result']=$this->db->query($sqlconsulta);
        $data['arraysino']=array('1'=>'SI','0'=>'NO');
        $data['tituloInfo']=$this->informes->encabezadoInforme('INFORME DE PLANILLAS',$titulo,$fechainicial,$fechafinal,true);;
        
		if(isset($arraypost["Html"])){
			$data['imprimir']=true;
			$this->load->view("include/plantilla4",$data);
		}
		else if(isset($arraypost["pdf"])){
			/*
			$data['imprimir']=false;
			$nombrearchivo="informe_de_soat_".date('YmdHis').".pdf";
			$html=$this->load->view("informes/infoconductores_res_view",$data, true);
			$this->generar($html, $nombrearchivo);
			*/
		}
		else if(isset($arraypost["excel"])){
			$data['imprimir']=false;
			$data['tiporeporte']="excel";
			$data['nombrearchivo']="informe_de_planillas_".date('YmdHis').".xls";
			$this->load->view("include/plantilla4",$data);           
		}
    }
    
}
/* End of file infosoat.php */
/* Location: ./application/controllers/informes/infosoat.php */
