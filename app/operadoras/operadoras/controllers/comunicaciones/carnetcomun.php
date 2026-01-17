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
		$this->load->model('Usuario');
		$this->load->library('funciones');
		$this->load->library('tabla');
        $this->arrayRequest=$this->funciones->convRequest($_REQUEST);
        $login=$this->session->userdata('loginusuarioactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idvehiculoradiotelefono']) && !isset($this->arrayRequest['idconductor']))
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
	public function index($array_datos)
	{
		//se pasa el mensaje al array final que sera pasado a la vista
		$data['mensaje_confirmacion']=$this->load->view('include/mensaje_confirmacion',$array_datos['mensaje']);
		//se configura la vista a mostrar
        $data['vista_contenido_mod']=array("comunicaciones/carnetcomun_view");

		//$jsbuscar = "buscaRegistro('".site_url('conductores/data/buscarconductorrefrendacion')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Conductores','#busqueda')";
        $jsbuscar ="";
		$param=$this->Usuario->getPermisos();
        $this->load->library('botoneria',$param);
		
		$existeinfo = 0;
		$datos=array();
		
		$idcarnetcomunicacion=$this->arrayRequest['idcarnetcomunicacion'];
		$idvehiculoradiotelefono=$this->arrayRequest['idvehiculoradiotelefono'];
		if(!empty($idcarnetcomunicacion))
		{
			$cond=array('idcarnetcomunicacion'=>$this->arrayRequest['idcarnetcomunicacion']);
            $datoscarnet = $this->tabla->consultarDatos("*",$cond,"","","","");
            $existeinfo = 1;
            $data['disabled']="disabled='disabled'";
			//se consultan los datos del vehiculoradiotelefono
			$datos = $this->Refrendacion_model->consultavehiculoradiotelefono($datoscarnet[0]['idvehiculoradiotelefono']);
			
			$data['datonumerocarnet']=   $datos[0]['numerocarnet'];
			$data['datofechacarnet'] =   $this->funciones->convertirFormatoFecha($datos[0]['fechacarnet'],"aaaa-mm-dd","dd/mm/aaaa");
			
		}
		elseif(!empty($idvehiculoradiotelefono) && !isset($this->arrayRequest['Guardar']))
		{
			$this->tabla->settabla('carnetcomunicacion');
			$data['datonumerocarnet'] =   $this->tabla->MaximoDato("numerocarnet") + 1;
			$data['datofechacarnet'] = date("d/m/Y");

			//se consultan los datos del vehiculoradiotelefono
			$datos = $this->Refrendacion_model->consultavehiculoradiotelefono($idvehiculoradiotelefono);
			
            $existeinfo = 0;
		}
		$data['datoidvehiculoradiotelefono']=   $datos[0]['idvehiculoradiotelefono'];
		$data['datoserieradiotelefono']    	=   $datos[0]['serieradiotelefono'];
		$data['datonombremarcaradio']       =   html_entity_decode($datos[0]['nombremarcaradio']);
		$data['datonombremodeloradio']		=   html_entity_decode($datos[0]['nombremodeloradio']);
		$data['datoidvehiculo']    			=   $datos[0]['idvehiculo'];
		$data['datoidvehiculomega']    		=   $datos[0]['idvehiculomega'];
		$data['datoplaca']   				=   $datos[0]['placa'];
		$data['datonombremarcavehiculo']    =   $datos[0]['nombremarcavehiculo'];
		$data['datonombremodelo']    		=	$datos[0]['nombremodelo'];
		$data['datonumeromega']    			=   $datos[0]['numeromega'];
		if(!empty($data['datoidvehiculo'])){
			$data['propietarios'] = $this->Refrendacion_model->consultarvehiculopropietariocarnet($data['datoidvehiculo']);
		}

        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Guarda la informacion de las refrendaciones de las tarjetas de control
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		//se setea la tabla a modificar
        $this->tabla->settabla('carnetcomunicacion');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;

        $campos['idvehiculoradiotelefono']  =   $arraypost['idvehiculoradiotelefono'];
		$campos['idvehiculomega']  			=   $arraypost['idvehiculomega'];
		$campos['idvehiculopropietario']  	=   $arraypost['idvehiculopropietario'];
        $campos['fechacarnet']    =   $this->funciones->convertirFormatoFecha($arraypost['fechacarnet']);
                 
        if($arraypost["Guardar"]=="Guardar")
        {
			$campos['idcarnetcomunicacion'] =   $this->tabla->MaximoDato("idcarnetcomunicacion") + 1;
			$campos['numerocarnet']      	=   $this->tabla->MaximoDato("numerocarnet") + 1;
			$this->tabla->agregarDatos($campos);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";

			
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idcarnetcomunicacion' => $arraypost['idcarnetcomunicacion']);
            $this->tabla->actualizarDatos($campos,$condicion);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
        }
        $this->index($array_datos);
    }
	

}
/* End of file refrendacion.php */
/* Location: ./application/controllers/formatos/carnetcomun.php */