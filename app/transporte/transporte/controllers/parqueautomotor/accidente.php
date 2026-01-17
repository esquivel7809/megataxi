<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accidente extends CI_Controller {
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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idvehiculopropietario']))
            {
                terminar_session();
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
    * Muestra el formulario para el registro de accidentes de los vehiculos
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
        $data['vista_contenido_mod']=array("parqueautomotor/accidente_view");
        //$jsbuscar = "buscaRegistro('".base_url()."index.php/conductores/data/buscarconductor','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Conductores','#busqueda')";
        
        /***  Se consultan los permisos para la botoneria    ***/
        
        $sqlPermisos="SELECT modificar,consultar,eliminar
        			  FROM   perfilsubmodulo 
        			  WHERE	 idperfilusuario='".$_SESSION['idperfilactual']."' AND 
        			  		 idsubmodulo='".$_SESSION['idsubmoduloactual']."'";
        $consultaPersmisos = $this->db->query($sqlPermisos);
        
        $rowPermisos=$consultaPersmisos->row();
        $consultaPersmisos->free_result();
        $param= array('modificar' => $rowPermisos->modificar,'consultar' => $rowPermisos->consultar ,'eliminar' => $rowPermisos->eliminar);
        $this->load->library('botoneria',$param);
        
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Guarda la informacion de los propietarios de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		//se setea la tabla a modificar
        $this->tabla->settabla('vehiculoaccidente');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;

        $campos['idvehiculoconductor']      =   $arraypost['idvehiculoconductor'];
		$campos['idempresa']   		=	$this->idempresa;
        $campos['fechaaccidente']   =   $this->funciones->convertirFormatoFecha($arraypost['fecha_accidente']);
		$campos['descripcion']      =   $arraypost['descripcion'];
		$campos['lecciones']      	=   $arraypost['lecciones'];
		
        if($arraypost["Guardar"]=="Guardar")
        {
            $campos['idvehiculoaccidente']      =   $this->tabla->MaximoDato("idvehiculoaccidente") + 1;
            $this->tabla->agregarDatos($campos);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }/*
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idvehiculopropietario' => $arraypost['idvehiculopropietario']);
            $this->tabla->actualizarDatos($campos,$condicion);
        }*/
        
        $this->index($array_datos);
    }
    
}
/* End of file accidente.php */
/* Location: ./application/controllers/parqueautomotor/accidente.php */