<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Carnetcomun extends CI_Controller {
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
		ob_start();
        $data['vista_contenido_mod']=array("imprimir/carnetcomun_imp_view");
		
		//inicializamos variables
		$idcarnetcomunicacion=$this->arrayRequest['idcarnetcomunicacion'];
		
		if(!empty($idcarnetcomunicacion))
		{
			//se consultan los datos del conductor
			$datos = $this->Refrendacion_model->cons_dat_carnetcomunicacion($idcarnetcomunicacion);
//print_r($datos);
			
            $existeinfo = 1;
            $data['datonumerocarnet']     =   html_entity_decode($datos[0]['numerocarnet']);
			$data['datofechacarnet']    =   $this->funciones->convertirFormatoFecha($datos[0]['fechacarnet'],'aaaa-mm-dd','dd-mm-aaaa');
			$data['datonumeromega']     =   html_entity_decode($datos[0]['numeromega']);
			$data['datonombrecompleto']     =   html_entity_decode($datos[0]['nombrecompleto']);
			$data['datonumerodocumento']     =   html_entity_decode($datos[0]['numerodocumento']);
			$data['datolugarexpedicion']     =   html_entity_decode($datos[0]['nombremunicipio']);
			$data['datonombremarcavehiculo']     =   html_entity_decode($datos[0]['nombremarcavehiculo']);
			$data['datonombretipovehiculo']     =   html_entity_decode($datos[0]['nombretipovehiculo']);
			$data['datoidtipovehiculo']     =   html_entity_decode($datos[0]['idtipovehiculo']);
			$data['datonombremodelo']     =   html_entity_decode($datos[0]['nombremodelo']);
			$data['datoplaca']     =   html_entity_decode($datos[0]['placa']);
			$data['datonombremarcaradio']     =   html_entity_decode($datos[0]['nombremarcaradio']);
			$data['datonombremodeloradio']     =   html_entity_decode($datos[0]['nombremodeloradio']);
			$data['datoserieradiotelefono']     =   html_entity_decode($datos[0]['serieradiotelefono']);
		}
		
		$nombrearchivo="Carnet_de_comunicacion_".$data['datonumerocarnet']."_".date('YmdHis').".pdf";
		$html=$this->load->view("imprimir/carnetcomun_imp_view",$data, true);
		ob_clean();
		generar_pdf($html, $nombrearchivo);
    }

}
/* End of file refrendacion.php */
/* Location: ./application/controllers/formatos/carnetcomun.php */
