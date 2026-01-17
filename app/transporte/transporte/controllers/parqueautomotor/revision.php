<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Revision extends CI_Controller {
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
            if(empty($this->arrayRequest['idsubmoduloactual']) && !isset($this->arrayRequest['idrevision']))
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
    * Muestra el formulario para el registro de los certificados de revision tecnicomecanico de los vehiculos
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
        $data['vista_contenido_mod']=array("parqueautomotor/revision_view");
        $jsbuscar = "buscaRegistro('".site_url('parqueautomotor/data/buscarrevision')."','divbuscar=busqueda&formulario=this.form.id',280,600,'Busqueda de Revisiones Tecnico-Mecanicas','#busqueda')";
        
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
		
		$datoidcda="";
		
        if( !empty($this->arrayRequest['idrevision']) )
        {
			$this->tabla->settabla('revision');
			$cond=array('idrevision'=>$this->arrayRequest['idrevision']);
            $datos= $this->tabla->consultarDatos("*",$cond,"","","","");
            $existeinfo = 1;
			$data['disabled']="disabled='disabled'";
            $data['datoidrevision']     = $datos[0]['idrevision'];
			
			//consultamos los datos del vehiculo
			$this->tabla->settabla('vehiculo');
			$condVehiculo=array('idvehiculo'=>$datos[0]['idvehiculo']);
			$datosVehiculo = $this->tabla->consultarDatos("idvehiculo, placa",$condVehiculo,"","","","");
            $data['datoidvehiculo']     = $datosVehiculo[0]['idvehiculo'];
			$data['datoplaca']          = $datosVehiculo[0]['placa'];
						
            $datoidcda 					= $datos[0]['idcda'];
            $data['datonumerorevision'] = $datos[0]['numerorevision'];
            $data['datofechainicial']   = $this->funciones->convertirFormatoFecha($datos[0]['fechainicial'],"aaaa-mm-dd","dd/mm/aaaa");
            $data['datofechafinal']     = $this->funciones->convertirFormatoFecha($datos[0]['fechafinal'],"aaaa-mm-dd","dd/mm/aaaa");
            $data['datoactivo'] = ($datos[0]['activo']==1) ? 'checked="checked"' : ' ';
			
		}
        
        $data['botoneria']= $this->botoneria->visualizaBotoneria($existeinfo,"",$jsbuscar,"");
        
        // se consultan los cda
		$arrayCda=$this->funciones->consCda("", "WHERE ciudadcda='IBAGUE'");
        $data['cda']=$this->funciones->crearCombo($arrayCda, $datoidcda, 'idcda', 'nombrecda');
        
        $this->load->view('include/plantilla3',$data);
    }
    
    
    /**
    * Guarda la informacion de los certificados de revision tecnicomecanico de los vehiculos
    *
    * @access public
    * @param string
    * @return string
    */
    public function registro()
    {
		//se setea la tabla a modificar
        $this->tabla->settabla('revision');
		//se reciben las variables por POST
        $arraypost=$this->input->post();
		//se activa mostrar el mensaje
		$array_datos['mensaje']['mostrar_mensaje']=true;
        $campos['idvehiculo']       =   $arraypost['idvehiculo'];
		$campos['idempresa']   		=	$this->idempresa;
        $campos['idcda']            =   $arraypost['idcda'];
        $campos['numerorevision']   =   $arraypost['numerorevision'];
        $campos['fechainicial']     =   $this->funciones->convertirFormatoFecha($arraypost['fechainicialrevision']);
        $campos['fechafinal']       =   $this->funciones->convertirFormatoFecha($arraypost['fechafinalrevision']);
        $campos['activo'] 			=	( $arraypost['activo']=='on' ) ? 1 : 0 ;
        
        if($arraypost["Guardar"]=="Guardar")
        {
			//se consulta si la revision ya existe
            $condicionOtraRevision = array('numerorevision' => $arraypost['numerorevision'], 'idempresa'=> $this->idempresa);
            $arrayOtraRevision=$this->tabla->consultarDatos('*',$condicionOtraRevision);
			if(!empty($arrayOtraRevision)){
				//la placa ya esta registrada
				$array_datos['mensaje']['msg']="El numero de revision ".$arraypost['numerorevision']." ya esta registrada";
				$array_datos['mensaje']['class']="error";
			}else{
				//se inactivan los soat anteriores activo = 0
				$condicionInactiva = array('idvehiculo' => $arraypost['idvehiculo'], 'idempresa'=> $this->idempresa);
				$camposInactiva['activo']   =  0;
				$this->tabla->actualizarDatos($camposInactiva,$condicionInactiva);
				
				$campos['idrevision']      =   $this->tabla->MaximoDato("idrevision") + 1;
				$this->tabla->agregarDatos($campos);
				$array_datos['mensaje']['msg']=$this->tabla->mensaje;
				$array_datos['mensaje']['class']="exito";
			}
        }
        elseif($arraypost["Guardar"]=="Modificar")
        {
            $condicion = array('idrevision' => $arraypost['idrevision']);
            $this->tabla->actualizarDatos($campos,$condicion);
			$array_datos['mensaje']['msg']=$this->tabla->mensaje;
			$array_datos['mensaje']['class']="exito";
        }
        $this->index($array_datos);
    }
    
}
/* End of file revision.php */
/* Location: ./application/controllers/parqueautomotor/revision.php */