<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Infoaccidente extends CI_Controller {

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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idinfosoat']))
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
        $data['vista_contenido_mod']=array("informes/infoaccidente_view");
        
        //Array que define los titulos que llevaran los criterios
        $Titulo=array('Conductor','Vehiculo');
        //Array que define los nombres de los campos en la cual se digitara la cadena a buscar
        $CamposBusqueda=array('idconductor','idvehiculo');
        //Array que define los nombre de los campos en el cual se almacenaran lo valores seleccionados para la codicion de la consulta
        $CamposLista=array('valoridconductor','valoridvehiculo');
        //Array que define los id's de las capas en la cual se listaran los criterios ya elegidos
        $CapaLista=array('listaconductor','listavehiculo');
        //Array que define los id's de las capas en el que se listaran los datos del autocompletar
        $CapaBusqueda=array('busquedaconductor','busquedavehiculo');
        //Array que define los nombres de las tablas de los criterios
        $Tablas=array('conductor','vehiculo');
        //Array que define los campos id' de los criterios en laBD
        $CamposId=array('idconductor','idvehiculo');
        //Array que define los campos nombres de los criterios en la BD
        $CamposNombre=array('nombrecompleto','placa');
        //Array que define otras condiciones
        $otrasCondiciones=array('','','','','','');
        
        $data['filtros'] = $this->informes->visualizaFiltros($Titulo,$CamposBusqueda,$CamposLista,$CapaLista,$CapaBusqueda,$Tablas,$CamposId,$CamposNombre,"",$otrasCondiciones);

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
        $data['vista_contenido_mod']=array("informes/infoaccidente_res_view");
        $titulo="";
        $arraypost=$this->input->post();
        $valoridconductor     =   $arraypost['valoridconductor'];
        $valoridvehiculo        =   $arraypost['valoridvehiculo'];
        $lecciones          =   $arraypost['lecciones'];
        $fechainicial=$this->funciones->convertirFormatoFecha($arraypost['fechainicial']);
        $fechafinal=$this->funciones->convertirFormatoFecha($arraypost['fechafinal']);
        
        /***** Condicion de las fechas ********/
        $condfecha=" AND va.fechaaccidente>='".$fechainicial."' AND va.fechaaccidente<='".$fechafinal."'";
        
        /**Otros Filtros*/
        if($lecciones=='1')
        {
            $titulo.="Ninguna persona leccionada";
        	$condlecciones=" va.lecciones='1'";
        }
        elseif($lecciones=='2')
        {
            $titulo.="Personas Muertas";
        	$condlecciones=" va.lecciones='2'";
        }
        elseif($lecciones=='3')
        {
            $titulo.="Personas Heridas";
        	$condlecciones=" va.lecciones='3'";
        }
        elseif($lecciones=='4')
        {
            $titulo.="Personas Muertas y Heridas";
        	$condlecciones=" va.lecciones='4'";
        }
        else
        {
            $titulo.="Todo";
        	$condlecciones=" 1";
        }
        /*****/
        
        $titulo.="<br />";
        
        /******Filtros*****/            
        if($valoridconductor!="")
        {
        	$titulo.=$this->informes->tituloFiltro($valoridconductor,'conductor',array('idconductor'),'nombrecompleto','Conductor');
        	$condicionconductor=" AND c.idconductor IN (".stripslashes($valoridconductor).")";
        }
        if($valoridvehiculo!="")
        {
        	$titulo.=$this->informes->tituloFiltro($valoridvehiculo,'vehiculo',array('idvehiculo'),'placa','Vehiculo');
        	$condicionvehiculo=" AND v.idvehiculo IN (".stripslashes($valoridvehiculo).")";
        }
        /************/
        
        /**** Campos a Consultar *******/
        $sqlselect="va.fechaaccidente, va.descripcion, va.lecciones, v.placa, c.nombrecompleto, c.numerodocumento ";
        
        /***** Relacion de Tablas *****/
        $sqlfrom="FROM vehiculoaccidente AS va
				INNER JOIN vehiculoconductor AS vc ON vc.idvehiculoconductor=va.idvehiculoconductor
                INNER JOIN conductor AS c ON c.idconductor=vc.idconductor
                INNER JOIN vehiculo AS v ON v.idvehiculo=vc.idvehiculo
                ";
                
        /****** Condicion *******/
        $sqlcondicion=$condfecha.$condicionconductor.$condicionvehiculo;
        
        /***** Consulta completa********/
        $sqlconsulta="SELECT ".$sqlselect.$sqlfrom." WHERE".$condlecciones.$sqlcondicion;
        
        /***** Datos que pasan a la vista *****/            
        $data['result']=$this->db->query($sqlconsulta);
        $data['arraylecciones']=array('1'=>'Ninguna','2'=>'Heridas','3'=>'Muertas','4'=>'Ambas');
        $data['tiporeporte']=$arraypost['tiporeporte'];
        $data['tituloInfo']=$this->informes->encabezadoInforme('INFORME DE ACCIDENTES DE VEHICULOS',$titulo,$fechainicial,$fechafinal,true);;
        
        $this->load->view("include/plantilla4",$data);           
    }
    
}
/* End of file infoaccidente.php */
/* Location: ./application/controllers/informes/infoaccidente.php */