<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Renotarope extends CI_Controller {
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
		//cargamos el modelo de la refrendacion
        $this->load->model('Refrendacion_model');
		$this->load->model('Usuario');
		$this->load->library('funciones');
		$this->load->library('tabla');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idrefrendacion']) && !isset($this->arrayRequest['idconductor']))
            {
                //terminar_session();
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
    * Muestra el formulario de registro de las refrendaciones de las tarjetas de control
    *
    * @access public
    * @param string
    * @return string
    */
	public function index()
	{
        $data['vista_contenido_mod']=array("formatos/renotarope_view");
		
        //Array que define los titulos que llevaran los criterios
        $Titulo=array('Placa');
        //Array que define los campos id' de los criterios en laBD
        $CamposId=array('idvehiculo');
        //Array que define la ruta para la busqueda
        $rutaBusqueda=array(site_url('formatos/data/consultarvehiculo'));
        //Array que define otras condiciones
        $otrasCondiciones=array('','','');
        
        $data['filtros'] = $this->informes->visualizaFiltros($Titulo,$CamposId,$rutaBusqueda,$otrasCondiciones);

        
        // Se consultan los permisos para la botoneria
		$param=$this->Usuario->getPermisos();
        $this->load->library('botoneria',$param);
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        $this->load->view('include/plantilla3',$data);
    }
    
}
/* End of file refrendacion.php */
/* Location: ./application/controllers/formatos/tarjetacontrol.php */