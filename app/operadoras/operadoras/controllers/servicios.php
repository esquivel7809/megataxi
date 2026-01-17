<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Servicios extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
        parent::__construct(); 
        if(consultar_session()){
	        $this->load->library('funciones');
			$this->load->library('tabla');
			$this->load->model('Usuario');
			$this->load->model('Servicios_model');
	        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
			//$this->idempresa=getIdempresaactual();
			//$this->idsubmoduloactual=$this->arrayRequest['idsubmoduloactual'];
			/*
            if(empty($this->idsubmoduloactual) && !isset($this->arrayRequest['idgarantia']))
            {
                terminar_session();
            }
			 * */
        }

        //$this->load->model('Usuario');
		//$this->load->model('Informes_model');
    }
	public function index()
	{
        //$login=$this->session->userdata('loginusuarioactual');
		//$idempresa=$this->session->userdata('idempresaactual');
        
        //if(!empty($login))
        //{
            //$this->load->library('menu',array('idperfil'=>'getIdperfilactual()'));
            
            $data['vista_contenido_mod']=array("servicios_view");
			/*
            $data['menu']=$this->menu->menuModulosHTML5();
			$data['menuH']=$this->menu->menuModulosHorizontalHTML5();
			
            
            $datosempresa=$this->Usuario->datosEmpresa($this->idempresa);
            $data['nombreempresa']=$datosempresa['nombreempresa'];
            $data['nitempresa']=$datosempresa['nitempresa'];
            $data['direccionempresa']=$datosempresa['direccionempresa'];
            $data['telefonoempresa']=$datosempresa['telefonoempresa'];
            $data['rutalogo']=$datosempresa['rutalogo'];
			*/
			
			
			//
			//$datosServicios = $this->Servicios_model->getServicios();
			$datosServicios = $this->Servicios_model->getServiciosConReportados();
			
			$data['datosServicios']=$datosServicios;
			//print_r($datosServicios);
			
			
			
			
			//cargamos la vista final
            $this->load->view('include/plantilla2',$data);
        }

		public function getServiciosConReportados(){
			print_r($this->Servicios_model->getServiciosConReportados());
		}
		public function getServicios(){
			print_r($this->Servicios_model->getServicios());
		}
				
		

/**
        else
        {
            $this->session->destroy();
			redirect('inicio/', 'refresh');
        }
 
    }
 * **/
}
/* End of file inicio.php */
/* Location: ./application/controllers/modulos/inicio.php */