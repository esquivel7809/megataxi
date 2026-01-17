<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Extracontractual extends CI_Controller {
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
		$this->idempresa=$this->session->userdata('idempresaactual');
        if(!empty($login))
        {
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idextracontractual']))
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
    * Muestra el formulario para el registro del seguro extracontractual de los vehiculos
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
        $data['vista_contenido_mod']=array("parqueautomotor/extracontractual_view");
        $jsbuscar = "buscaRegistro('".site_url('parqueautomotor/data/buscarextracontractual')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Seguros Extra-Contractuales','#busqueda')";
        
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
		
		$datoidaseguradora="";
		
        if( !empty($this->arrayRequest['idextracontractual']) )
        {
			$this->tabla->settabla('extracontractual');
			$cond=array('idextracontractual'=>$this->arrayRequest['idextracontractual']);
            $datos= $this->tabla->consultarDatos("*",$cond,"","","","");
            $existeinfo = 1;
			$data['disabled']="disabled='disabled'";
            $data['datoidextracontractual']     = $datos[0]['idextracontractual'];
			
			//consultamos los datos del vehiculo
			$this->tabla->settabla('vehiculo');
			$condVehiculo=array('idvehiculo'=>$datos[0]['idvehiculo']);
			$datosVehiculo = $this->tabla->consultarDatos("idvehiculo, placa",$condVehiculo,"","","","");
            $data['datoidvehiculo']     = $datosVehiculo[0]['idvehiculo'];
			$data['datoplaca']          = $datosVehiculo[0]['placa'];
						
            $datoidaseguradora          = $datos[0]['idaseguradora'];
            $data['datonumeroextracontractual']     = $datos[0]['numeroextracontractual'];
            $data['datofechainicial']   = $this->funciones->convertirFormatoFecha($datos[0]['fechainicial'],"aaaa-mm-dd","dd/mm/aaaa");
            $data['datofechafinal']     = $this->funciones->convertirFormatoFecha($datos[0]['fechafinal'],"aaaa-mm-dd","dd/mm/aaaa");
            $data['datoactivo'] = ($datos[0]['activo']==1) ? 'checked="checked"' : ' ';
			
		}
        
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        /**** se consultan las aseguradoras ***/
		$arrayAseguradoras=$this->funciones->consAseguradora();
        $data['aseguradoras']=$this->funciones->crearCombo($arrayAseguradoras, $datoidaseguradora, 'idaseguradora', 'nombreaseguradora');
        /**************/
        
        
        $this->load->view('include/plantilla3',$data);
    }
    
    /**
    * Guarda la informacion del seguro extracontractual de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		//se setea la tabla a modificar
        $this->tabla->settabla('extracontractual');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
        
        $campos['idvehiculo']               =   $arraypost['idvehiculo'];
		$campos['idempresa']   				=	$this->idempresa;
        $campos['idaseguradora']            =   $arraypost['idaseguradoraextra'];
        $campos['numeroextracontractual']   =   $arraypost['numeroextracontractual'];
        $campos['fechainicial']             =   $this->funciones->convertirFormatoFecha($arraypost['fechainicialextra']);
        $campos['fechafinal']               =   $this->funciones->convertirFormatoFecha($arraypost['fechafinalextra']);
        $campos['activo'] 			=	( $arraypost['activo']=='on' ) ? 1 : 0 ;
        
        if($arraypost["Guardar"]=="Guardar")
        {
            //se inactivan los Seg. Contractuales anteriores activo = 0
            $condicionInactiva = array('idvehiculo' => $arraypost['idvehiculo'], 'idempresa'=> $this->idempresa);
            $camposInactiva['activo']   =  0;
            $this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
            
            $campos['idextracontractual']      =   $this->tabla->MaximoDato("idextracontractual") + 1;
            $this->tabla->agregarDatos($campos);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idextracontractual' => $arraypost['idextracontractual']);
            $this->tabla->actualizarDatos($campos,$condicion);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }
        $this->index($array_datos);
    }
    
}
/* End of file extracontractual.php */
/* Location: ./application/controllers/parqueautomotor/extracontractual.php */