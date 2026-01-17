<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infovehiculos extends CI_Controller {

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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idinfovehiculo']))
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
    * Muestra el formulario para el informe de vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
        $data['vista_contenido_mod']=array("informes/infovehiculos_view");
        
        //Array que define los titulos que llevaran los criterios
        $Titulo=array('Placa','Modelo','Revisado','Tipo', 'Marca');
        //Array que define los campos id' de los criterios en laBD
        $CamposId=array('idvehiculo','idmodelo','idmeses','idtipovehiculo','idmarcavehiculo');
        //Array que define la ruta para la busqueda
        $rutaBusqueda=array(site_url('informes/data/consultarvehiculo'),site_url('informes/data/consultarmodelo'),site_url('informes/data/consultarmeses'),site_url('informes/data/consultartipovehiculo'),site_url('informes/data/consultarmarcavehiculo'));
        //Array que define otras condiciones
        $otrasCondiciones=array('','','');
        
        $data['filtros'] = $this->informes->visualizaFiltros($Titulo,$CamposId,$rutaBusqueda,$otrasCondiciones);

        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Muestra el resultado para el informe de vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function resultado()
    {
        $data['vista_contenido_mod']=array("informes/infovehiculos_res_view");
        $titulo="";
		$data['propietarios']=false;
        $this->tabla->settabla('vehiculo');
        $arraypost=$this->input->post();
        $arrayidvehiculo        =   $arraypost['idvehiculo'];
        $arrayidmodelo          =   $arraypost['idmodelo'];
        $arrayidmeses           =   $arraypost['idmeses'];
        $arrayidtipovehiculo    =   $arraypost['idtipovehiculo'];
        $arrayidmarcavehiculo   =   $arraypost['idmarcavehiculo'];
        
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
		$valoridmeses="";
		if(is_array($arrayidmeses) && !empty($arrayidmeses))
		{
			foreach($arrayidmeses as $value)
			{
				$valoridmeses.=(empty($valoridmeses))? "'".$value."'" :  ",'".$value."'" ; 
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
		
        /**Otros Filtros*/
        if($arraypost['activo']=='on')
        {
            $titulo.="Vehiculos Activos ";
        	$condactivo=" v.activo='1'";
        }
        else
        {
            $titulo.="No Activos ";
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
        if($arraypost['propietarios']=='on')
        {
        	$tituloPropietarios="- Incluidos Todos los Propietarios ";
        	$sqlGroupVehiculos="";
			//si se incluyen los propietarios, se consulta si se quiere visualizar  1= un solo propietario, 2= todos los propietarios 
			if($arraypost['opcionpropietarios']=='1'){
				$tituloPropietarios="- Incluido un solo propietario ";
				$sqlGroupVehiculos=" GROUP BY v.idvehiculo ";
			}
			$data['propietarios']=true;
            $titulo.=$tituloPropietarios;
			$sqlselectpropietario=", c.nombrecompleto, c.telefonofijo, c.celular, c.numerodocumento ";
            $sqlfrompropietario=" LEFT JOIN vehiculopropietario AS vp ON vp.idvehiculo=v.idvehiculo AND vp.activo='1'
								  LEFT JOIN conductor AS c ON c.idconductor=vp.idconductor";
        }
        if($arraypost['tarjetaOperacion']=='on'){
        	$data['tarjetaOperacion']=true;
			$titulo.="- Incluido Nro. Tarjeta de Operación ";
			$sqlSelectTarjetaOperacion=", taro.numerotarjetaoperacion ";
			$sqlTarjetaOperacion=" LEFT JOIN tarjetaoperacion AS taro ON taro.idvehiculo=v.idvehiculo AND taro.activo=1 ";
        }
        
        /*****/
        
        $titulo.="<br />";
        
        /******Filtros*****/            
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
        if($valoridmeses!="")
        {
            $titulo.=$this->informes->tituloFiltro($valoridmeses,'meses',array('idmeses'),'nombremeses','Revisado');
            $condicionrevisado=" AND me.idmeses IN(".stripslashes($valoridmeses).")";
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
        $sqlselect="v.idvehiculo, v.placa, v.numerochasis ,v.numeromotor, v.cilindraje, v.fechamatricula,
                    v.numerolicencia, v.numerointerno, m.nombremodelo, me.nombremeses AS revisado, tv.nombretipovehiculo, 
                    mv.nombremarcavehiculo, v.asociado, v.empresa, v.comunicacion, v.activo ".$sqlselectpropietario.$sqlSelectTarjetaOperacion;
        
        /***** Relacion de Tablas *****/
        $sqlfrom="FROM vehiculo AS v 
                LEFT JOIN modelo AS m ON m.idmodelo=v.idmodelo
                LEFT JOIN meses AS me ON me.idmeses=v.idrevisado
                LEFT JOIN tipovehiculo AS tv ON tv.idtipovehiculo=v.idtipovehiculo
                LEFT JOIN marcavehiculo AS mv ON mv.idmarcavehiculo=v.idmarcavehiculo                
                ".$sqlfrompropietario.$sqlTarjetaOperacion;
                
        /****** Condicion *******/
        $sqlcondicion=$condicionvehiculo.$condicionmodelo.$condicionrevisado.$condiciontipovehiculo.$condicionmarcavehiculo;
        
        /***** Consulta completa********/
        $sqlconsulta="SELECT ".$sqlselect.$sqlfrom." WHERE".$condactivo.$condasociado.$condrodamiento.$condcomunicacion.$sqlcondicion.$sqlGroupVehiculos;
        
        /***** Datos que pasan a la vista *****/            
        $data['result']=$this->db->query($sqlconsulta);
        $data['arraysino']=array('1'=>'SI','0'=>'NO');
        $data['tituloInfo']=$this->informes->encabezadoInforme('INFORME DE VEHICULOS',$titulo,$fechainicial,$fechafinal,false);;
        
		if(isset($arraypost["Html"])){
			$data['imprimir']=true;
			$this->load->view("include/plantilla4",$data);
		}
		else if(isset($arraypost["pdf"])){
			/*
			$data['imprimir']=false;
			$nombrearchivo="informe_de_vehiculos_".date('YmdHis').".pdf";
			$html=$this->load->view("informes/infoconductores_res_view",$data, true);
			$this->generar($html, $nombrearchivo);
			*/
		}
		else if(isset($arraypost["excel"])){
			$data['imprimir']=false;
			$data['tiporeporte']="excel";
			$data['nombrearchivo']="informe_de_vehiculos_".date('YmdHis').".xls";
			$this->load->view("include/plantilla4",$data);           
		}
    }
    
}
/* End of file infovehiculos.php */
/* Location: ./application/controllers/informes/infovehiculos.php */