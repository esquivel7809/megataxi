<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Planilla extends CI_Controller {
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
		//inicializamos variables
		$idplanilla=$this->arrayRequest['idplanilla'];
		
		if(!empty($idplanilla))
		{
			//se consultan los datos del conductor
			$datos = $this->Refrendacion_model->cons_dat_planilla($idplanilla);
			
            $data['datonumeroplanilla']     	=   html_entity_decode($datos[0]['numeroplanilla']);
			$data['datonombreempresa']     		=   html_entity_decode($datos[0]['nombreempresa']);
			$data['datonitempresa']     		=   html_entity_decode($datos[0]['nitempresa']);
			$data['datolugarorigen']     		=   html_entity_decode($datos[0]['lugarorigen']);			
			$data['datofechainicio']    		=   $this->funciones->convertirFormatoFecha($datos[0]['fechainicio'],'aaaa-mm-dd','dd-mm-aaaa');
			$data['datolugardestino']     		=   html_entity_decode($datos[0]['lugardestino']);
			$data['datociudaddestino']     		=   html_entity_decode($datos[0]['ciudaddestino']); //se coloca para poder guardar varias ciudades de destino
			$data['datofecharegreso']    		=   $this->funciones->convertirFormatoFecha($datos[0]['fecharegreso'],'aaaa-mm-dd','dd-mm-aaaa');
			$data['datonombrecontratante']  	=   html_entity_decode($datos[0]['nombrecontratante']);
			$data['datoidtipodocumento']    	=   html_entity_decode($datos[0]['idtipodocumento']);
			$data['datonumerocontratante']  	=   html_entity_decode($datos[0]['numerocontratante']);
			$data['datodireccion']     			=   html_entity_decode($datos[0]['direccion']);
			$data['datotelefonofijo']     		=   html_entity_decode($datos[0]['telefonofijo']);
			$data['datocantidadpasajeros']  	=   html_entity_decode($datos[0]['cantidadpasajeros']);
			$data['datoplaca']     				=   html_entity_decode($datos[0]['placa']);
			$data['datonombretipovehiculo']		=   html_entity_decode($datos[0]['nombretipovehiculo']);
			$data['datonombremarcavehiculo']	=   html_entity_decode($datos[0]['nombremarcavehiculo']);
			$data['datonombremodelo']     		=   html_entity_decode($datos[0]['nombremodelo']);
			$data['datonumerosoat']     		=   html_entity_decode($datos[0]['numerosoat']);
			$data['datonombreaseguradora']  	=   html_entity_decode($datos[0]['nombreaseguradora']);
			$data['datonumerotarjetaoperacion']	=   html_entity_decode($datos[0]['numerotarjetaoperacion']);
			$data['datonombrecompleto']     	=   html_entity_decode($datos[0]['nombrecompleto']);
			$data['datonumerodocumento']    	=   html_entity_decode($datos[0]['numerodocumento']);
			$data['datonumerolicenciaconductor']=   html_entity_decode($datos[0]['numerolicenciaconductor']);
			$data['datonombrecategoria']    	=   html_entity_decode($datos[0]['nombrecategoria']);
			
		}
		
		$nombrearchivo="Planilla_".$data['datonumeroplanilla']."_".date('YmdHis').".pdf";
		$html=$this->load->view("imprimir/planilla_imp_view",$data, true);
		$margin['left']=13;
		$margin['top']=32; 
		$margin['right']=1;
		$margin['bottom']=5;
		//print_r($magin);
		generar_pdf($html, $nombrearchivo, $margin );
    }

}
/* End of file refrendacion.php */
/* Location: ./application/controllers/formatos/planilla.php */